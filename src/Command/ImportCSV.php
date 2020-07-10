<?php


namespace App\Command;

use App\Entity\Library;
use App\Utils\CSV;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class ImportCSV extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:import-data';
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('import:csv')
            ->setDescription('Import data from CSV file')
            ->addOption("path", null, InputOption::VALUE_OPTIONAL, "Path to the dataset CSV", "var/csv/dataset.csv");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $content = "";
        $path = $input->getOption('path');
        $real_path = __DIR__ . "/../../" . $path;
        $rows = array();
        //Get the file
        if (file_exists($real_path)) {
            $csv = new CSV($real_path);
            $rows = $csv->csvToArray();
        }
        //if empty csv or file not found
        if (!empty($rows)) {
            $helper = $this->getHelper('question');
            $question = new ConfirmationQuestion(
                "Etes vous sûr de vouloir importer les données? y|n \n",
                false,
                '/^(y|j)/i'
            );

            if ($helper->ask($input, $output, $question)) {
                // Turning off doctrine default logs queries for saving memory
                $this->em->getConnection()->getConfiguration()->setSQLLogger(null);

                // Define the size of record, the frequency for persisting the data and the current index of records
                $size = count($rows);
                $batchSize = 20;
                $i = 1;

                // Starting progress
                $progress = new ProgressBar($output, $size);
                $progress->start();


                // Processing on each row of data
                foreach ($rows as $row) {
                    $library = new Library();

                    //set object
                    $library
                        ->setTitle($row['Titre'])
                        ->setName($row['Nom'])
                        ->setFirstname($row['Prenom'])
                        ->setEditor($row['Editeur'])
                        ->setBookFormat($row['Format livre'])
                        ->setType($row['Type'])
                        ->setSection($row['Section']);
                    $this->em->persist($library);

                    // Each 20 users persisted we flush everything
                    if (($i + 1 % $batchSize) === 0) {
                        $this->em->flush();
                        // Detaches all objects from Doctrine for memory save
                        $this->em->clear();

                        // Advancing for progress display on console
                        $progress->advance($batchSize);
                        $output->writeln(' of datas imported ... ');
                    }
                    $i++;
                }

                // Flushing and clear data on queue
                $this->em->flush();
                $this->em->clear();

                // Ending the progress bar process
                $progress->finish();
            }
            return Command::SUCCESS;
        } else {
            $output->writeln("Erreur CSV vide");
            return Command::FAILURE;
        }


    }
}