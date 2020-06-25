<?php


namespace Hulotte\Commands;

use Symfony\Component\Console\{
    Command\Command,
    Input\InputInterface,
    Output\OutputInterface
};

/**
 * Class InitCommand
 * @author Sébastien CLEMENT<s.clement@la-taniere.net>
 * @package Hulotte\Commands
 */
class InitCommand extends Command
{
    /**
     * Configures the current command
     */
    protected function configure(): void
    {
        $this
            ->setName('init')
            ->setDescription('Initialize project')
            ->setHelp('Create basic folders and files for a web project');
    }

    /**
     * Executes the current command
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->createHtaccessFile($output);
        $this->createFolder('public', $output);
        $this->createIndexFile($output);
        $this->createFolder('src', $output);

        $output->writeln('Your project is initialized.');

        return Command::SUCCESS;
    }

    /**
     * Create a folder and send a validation message
     * @param string $folderName
     * @param OutputInterface $output
     */
    private function createFolder(string $folderName, OutputInterface $output): void
    {
        if (!file_exists($folderName)) {
            mkdir($folderName);

            $output->writeln('The folder "' . $folderName . '" is created.');
        }
    }

    /**
     * Create .htaccess file with :
     *  - indexation disabled
     *  - prevent being embedded in a frame
     *  - prevent sniffing files
     *  - url rewriting
     * @param OutputInterface $output
     */
    private function createHtaccessFile(OutputInterface $output): void
    {
        if (!file_exists('.htaccess')) {
            $htaccessFile = fopen('.htaccess', 'a+');
            $content = require __DIR__ . '/templates/htaccess.php';
            fputs($htaccessFile, $content);
            fclose($htaccessFile);

            $output->writeln('.htaccess file is created.');
        }
    }

    /**
     * Create and fill index.php file
     * @param OutputInterface $output
     */
    private function createIndexFile(OutputInterface $output): void
    {
        if (!file_exists('public/index.php')) {
            $indexFile = fopen('public/index.php', 'a+');
            $content = require __DIR__ . '/templates/index.php';
            fputs($indexFile, $content);
            fclose($indexFile);

            $output->writeln('The file "public/index.php" is created.');
        }
    }
}
