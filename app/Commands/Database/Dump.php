<?php
/**
 * Copyright (C) 2014 - 2017 Threenity CMS - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary  and confidential
 * Written by : nicelife90 <yanicklafontaine@gmail.com>
 * Last edit : 2018
 *
 *
 */

namespace ThreenityCMS\Commands\Database;

use ThreenityCMS\Helpers\Database;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Dump extends Command
{
    protected function configure()
    {
        $this
            ->setName('database:dump')
            ->setDescription('Dump current database file to sql file.')
            ->setHelp("This command allow you to to dump main database.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        try {

            /**
             * Find MySql base dir
             */
            $db = Database::get();
            $mysqldump = $db->query("SHOW VARIABLES LIKE 'basedir'")->fetchObject()->Value . "/bin";

            /**
             * Command
             */
            $dbhost = getenv('BDD_HOST');
            $dbuser = getenv("BDD_USER");
            $dbpass = getenv("BDD_PASS");
            $dbname = getenv("BDD_NAME");
            $dumpFile = __DIR__ . "/Dump/" . uniqid() . ".sql";
            $command = "$mysqldump/mysqldump --host=$dbhost --user=$dbuser --password=$dbpass $dbname > $dumpFile";

            passthru($command, $return);
            if ($return) {
                $output->writeln("<error>Une erreur s'est produite avec l'exportation de la base de donnée.</error>");
            } else {
                $output->writeln("<info>La base de données a correctement été exportée dans le fichier : $dumpFile.</info>");
            }

        } catch (Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
        }
    }
}