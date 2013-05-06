<?php

namespace Desk\Client\Content\Model;

use Desk\Model\ResponseKeyMapModelArray;

class TopicArray extends ResponseKeyMapModelArray
{

    /**
     * {@inheritdoc}
     */
    public function getResponseKeyMap()
    {
        return array(
            'GetTopics' => 'results',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getModelName()
    {
        return 'Desk\\Client\\Content\\Model\\TopicModel';
    }

    /**
     * {@inheritdoc}
     */
    public function getResultKey()
    {
        return 'topic';
    }
}
