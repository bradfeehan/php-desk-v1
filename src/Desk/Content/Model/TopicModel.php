<?php

namespace Desk\Content\Model;

use Desk\AbstractModel;
use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Command\ResponseClassInterface;

class TopicModel extends AbstractModel implements ResponseClassInterface
{

    /**
     * {@inheritdoc}
     */
    public static function fromCommand(OperationCommand $command)
    {
        $response = $command->getResponse();
        return new static(static::getResponseKey($response, 'topic'));
    }
}
