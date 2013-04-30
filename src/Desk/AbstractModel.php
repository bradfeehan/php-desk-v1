<?php

namespace Desk;

use Desk\ModelFactory;
use Guzzle\Common\Collection;
use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Command\ResponseClassInterface;

abstract class AbstractModel extends Collection implements ResponseClassInterface
{

    /**
     * Singleton instances of concrete child classes of this class
     *
     * These are stored in an associative array which maps child class
     * names to their instances.
     *
     * @var array
     */
    private static $instances = array();


    /**
     * Gets the singleton instance for the child class it's called on
     *
     * @return Desk\AbstractModel
     */
    public static function instance()
    {
        $className = get_called_class();

        if (empty(self::$instances[$className])) {
            self::$instances[$className] = new static();
        }

        return self::$instances[$className];
    }

    /**
     * Overrides the singleton instance (for dependency injection)
     *
     * If $instance is NULL, the instance will be reset to the default.
     *
     * @param Desk\AbstractModel $instance
     */
    public static function setInstance(AbstractModel $instance = null)
    {
        if (!$instance) {
            self::$instances = array();
            return;
        }

        $className = get_called_class();
        self::$instances[$className] = $instance;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromCommand(OperationCommand $command)
    {
        $className = get_called_class();
        return ModelFactory::instance()->factory($className, $command);
    }


    /**
     * Factory method to create the model from model data
     *
     * This factory method will, by default, create an instance of the
     * model using its constructor. However it can also be overridden
     * in order to return a different type from the model (e.g. to
     * return an array instead).
     *
     * @param array $data
     *
     * @return mixed
     */
    public function factory($data)
    {
        return new static($data);
    }

    /**
     * Gets an array mapping command names to keys in the response
     *
     * This array maps names of Guzzle commands to the key in the
     * corresponding response where the model data is found for that
     * command.
     *
     * @return array
     */
    abstract public function getResponseKeyMap();
}
