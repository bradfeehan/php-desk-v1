<?php

namespace Desk\Tests\Cases\Command;

class GetCaseCommandTest extends \Desk\Testing\OperationTestCase
{

    protected $client = 'mock.cases';

    protected $operation = 'GetCase';


    public function dataParameterValid()
    {
        return array(
            array(array('id' => 44)),
            array(array('by' => 'id')),
            array(array('by' => 'external_id')),
        );
    }

    public function dataParameterInvalid()
    {
        return array(
            array(array('id' => 3.14)),
            array(array('id' => -3.2)),
            array(array('id' => '90')),
            array(array('id' => '-33')),
            array(array('id' => '6.28')),
            array(array('id' => '-8.8')),
            array(array('id' => 'not a number')),
        );
    }
}
