<?php

namespace Desk\Command;

use Guzzle\Http\QueryAggregator\CommaAggregator;
use Guzzle\Service\Command\CommandInterface;
use Guzzle\Service\Command\DefaultRequestSerializer;
use Guzzle\Service\Command\LocationVisitor\VisitorFlyweight;

class RequestSerializer extends DefaultRequestSerializer
{

    /**
     * @return Desk\Command\RequestSerializer
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new static(VisitorFlyweight::getInstance());
        }

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
