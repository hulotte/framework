<?php

namespace Hulotte\Commands;

use Symfony\Component\Console\{
    Command\Command,
    Input\InputArgument,
    Input\InputInterface,
    Output\OutputInterface
};

/**
 * Class ModuleCommand
 * @author Sébastien CLEMENT<s.clement@la-taniere.net>
 * @package Hulotte\Commands
 */
class ModuleCommand extends Command
{
    /**
     * @var string
     */
    private string $moduleName = '';

    /**
     * @var string
     */
    private string $modulePath = '';

    /**
     * Configures the current command
     */
    protected function configure(): void
    {
        $this
            ->setName('module:create')
            ->setDescription('Create new module')
            ->setHelp('Create basic folders and files for a new module')
            ->addArgument('moduleName', InputArgument::REQUIRED, 'The name of the module');
    }

    /**
     * Execute the current command
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->moduleName = ucfirst($input->getArgument('moduleName'));
        $output->writeln('Creating ' . $this->moduleName . ' folders and files.');

        if (!file_exists('src')) {
            mkdir('src');
        }

        $this->createModuleFolder();
        $this->createModuleController();
        $this->createConfigFile();
        $this->createIndexControllerFolderAndFile();
        $this->createViewsFolderAndFile();
        $this->createDatabaseFolders();

        $output->writeln($this->moduleName . ' module is created.');

        return Command::SUCCESS;
    }

    /**
     * Create the config php file
     */
    private function createConfigFile(): void
    {
        if (!file_exists($this->getModulePath() . '/config.php')) {
            $configFile = fopen($this->getModulePath() . '/config.php', 'a+');
            $content = require __DIR__ . '/templates/config.php';
            fputs($configFile, $content);
            fclose($configFile);
        }
    }

    /**
     * Create folder for database migrations and seeds
     */
    private function createDatabaseFolders(): void
    {
        if (!file_exists($this->getModulePath() . '/database')) {
            mkdir($this->getModulePath() . '/database');
        }

        if (!file_exists($this->getModulePath() . '/database/migrations')) {
            mkdir($this->getModulePath() . '/database/migrations');
        }

        if (!file_exists($this->getModulePath() . '/database/seeds')) {
            mkdir($this->getModulePath() . '/database/seeds');
        }
    }

    /**
     * Create Controllers folder and index page controller
     */
    private function createIndexControllerFolderAndFile(): void
    {
        if (!file_exists($this->getModulePath() . '/Controllers')) {
            mkdir($this->getModulePath() . '/Controllers');
        }

        if (!file_exists($this->getModulePath() . '/Controllers/IndexController.php')) {
            $moduleController = fopen($this->getModulePath() . '/Controllers/IndexController.php', 'a+');
            $content = require __DIR__ . '/templates/indexController.php';
            $content = str_replace('%MODULE_NAME%', $this->moduleName, $content);
            $content = str_replace('%RENDER_PATH%', lcfirst($this->moduleName), $content);
            fputs($moduleController, $content);
            fclose($moduleController);
        }
    }

    /**
     * Create the module controller php file
     */
    private function createModuleController(): void
    {
        $fileName = $this->moduleName . 'Module.php';

        if (!file_exists($this->getModulePath() . '/' . $fileName)) {
            $moduleController = fopen($this->getModulePath() . '/' . $fileName, 'a+');
            $content = require __DIR__ . '/templates/moduleController.php';
            $content = str_replace('%MODULE_NAME%', $this->moduleName, $content);
            $content = str_replace('%RENDER_PATH%', lcfirst($this->moduleName), $content);
            fputs($moduleController, $content);
            fclose($moduleController);
        }
    }

    /**
     * Create folder for the module
     */
    private function createModuleFolder(): void
    {
        if (!file_exists($this->getModulePath())) {
            mkdir($this->getModulePath());
        }
    }

    /**
     * Create views folder and the index view with "hello world" title
     */
    private function createViewsFolderAndFile(): void
    {
        if (!file_exists($this->getModulePath() . '/views')) {
            mkdir($this->getModulePath() . '/views');
        }

        if (!file_exists($this->getModulePath() . '/views/index.twig')) {
            $moduleController = fopen($this->getModulePath() . '/views/index.twig', 'a+');
            $content = require __DIR__ . '/templates/indexView.php';
            fputs($moduleController, $content);
            fclose($moduleController);
        }
    }

    /**
     * Construct the module path with the name of the module
     * @return string
     */
    private function getModulePath(): string
    {
        if (!$this->modulePath) {
            $this->modulePath = 'src/' . $this->moduleName;
        }

        return $this->modulePath;
    }
}
