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

namespace ThreenityCMS\Commands\Modules;

use ThreenityCMS\Models\Threenity\ModuleModel;
use DOMDocument;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RegisterModules extends Command
{
    protected function configure()
    {
        $this
            ->setName('module:register')
            ->setDescription('Register new modules.')
            ->setHelp("This command allows you to register all new modules with default settings and rights.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = './views/*.{php}';
        foreach (glob($dir, GLOB_BRACE) as $file) {

            $html = file_get_contents($file);
            $html = mb_convert_encoding($html, 'utf-8', mb_detect_encoding($html));

            $DOM = new DOMDocument();
            @$DOM->loadHTML('<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />' . $html);
            $items = $DOM->getElementById('module');

            $result = ModuleModel::register(pathinfo($file)['filename'], $items->nodeValue);

            if ($result == true) {
                if (!empty($items->nodeValue)) {
                    $output->writeln("[Name] : " . pathinfo($file)['filename'] . " [Description] : " . $items->nodeValue . " - [OK]");
                } else {
                    $output->writeln("[Name] : " . pathinfo($file)['filename'] . " [Error] : Nom de module vide - [FAILED]");
                }
            } else {
                $output->writeln("[Name] : " . pathinfo($file)['filename'] . " [Description] : " . $items->nodeValue . " - [FAILED]");
                $output->writeln("Error : " . $result);
            }
        }
    }
}
