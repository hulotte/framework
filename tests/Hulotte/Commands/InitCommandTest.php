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
     * @var int
     */
    private int $result;

    /**
     * @covers \Hulotte\Commands\InitCommand::execute
     * @test
     */
    public function execute(): void
    {
        $this->assertSame(0, $this->result);
        $this->assertFileExists('.htaccess');
        $this->assertStringContainsString('.htaccess file is created.', $this->output);
        $this->assertDirectoryExists('public');
        $this->assertStringContainsString('The folder "public" is created.', $this->output);
        $this->assertFileExists('public/index.php');
        $this->assertStringContainsString('The file "public/index.php" is created.', $this->output);
        $this->assertDirectoryExists('src');
        $this->assertStringContainsString('The folder "src" is created.', $this->output);
        $this->assertStringContainsString('Your project is initialized.', $this->output);
    }

    protected function setUp(): void
    {
        $application = new Application();
        $application->add(new InitCommand());

        $commandTester = new CommandTester($application->find('init'));
        $this->result = $commandTester->execute([]);

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
