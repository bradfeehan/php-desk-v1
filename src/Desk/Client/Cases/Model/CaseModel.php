<?php

namespace Desk\Client\Cases\Model;

use Desk\Model\AbstractModel;

class CaseModel extends AbstractModel
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
