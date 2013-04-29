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
        $command = $this->createMockCommand(
            array(
                'case' => array('foo' => 'bar'),
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
        $command = $this->createMockCommand(array('foo' => 'bar'));
        CaseModel::fromCommand($command);
    }

    /**
     * @covers Desk\Cases\Model\CaseModel::getCasePath
     * @dataProvider dataGetCasePath
     */
    public function testGetCasePath($commandName, $expected)
    {
        $command = $this->createMockCommand(array(), $commandName);
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
