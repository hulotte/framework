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
     * @var int
     */
    public const ERR_EMAIL = 101;

    /**
     * @var int
     */
    public const ERR_REQUIRED = 100;

    /**
     * Validator constructor.
     * @param array $params
     * @param null|array $error
     */
    public function __construct(private array $params, private ?array $error = null)
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
            $this->error[$key] = $this::ERR_EMAIL;
        }

        return $this;
    }

    /**
     * @return null|array
     */
    public function getError(): ?array
    {
        return $this->error;
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

            if ($value === null || trim($value) === '') {
                $this->error[$key] = $this::ERR_REQUIRED;
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
