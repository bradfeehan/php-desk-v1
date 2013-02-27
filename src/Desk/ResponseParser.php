<?php

namespace Desk;

use Desk\Model\ModelFactory;
use Guzzle\Service\Command\AbstractCommand;
use Guzzle\Service\Command\DefaultResponseParser;
use Guzzle\Service\Command\OperationResponseParser;
use Guzzle\Service\Description\OperationInterface;
use Guzzle\Http\Message\Response;

/**
 * Marshals responses into a class (the operation's "responseClass")
 *
 * Falls back to default behaviour of the OperationResponseParser.
 */
class ResponseParser extends DefaultResponseParser
{

    /**
     * @var Desk\Model\ModelFactory
     */
    private static $modelFactory;

    /**
     * @return Desk\ResponseParser
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

        return ModelFactory::getInstance()->fromResponse($class, $response);
    }
}
