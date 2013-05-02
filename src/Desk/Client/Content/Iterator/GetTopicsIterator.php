<?php

namespace Desk\Client\Content\Iterator;

use Guzzle\Service\Resource\ResourceIterator;

/**
 * Iterator for the GetTopics command
 */
class GetTopicsIterator extends ResourceIterator
{

    /**
     * {@inheritdoc}
     */
    protected function sendRequest()
    {
        if ($this->nextToken) {
            $this->command->set('page', $this->nextToken);
        }

        $topics = $this->command->execute();

        // Update nextToken, if there are any results
        if (count($topics)) {
            $this->nextToken = ((int) $this->nextToken) + 1;
            return $topics;
        } else {
            $this->nextToken = null;
        }

        return null;
    }
}
