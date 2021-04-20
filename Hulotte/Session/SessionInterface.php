<?php

namespace Hulotte\Session;

/**
 * Interface SessionInterface
 * @author Sébastien CLEMENT<s.clement@la-taniere.net>
 * @package Hulotte\Session
 */
interface SessionInterface
{
    /**
     * Delete a key on session
     * @param string $key
     */
    public function delete(string $key):void;

    /**
     * Get an information on session
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null):mixed;

    /**
     * Add an information on session
     * @param string $key
     * @param mixed $value
     */
    public function set(string $key, mixed $value): void;
}
