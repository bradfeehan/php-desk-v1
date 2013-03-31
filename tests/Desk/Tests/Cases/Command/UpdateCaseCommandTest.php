<?php

namespace Desk\Tests\Cases\Command;

class UpdateCaseCommandTest extends \Desk\Testing\OperationTestCase
{

    protected $client = 'mock.cases';

    protected $operation = 'UpdateCase';


    public function dataParameterValid()
    {
        return array(
            array(
                array(
                    'id' => 22,
                    'subject' => 'New Subject',
                    'labels' => array('foo', 'bar'),
                ),
            ),
            array(
                array(
                    'id' => 43,
                    'status' => 'pending',
                ),
                array('postFields' => '/case_status_type_id=50/'),
            ),
        );
    }

    public function dataParameterInvalid()
    {
        return array(
            array(array(
                'subject' => 'Missing ID',
            )),
            array(array(
                'id' => 34,
                'status' => 'not_a_valid_status',
            )),
        );
    }
}
