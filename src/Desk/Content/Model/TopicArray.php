<?php

namespace Desk\Content\Model;

use Desk\AbstractModel;
use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Command\ResponseClassInterface;

class TopicArray extends AbstractModel implements ResponseClassInterface
{

    /**
     * {@inheritdoc}
     */
    public static function fromCommand(OperationCommand $command)
    {
        $response = $command->getResponse();

        // Make sure "results" key exists
        $topicsData = static::getResponseKey($response, 'results');

        // Build up an array of TopicModel objects from the results
        $topics = array();

        foreach ((array) $topicsData as $result) {
            $topics[] = new TopicModel($result['topic']);
        }

        return $topics;
    }
}
