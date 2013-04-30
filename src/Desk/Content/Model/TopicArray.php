<?php

namespace Desk\Content\Model;

use Desk\AbstractModelArray;

class TopicArray extends AbstractModelArray
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
        return 'Desk\\Content\\Model\\TopicModel';
    }

    /**
     * {@inheritdoc}
     */
    public function getResultKey()
    {
        return 'topic';
    }
}
