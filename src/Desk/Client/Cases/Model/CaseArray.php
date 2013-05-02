<?php

namespace Desk\Client\Cases\Model;

use Desk\Model\AbstractModelArray;

class CaseArray extends AbstractModelArray
{

    /**
     * {@inheritdoc}
     */
    public function getResponseKeyMap()
    {
        return array(
            'GetCases' => 'results',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getModelName()
    {
        return 'Desk\\Client\\Cases\\Model\\CaseModel';
    }

    /**
     * {@inheritdoc}
     */
    public function getResultKey()
    {
        return 'case';
    }
}
