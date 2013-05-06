<?php

namespace Desk\Client\Cases\Model;

use Desk\Model\ResponseKeyMapModelArray;

class CaseArray extends ResponseKeyMapModelArray
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
