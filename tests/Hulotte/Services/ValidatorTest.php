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
     * @covers \Hulotte\Services\Validator:required
     * @test
     */
    public function requiredSuccess(): void
    {
        $validator = new Validator(['name' => 'Billy']);
        $result = $validator->required('name');

        $this->assertInstanceOf(Validator::class, $result);
        $this->assertFalse($result->isError());
    }

    /**
     * @covers \Hulotte\Services\Validator:required
     * @test
     */
    public function requiredFail(): void
    {
        $validator = new Validator([]);
        $result = $validator->required('name');

        $this->assertInstanceOf(Validator::class, $result);
        $this->assertTrue($result->isError());
    }

    /**
     * @covers \Hulotte\Services\Validator:required
     * @test
     */
    public function requiredWithManyKeys(): void
    {
        $validator = new Validator(['name' => 'Billy', 'firstname' => 'Bob']);
        $result = $validator->required('name', 'firstname');

        $this->assertInstanceOf(Validator::class, $result);
        $this->assertFalse($result->isError());
    }

    /**
     * @covers \Hulotte\Services\Validator:required
     * @test
     */
    public function requiredWithManyKeysFail(): void
    {
        $validator = new Validator(['name' => 'Billy']);
        $result = $validator->required('name', 'firstname');

        $this->assertInstanceOf(Validator::class, $result);
        $this->assertTrue($result->isError());
    }

    /**
     * @covers \Hulotte\Services\Validator:notEmpty
     * @test
     */
    public function notEmpty(): void
    {
        $validator = new Validator(['name' => 'Billy']);
        $result = $validator->notEmpty('name');

        $this->assertInstanceOf(Validator::class, $result);
        $this->assertFalse($result->isError());
    }

    /**
     * @covers \Hulotte\Services\Validator:notEmpty
     * @test
     */
    public function notEmptyFail(): void
    {
        $validator = new Validator(['name' => '']);
        $result = $validator->notEmpty('name');

        $this->assertInstanceOf(Validator::class, $result);
        $this->assertTrue($result->isError());
    }

    /**
     * @covers \Hulotte\Services\Validator:notEmpty
     * @test
     */
    public function notEmptySuccessWithSpace(): void
    {
        $validator = new Validator(['name' => ' Billy ']);
        $result = $validator->notEmpty('name');

        $this->assertInstanceOf(Validator::class, $result);
        $this->assertFalse($result->isError());
    }

    /**
     * @covers \Hulotte\Services\Validator:notEmpty
     * @test
     */
    public function notEmptyFailWithSpace(): void
    {
        $validator = new Validator(['name' => ' ']);
        $result = $validator->notEmpty('name');

        $this->assertInstanceOf(Validator::class, $result);
        $this->assertTrue($result->isError());
    }

    /**
     * @covers \Hulotte\Services\Validator:notEmpty
     * @test
     */
    public function notEmptySuccessWithManyKeys(): void
    {
        $validator = new Validator(['name' => ' Billy ', 'firstname' => 'Bob']);
        $result = $validator->notEmpty('name', 'firstname');

        $this->assertInstanceOf(Validator::class, $result);
        $this->assertFalse($result->isError());
    }

    /**
     * @covers \Hulotte\Services\Validator:email
     * @test
     */
    public function email(): void
    {
        $validator = new Validator(['email' => 'billybob@test.com']);
        $result = $validator->email('email');

        $this->assertInstanceOf(Validator::class, $result);
        $this->assertfalse($result->isError());
    }



    /**
     * @covers \Hulotte\Services\Validator:email
     * @test
     */
    public function emailFail(): void
    {
        $validator = new Validator(['email' => 'billybob']);
        $result = $validator->email('email');

        $this->assertInstanceOf(Validator::class, $result);
        $this->assertTrue($result->isError());
    }
}
