<?php

namespace Desk\Content\Model;

use Desk\AbstractModel;

class TopicModel extends AbstractModel
{

    /**
     * {@inheritdoc}
     */
    public function getResponseKeyMap()
    {
        return array(
            'GetTopic' => 'topic',
            'CreateTopic' => 'results/topic',
        );
    }
}
