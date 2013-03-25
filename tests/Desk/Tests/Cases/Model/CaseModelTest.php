<?php

namespace Desk\Tests\Cases\Model;

use Desk\Cases\Model\CaseModel;
use UnexpectedValueException;

class CaseModelTest extends \Desk\Testing\UnitTestCase
{

    /**
     * @covers Desk\Cases\Model\CaseModel::fromCommand
     */
    public function testFromCommand()
    {
        $data = array(
            'case' => array('foo' => 'bar'),
        );

        $command = \Mockery::mock(
            'Guzzle\\Service\\Command\\OperationCommand',
            array(
                'getResponse' => \Mockery::mock(
                    'Guzzle\\Http\\Message\\Response',
                    array('json' => $data)
                ),
            )
        );

        $case = CaseModel::fromCommand($command);
        $this->assertInstanceOf('Desk\\Cases\\Model\\CaseModel', $case);
    }

    /**
     * @covers Desk\Cases\Model\CaseModel::fromCommand
     * @expectedException UnexpectedValueException
     */
    public function testFromCommandThrowsExceptionForInvalidFormat()
    {
        $data = array('foo' => 'bar');

        $command = \Mockery::mock(
            'Guzzle\\Service\\Command\\OperationCommand',
            array(
                'getResponse' => \Mockery::mock(
                    'Guzzle\\Http\\Message\\Response',
                    array('json' => $data, 'getBody' => json_encode($data))
                ),
            )
        );

        CaseModel::fromCommand($command);
    }
}
