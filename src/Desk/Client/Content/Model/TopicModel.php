<?php

namespace Desk\Client\Content\Model;

use Desk\Model\ResponseKeyMapModel;

class TopicModel extends ResponseKeyMapModel
{

    /**
     * {@inheritdoc}
     */
    public function getResponseKeyMap()
    {
        return array(
            'GetTopic' => 'topic',
            'CreateTopic' => 'results/topic',
            'UpdateTopic' => 'results/topic',
        );
    }
}
