<?php

namespace Desk\Model;

use Desk\Exception\ResponseFormatException;
use Desk\Exception\UnexpectedValueException;
use Guzzle\Http\Message\Response;
use Guzzle\Service\Command\OperationCommand;

class ModelFactory
{

    /**
     * Singleton instance
     *
     * @var Desk\Model\ModelFactory
     */
    private static $instance;


    /**
     * Gets the singleton instance
     *
     * @return Desk\Model\ModelFactory
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Overrides the singleton instance (for dependency injection)
     */
    public static function setInstance(ModelFactory $instance = null)
    {
        self::$instance = $instance;
    }


    /**
     * Factory method to create a new model from an OperationCommand
     *
     * @param string                                  $modelName
     * @param Guzzle\Service\Command\OperationCommand $command
     *
     * @return Desk\Model\AbstractModel
     * @throws Desk\Exception\UnexpectedValueException
     */
    public function factory($modelName, OperationCommand $command)
    {
        $key = $this->getResponseKey($modelName, $command->getName());
        $data = $this->getResponseData($command->getResponse(), $key);
        return $modelName::instance()->factory($data);
    }

    /**
     * Gets the name of the key in the response containing model data
     *
     * @param string $modelName   The model being created
     * @param string $commandName The command creating the model
     *
     * @return string
     * @throws Desk\Exception\UnexpectedValueException
     */
    public function getResponseKey($modelName, $commandName)
    {
        // Ensure $modelName is an AbstractModel, as we need to call
        // getResponseKeyMap on it
        if (!is_subclass_of($modelName, 'Desk\\Model\\AbstractModel')) {
            throw new UnexpectedValueException(
                "Tried to create '$modelName', but it does not " .
                "inherit from Desk\\Model\\AbstractModel"
            );
        }

        return $modelName::instance()->getResponseKeyFor($commandName);
    }

    /**
     * Gets a value from a Desk.com API response
     *
     * Interprets a response as JSON, and looks through the resulting
     * structure to retrieve the specified key. An exception of type
     * ResponseFormatException is thrown if the key is missing.
     *
     * Nested keys can be retrieved using "/", e.g. "foo/bar/baz" will
     * return "quux" if the response JSON is the following:
     *
     * {
     *   "foo": {
     *     "bar": {
     *       "baz": "quux"
     *     }
     *   }
     * }
     *
     * If any of the "foo", "bar", or "baz" keys are missing from the
     * response, an exception will be thrown.
     *
     * @param Desk\Http\Message\Response $response The response to check
     * @param string                     $path     Key path to search
     *
     * @return mixed The value of the $path key in the response
     * @throws Desk\Exception\ResponseFormatException For missing $path
     */
    public function getResponseData(Response $response, $path)
    {
        $contents = $response->json();
        $keys = explode('/', $path);

        foreach ($keys as $key) {
            if (!is_array($contents) || !array_key_exists($key, $contents)) {
                throw new ResponseFormatException(
                    "Invalid response format from Desk API " .
                    "(expected '$path' element in response). " .
                    "Full response:\n{$response->getBody()}"
                );
            }

            $contents = $contents[$key];
        }

        return $contents;
    }
}
