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

namespace ThreenityCMS\Commands\Rbac;

use ThreenityCMS\Helpers\Security;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeassignRbac extends Command
{
    protected function configure()
    {
        $this
            ->setName('rbac:deassign')
            ->setDescription('Deassign RBAC item to a user group. (Use -- -1 for de developer group)')
            ->addArgument('group_id', InputArgument::REQUIRED, 'User group.')
            ->addArgument('rbac_id', InputArgument::REQUIRED, 'RBAC item.')
            ->setHelp("This command allows you to deassign RBAC item to a user group.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {

            Security::removeAssignment($input->getArgument('group_id'), $input->getArgument('rbac_id'));

            $output->writeln('<info>[RBAC]</info>');
            $output->writeln('<info>ID : ' . $input->getArgument('rbac_id') . '</info>');
            $output->writeln('<info>GROUP : ' . $input->getArgument('group_id') . '</info>');
            $output->writeln('<info>Successfuly deassigned</info>');

        } catch (Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
        }
    }
}