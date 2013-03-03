<?php

namespace Desk;

use Guzzle\Http\QueryAggregator\CommaAggregator;
use Guzzle\Service\Command\CommandInterface;
use Guzzle\Service\Command\DefaultRequestSerializer;
use Guzzle\Service\Command\LocationVisitor\VisitorFlyweight;

class RequestSerializer extends DefaultRequestSerializer
{

    /**
     * @return Desk\RequestSerializer
     */
    public static function getInstance()
    {
        // @codeCoverageIgnoreStart
        if (!self::$instance) {
            self::$instance = new static(VisitorFlyweight::getInstance());
        }
        // @codeCoverageIgnoreEnd

        return self::$instance;
    }

    /**
     * {@inheritdoc}
     *
     * Overridden to set the request's QueryAggregator to CommaAggregator.
     */
    public function createRequest(CommandInterface $command)
    {
        $request = parent::createRequest($command);

        $request
            ->getQuery()
            ->setAggregator(new CommaAggregator());

        return $request;
    }
}
