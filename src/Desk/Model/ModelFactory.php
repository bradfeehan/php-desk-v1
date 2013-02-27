<?php

namespace Desk\Model;

use Guzzle\Http\Message\Response;
use ReflectionClass;
use UnexpectedValueException;

class ModelFactory
{

    /**
     * Singleton instance
     *
     * @var Desk\Model\ModelFactory
     */
    private static $instance;

    /**
     * @return Desk\Model\ModelFactory The singleton instance
     */
    public static function getInstance()
    {
        // @codeCoverageIgnoreStart
        if (!self::$instance) {
            self::$instance = new static;
        }
        // @codeCoverageIgnoreEnd

        return self::$instance;
    }

    /**
     * Allow setting the instance for dependency injection
     *
     * @param Desk\Model\ModelFactory $instance
     */
    public static function setInstance(ModelFactory $instance = null)
    {
        self::$instance = $instance;
    }

    /**
     * Create an instance of a model from a Guzzle Response object
     *
     * @param string                       $className Class to create
     * @param Guzzle\Http\Message\Response $response  Guzzle response
     *
     * @return Desk\Model\FromResponse
     * @throws UnexpectedValueException If $className doesn't implement
     *                                  Desk\Model\FromResponse
     */
    public function fromResponse($className, Response $response)
    {
        $this->checkInterface($className, 'Desk\\Model\\FromResponse');

        return $className::fromResponse($response);
    }

    /**
     * Create an instance of a model from data in a PHP array
     *
     * @param string $className The class to instantiate
     * @param array  $data      The data
     *
     * @return Desk\Model\FromData
     * @throws UnexpectedValueException If $className doesn't implement
     *                                  Desk\Model\FromData
     */
    public function fromData($className, $data)
    {
        $this->checkInterface($className, 'Desk\\Model\\FromData');

        return $className::fromData($data);
    }

    /**
     * Checks if a class implements an interface
     *
     * @param string $className     The name of the class
     * @param string $interfaceName The name of the interface
     *
     * @throws UnexpectedValueException If $className doesn't implement
     *                                  $interfaceName
     */
    private function checkInterface($className, $interfaceName)
    {
        $reflectionClass = new ReflectionClass($className);
        if (!$reflectionClass->implementsInterface($interfaceName)) {
            $message = "Invalid model class '$className' (must implement $interfaceName)";
            throw new UnexpectedValueException($message);
        }
    }
}
