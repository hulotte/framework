<?php

namespace tests\Hulotte\Commands;

use Hulotte\Commands\InitCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\{
    Application,
    Tester\CommandTester
};

/**
 * Class InitCommandTest
 * @author Sébastien CLEMENT<s.clement@la-taniere.net>
 * @covers \Hulotte\Commands\InitCommand
 * @package tests\Hulotte\Commands
 */
class InitCommandTest extends TestCase
{
    /**
     * @var string
     */
    private string $output;

    /**
     * @covers \Hulotte\Commands\InitCommand::execute
     * @test
     */
    public function execute(): void
    {
        $this->assertStringContainsString('Your project is initialized.', $this->output);
    }

    /**
     * @covers \Hulotte\Commands\InitCommand::execute
     * @test
     */
    public function executeHtaccessFile(): void
    {
        $this->assertFileExists('.htaccess');
        $this->assertStringContainsString('.htaccess file is created.', $this->output);
    }

    /**
     * @covers \Hulotte\Commands\InitCommand::execute
     * @test
     */
    public function executePublicFolder(): void
    {
        $this->assertDirectoryExists('public');
        $this->assertStringContainsString('The folder "public" is created.', $this->output);
    }

    /**
     * @covers \Hulotte\Commands\InitCommand::execute
     * @test
     */
    public function executeIndexFile(): void
    {
        $this->assertFileExists('public/index.php');
        $this->assertStringContainsString('The file "public/index.php" is created.', $this->output);
    }

    /**
     * @covers \Hulotte\Commands\InitCommand::execute
     * @test
     */
    public function executeSrcFolder(): void
    {
        $this->assertDirectoryExists('src');
        $this->assertStringContainsString('The folder "src" is created.', $this->output);
    }

    protected function setUp(): void
    {
        $application = new Application();
        $application->add(new InitCommand());

        $commandTester = new CommandTester($application->find('init'));
        $commandTester->execute([]);

        $this->output = $commandTester->getDisplay();
    }

    protected function tearDown(): void
    {
        if (file_exists('.htaccess')) {
            unlink('.htaccess');
        }

        if (file_exists('public/index.php')) {
            unlink('public/index.php');
        }

        if (is_dir('public')) {
            rmdir('public');
        }

        if (is_dir('src')) {
            rmdir('src');
        }
    }
}
