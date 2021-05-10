<?php

namespace Hulotte\Session;

use ArrayAccess;

/**
 * Class PhpSession
 * @author Sébastien CLEMENT<s.clement@la-taniere.net>
 * @package Hulotte\Session
 */
class PhpSession implements SessionInterface, ArrayAccess
{
    /**
     * PhpSession constructor
     * Launch session if it is not
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * @inheritDoc
     */
    public function get(string $key): mixed
    {
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $_SESSION);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        $this->delete($offset);
    }
}
