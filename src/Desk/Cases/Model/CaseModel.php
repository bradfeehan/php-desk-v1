<?php

namespace Desk\Cases\Model;

use Desk\AbstractModel;

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
