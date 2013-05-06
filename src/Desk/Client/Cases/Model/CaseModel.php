<?php

namespace Desk\Client\Cases\Model;

use Desk\Model\ResponseKeyMapModel;

class CaseModel extends ResponseKeyMapModel
{

    /**
     * {@inheritdoc}
     */
    public function getResponseKeyMap()
    {
        return array(
            'GetCase' => 'case',
            'UpdateCase' => 'results/case',
        );
    }
}
