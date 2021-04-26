<?php

namespace tests\Hulotte\Commands;

use Hulotte\Commands\ModuleCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\{
    Application,
    Tester\CommandTester
};

/**
 * Class ModuleCommandTest
 * @covers \Hulotte\Commands\ModuleCommand
 * @author Sébastien CLEMENT<s.clement@la-taniere.net>
 * @package tests\Hulotte\Commands
 */
class ModuleCommandTest extends TestCase
{
    /**
     * @var string
     */
    private string $moduleName;

    /**
     * @var int
     */
    private int $result;

    /**
     * @var string
     */
    private string $output;

    /**
     * @covers \Hulotte\Commands\ModuleCommand::execute
     * @test
     */
    public function execute(): void
    {
        $this->assertSame(0, $this->result);
        $this->assertStringContainsString(
            'Creating ' . ucfirst($this->moduleName) . ' folders and files.',
            $this->output
        );
        $this->assertDirectoryExists('src/' . ucfirst($this->moduleName));
        $this->assertFileExists('src/' . ucfirst($this->moduleName) . '/' . ucfirst($this->moduleName) . 'Module.php');
        $this->assertFileExists('src/' . ucfirst($this->moduleName) . '/config.php');
        $this->assertDirectoryExists('src/' . ucfirst($this->moduleName) . '/Controllers');
        $this->assertFileExists('src/' . ucfirst($this->moduleName) . '/Controllers/indexController.php');
        $this->assertDirectoryExists('src/' . ucfirst($this->moduleName) . '/views');
        $this->assertFileExists('src/' . ucfirst($this->moduleName) . '/views/index.twig');
        $this->assertStringContainsString(ucfirst($this->moduleName) . ' module is created.', $this->output);
    }

    protected function setUp(): void
    {
        $this->moduleName = 'appTest';
        $application = new Application();
        $application->add(new ModuleCommand());

        $commandTester = new CommandTester($application->find('module:create'));
        $this->result = $commandTester->execute([
            'moduleName' => $this->moduleName,
        ]);
        $this->output = $commandTester->getDisplay();
    }

    protected function tearDown(): void
    {
        if (file_exists('src/' . ucfirst($this->moduleName) . '/' . ucfirst($this->moduleName) . 'Module.php')) {
            unlink('src/' . ucfirst($this->moduleName) . '/' . ucfirst($this->moduleName) . 'Module.php');
        }

        if (file_exists('src/' . ucfirst($this->moduleName) . '/config.php')) {
            unlink('src/' . ucfirst($this->moduleName) . '/config.php');
        }

        if (file_exists('src/' . ucfirst($this->moduleName) . '/Controllers/IndexController.php')) {
            unlink('src/' . ucfirst($this->moduleName) . '/Controllers/IndexController.php');
        }

        if (file_exists('src/' . ucfirst($this->moduleName) . '/Controllers')) {
            rmdir('src/' . ucfirst($this->moduleName) . '/Controllers');
        }

        if (file_exists('src/' . ucfirst($this->moduleName) . '/views/index.twig')) {
            unlink('src/' . ucfirst($this->moduleName) . '/views/index.twig');
        }

        if (file_exists('src/' . ucfirst($this->moduleName) . '/views')) {
            rmdir('src/' . ucfirst($this->moduleName) . '/views');
        }

        if (file_exists('src/' . $this->moduleName)) {
            rmdir('src/' . $this->moduleName);
        }

        if (file_exists('src')) {
            rmdir('src');
        }
    }
}
