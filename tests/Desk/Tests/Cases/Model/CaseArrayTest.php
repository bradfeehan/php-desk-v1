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
        $data = array(
            'results' => array(
                0 => array('case' => array('foo' => 'bar')),
                1 => array('case' => array('bar' => 'baz')),
            ),
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
        $data = array('foo' => 'bar');

        $response = \Mockery::mock(
            'Guzzle\\Http\\Message\\Response',
            array('json' => $data, 'getBody' => json_encode($data))
        );

        $command = \Mockery::mock(
            'Guzzle\\Service\\Command\\OperationCommand',
            array(
                'getResponse' => \Mockery::mock(
                    'Guzzle\\Http\\Message\\Response',
                    array(
                        'json' => $data,
                        'getBody' => json_encode($data),
                    )
                ),
            )
        );

        CaseArray::fromCommand($command);
    }
}
