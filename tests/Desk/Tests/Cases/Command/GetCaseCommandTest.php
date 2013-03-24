<?php

namespace Desk\Tests\Cases\Command;

class GetCaseCommandTest extends \Desk\Testing\OperationTestCase
{

    protected $client = 'mock.cases';

    protected $operation = 'GetCase';


    public function dataParameterValid()
    {
        return array(
            array(array(
                'id' => 44,
            )),
            array(array(
                'id' => 54,
                'by' => 'id',
            )),
            array(array(
                'id' => 23,
                'by' => 'external_id',
            )),
        );
    }

    public function dataParameterInvalid()
    {
        return array(
            array(array('id' => false)),
            array(array('id' => null)),
            array(array('id' => new \stdClass())),
            array(array('by' => 'id')),
            array(array('by' => 'external_id')),
        );
    }
}
