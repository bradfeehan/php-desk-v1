<?php

namespace Desk\Tests\Cases\Model;

use Desk\Cases\Model\CaseArray;

class CaseArrayTest extends \Desk\Testing\UnitTestCase
{

    /**
     * @covers Desk\Cases\Model\CaseArray::fromCommand
     */
    public function testFromCommand()
    {
        $command = $this->createMockCommand(
            array(
                'results' => array(
                    0 => array('case' => array('foo' => 'bar')),
                    1 => array('case' => array('bar' => 'baz')),
                ),
            )
        );

        $cases = CaseArray::fromCommand($command);
        $this->assertSame(2, count($cases), 'Wrong number of cases returned');

        foreach ($cases as $case) {
            $this->assertInstanceOf('Desk\\Cases\\Model\\CaseModel', $case);
        }
    }

    /**
     * @covers Desk\Cases\Model\CaseArray::fromCommand
     * @expectedException UnexpectedValueException
     */
    public function testFromCommandThrowsExceptionForInvalidFormat()
    {
        $command = $this->createMockCommand(array('foo' => 'bar'));
        CaseArray::fromCommand($command);
    }
}
