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
               'getName' => 'MyCommand',
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
                'getName' => 'MyCommand',
            )
        );

        CaseModel::fromCommand($command);
    }

    /**
     * @covers Desk\Cases\Model\CaseModel::getCasePath
     * @dataProvider dataGetCasePath
     */
    public function testGetCasePath($commandName, $expected)
    {
        $command = \Mockery::mock(
            'Guzzle\\Service\\Command\\OperationCommand',
            array(
                'getName' => $commandName,
            )
        );

        $this->assertSame($expected, CaseModel::getCasePath($command));
    }

    public function dataGetCasePath()
    {
        return array(
            array('GetCase', 'case'),
            array('UpdateCase', 'results/case'),
            array('MyCommand', 'case'),
        );
    }
}
