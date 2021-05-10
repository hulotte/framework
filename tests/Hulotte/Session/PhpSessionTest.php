<?php

namespace tests\Hulotte\Session;

use Hulotte\Session\PhpSession;
use PHPUnit\Framework\TestCase;

/**
 * Class PhpSessionTest
 * @author Sébastien CLEMENT<s.clement@la-taniere.net>
 * @covers \Hulotte\Session\PhpSession
 * @package tests\Hulotte\Session
 */
class PhpSessionTest extends TestCase
{
    /**
     * @var PhpSession
     */
    private static PhpSession $phpSession;

    /**
     * @covers \Hulotte\Session\PhpSession
     * @test
     */
    public function createSession(): void
    {
        self::$phpSession = new PhpSession();
        $this->assertSame(PHP_SESSION_ACTIVE, session_status());
    }

    /**
     * @covers \Hulotte\Session\PhpSession::set
     * @test
     */
    public function set(): void
    {
        self::$phpSession->set('test', 'Le test');

        $this->assertSame('Le test', $_SESSION['test']);
    }

    /**
     * @covers \Hulotte\Session\PhpSession::get
     * @test
     */
    public function get(): void
    {
        $result = self::$phpSession->get('test');

        $this->assertSame('Le test', $result);
    }

    /**
     * @covers \Hulotte\Session\PhpSession::get
     * @test
     */
    public function getWithFailure(): void
    {
        $this->assertNull(self::$phpSession->get('fail'));
    }

    /**
     * @covers \Hulotte\Session\PhpSession::delete
     * @test
     */
    public function delete(): void
    {
        self::$phpSession->delete('test');

        $this->assertArrayNotHasKey('test', $_SESSION);
    }

    /**
     * @test
     */
    public function arrayAccessSet(): void
    {
        self::$phpSession['testArray'] = 'test array access';

        $this->assertSame('test array access', $_SESSION['testArray']);
    }

    /**
     * @test
     */
    public function arrayAccessGet(): void
    {
        $this->assertSame('test array access', self::$phpSession['testArray']);
    }

    /**
     * @test
     */
    public function arrayAccessExists(): void
    {
        $this->assertTrue(self::$phpSession->offsetExists('testArray'));
    }

    /**
     * @test
     */
    public function arrayAccessUnset(): void
    {
        self::$phpSession->offsetUnset('testArray');

        $this->assertNull(self::$phpSession['testArray']);
    }

    public static function setUpBeforeClass(): void
    {
        self::$phpSession = new PhpSession();
    }

    public static function tearDownAfterClass(): void
    {
        session_destroy();
    }
}
