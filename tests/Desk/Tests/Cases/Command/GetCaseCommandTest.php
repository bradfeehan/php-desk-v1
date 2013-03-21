<?php

namespace Desk\Tests\Cases\Command;

class GetCaseCommandTest extends \Desk\Testing\OperationTestCase
{

    protected $client = 'mock.cases';

    protected $operation = 'GetCase';


    public function dataParameterValid()
    {
        return array(
            array('id', 44),
            array('by', 'id'),
            array('by', 'external_id'),
        );
    }

    public function dataParameterInvalid()
    {
        return array(
            array('id', 3.14),
            array('id', -3.2),
            array('id', '90'),
            array('id', '-33'),
            array('id', '6.28'),
            array('id', '-8.8'),
            array('id', 'not a number'),
        );
    }
}
