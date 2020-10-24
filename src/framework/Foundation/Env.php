<?php
namespace Demo\Framework\Foundation;

use Dotenv\Dotenv;
use Dotenv\Repository\RepositoryBuilder;

class Env
{
    private $repository;

    public function loadDotEnv()
    {
        if (class_exists('Dotenv\Dotenv')) {
            Dotenv::create($this->getRepository(), path(), '.env')->load();
        }
    }


    /**
     * Get the environment repository instance.
     *
     * @return \Dotenv\Repository\RepositoryInterface
     */
    public function getRepository()
    {
        if ($this->repository === null) {
            $this->repository = RepositoryBuilder::createWithDefaultAdapters()->immutable()->make();
        }
        return $this->repository;
    }


    /**
     * Determine if the given environment variable is defined.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name)
    {
        return $this->getRepository()->has($name);
    }

    /**
     * Get an environment variable.
     *
     * @param string $name
     *
     * @return string|null
     */
    public function get(string $name)
    {
        return $this->getRepository()->get($name);
    }

    /**
     * Set an environment variable.
     *
     * @param string $name
     * @param string $value
     *
     * @return bool
     */
    public function set(string $name, string $value)
    {
        return $this->getRepository()->set($name, $value);
    }

    /**
     * Clear an environment variable.
     *
     * @param string $name
     *
     * @return bool
     */
    public function clear(string $name)
    {
        return $this->getRepository()->clear($name);
    }
}
