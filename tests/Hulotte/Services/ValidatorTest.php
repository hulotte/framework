<?php

namespace tests\Hulotte\Services;

use Hulotte\Services\Validator;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidatorTest
 * @author Sébastien CLEMENT<s.clement@la-taniere.net>
 * @covers \Hulotte\Services\Validator
 * @package tests\Hulotte\Services
 */
class ValidatorTest extends TestCase
{
    /**
     * @covers \Hulotte\Services\Validator::required
     * @test
     */
    public function requiredSuccess(): void
    {
        $validator = new Validator(['name' => 'CLEMENT']);
        $result = $validator->required('name');

        $this->assertInstanceOf(Validator::class, $result);
        $this->assertNull($result->getError());
    }

    /**
     * @covers \Hulotte\Services\Validator::required
     * @test
     */
    public function requiredFail(): void
    {
        $validator = new Validator([]);
        $result = $validator->required('name');

        $this->assertInstanceOf(Validator::class, $result);
        $this->assertSame(['name' => 100], $result->getError());
    }

    /**
     * @covers \Hulotte\Services\Validator::required
     * @test
     */
    public function requiredSuccessWithManyParams(): void
    {
        $validator = new Validator(['name' => 'CLEMENT', 'firstname' => 'Sébastien']);
        $result = $validator->required('name', 'firstname');

        $this->assertInstanceOf(Validator::class, $result);
        $this->assertNull($result->getError());
    }

    /**
     * @covers \Hulotte\Services\Validator::required
     * @test
     */
    public function requiredFailWithManyParams(): void
    {
        $validator = new Validator([]);
        $result = $validator->required('name', 'firstname');

        $this->assertInstanceOf(Validator::class, $result);
        $this->assertSame(['name' => 100, 'firstname' => 100], $result->getError());
    }

    /**
     * @covers \Hulotte\Services\Validator::required
     * @test
     */
    public function requiredFailWithEmptyValue(): void
    {
        $validator = new Validator(['name' => ' ']);
        $result = $validator->required('name');

        $this->assertInstanceOf(Validator::class, $result);
        $this->assertSame(['name' => 100], $result->getError());
    }

    /**
     * @covers \Hulotte\Services\Validator::email
     * @test
     */
    public function emailSuccess(): void
    {
        $validator = new Validator(['email' => 'monemail@test.com']);
        $result = $validator->email('email');

        $this->assertInstanceOf(Validator::class, $result);
        $this->assertNull($result->getError());
    }

    /**
     * @covers \Hulotte\Services\Validator::email
     * @test
     */
    public function emailFail(): void
    {
        $validator = new Validator(['email' => 'monemail']);
        $result = $validator->email('email');

        $this->assertInstanceOf(Validator::class, $result);
        $this->assertSame(['email' => 101], $result->getError());
    }

    /**
     * @covers \Hulotte\Services\Validator::email
     * @covers \Hulotte\Services\Validator::required
     * @test
     */
    public function multiConditionsSuccess(): void
    {
        $validator = new Validator(['email' => 'monemail@test.com', 'password' => 'jfsdfsjhdfsjhdf']);
        $result = $validator->required('email', 'password')
            ->email('email');

        $this->assertInstanceOf(Validator::class, $result);
        $this->assertNull($result->getError());
    }

    /**
     * @covers \Hulotte\Services\Validator::email
     * @covers \Hulotte\Services\Validator::required
     * @test
     */
    public function multiConditionsFail(): void
    {
        $validator = new Validator(['email' => 'monemail@test', 'password' => '']);
        $result = $validator->required('email', 'password')
            ->email('email');

        $this->assertInstanceOf(Validator::class, $result);
        $this->assertSame([
            'password' => 100,
            'email' => 101,
        ], $result->getError());
    }
}
