<?php

namespace Desk;

use Guzzle\Service\Command\AbstractCommand;
use Guzzle\Service\Command\DefaultResponseParser;
use Guzzle\Service\Command\OperationResponseParser;
use Guzzle\Service\Description\OperationInterface;
use Guzzle\Http\Message\Response;
use ReflectionClass;
use UnexpectedValueException;

/**
 * Marshals responses into a class (the operation's "responseClass")
 *
 * Falls back to default behaviour of the OperationResponseParser.
 */
class ResponseParser extends DefaultResponseParser
{

    /**
     * @var Desk\ResponseParser
     */
    protected static $instance;


    /**
     * @return Desk\ResponseParser
     */
    public static function getInstance()
    {
        // @codeCoverageIgnoreStart
        if (empty(self::$instance)) {
            self::$instance = new static();
        }
        // @codeCoverageIgnoreEnd

        return self::$instance;
    }

    /**
     * {@inheritdoc}
     */
    protected function handleParsing(AbstractCommand $command, Response $response, $contentType)
    {
        $operation = $command->getOperation();
        $class = $operation->getResponseType() == OperationInterface::TYPE_CLASS
            ? $operation->getResponseClass() : null;

        if (!$class) {
            // fall back to the normal operation response parser
            return OperationResponseParser::getInstance()
                ->handleParsing($command, $response, $contentType);
        }

        // Ensure that the requested class implements ResponseClass
        $reflectionClass = new ReflectionClass($class);
        $interface = 'Desk\\ResponseClass';
        if (!$reflectionClass->implementsInterface($interface)) {
            $message = "Invalid responseClass '$class' (must implement $interface)";
            throw new UnexpectedValueException($message);
        }

        return $class::fromResponse($response);
    }
}
