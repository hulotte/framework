<?php

namespace Hulotte\Services;

/**
 * Class Validator
 * @author Sébastien CLEMENT<s.clement@la-taniere.net>
 * @package Hulotte\Services
 */
class Validator
{
    /**
     * Validator constructor.
     * @param array $params
     */
    public function __construct(private array $params, private bool $error = false)
    {
    }

    /**
     * Define if a key is an email
     * @param string $key
     * @return $this
     */
    public function email(string $key): self
    {
        $value = $this->getValue($key);

        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            $this->error = true;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->error;
    }

    /**
     * Define empty keys
     * @param string ...$keys
     * @return $this
     */
    public function notEmpty(string ...$keys): self
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);

            if ($value === null || empty(trim($value))) {
                $this->error = true;
            }
        }

        return $this;
    }

    /**
     * Define keys which are mandatory
     * @param string ...$keys
     * @return $this
     */
    public function required(string ...$keys): self
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);

            if ($value === null || $value === '') {
                $this->error = true;
            }
        }

        return $this;
    }

    /**
     * Verify if a key exists.
     * @param string $key
     * @return string|null
     */
    private function getValue(string $key): ?string
    {
        if (array_key_exists($key, $this->params)) {
            return $this->params[$key];
        }

        return null;
    }
}
