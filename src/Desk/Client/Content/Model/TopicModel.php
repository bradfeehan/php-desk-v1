<?php

namespace Desk\Client\Content\Model;

use Desk\Model\AbstractModel;

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
            'UpdateTopic' => 'results/topic',
        );
    }
}
