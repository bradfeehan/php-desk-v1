<?php

namespace Desk\Cases\Model;

use Desk\AbstractModelArray;

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
        return 'Desk\\Cases\\Model\\CaseModel';
    }

    /**
     * {@inheritdoc}
     */
    public function getResultKey()
    {
        return 'case';
    }
}
