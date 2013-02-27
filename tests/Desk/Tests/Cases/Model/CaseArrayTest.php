<?php

namespace Desk\Tests\Cases\Model;

use Desk\Cases\Model\CaseArray;
use Desk\Model\ModelFactory;

class CaseArrayTest extends \Desk\Testing\UnitTestCase
{

    /**
     * @covers Desk\Cases\Model\CaseArray::fromResponse
     */
    public function testFromResponse()
    {
        $data = array(
            'results' => array(
                0 => array('case' => array('foo' => 'bar')),
                1 => array('case' => array('bar' => 'baz')),
            ),
        );

        $response = \Mockery::mock('Guzzle\\Http\\Message\\Response')
            ->shouldReceive('json')
            ->andReturn($data)
            ->mock();

        $factory = \Mockery::mock('Desk\\Model\\ModelFactory');
        $factory
            ->shouldReceive('fromData')->once()
            ->with('Desk\\Cases\\Model\\CaseModel', $data['results'][0]['case'])
            ->andReturn('case1');
        $factory
            ->shouldReceive('fromData')->once()
            ->with('Desk\\Cases\\Model\\CaseModel', $data['results'][1]['case'])
            ->andReturn('case2');

        ModelFactory::setInstance($factory);

        $cases = CaseArray::fromResponse($response);
        $this->assertSame(2, count($cases), 'Wrong number of cases returned');
        $this->assertContains('case1', $cases);
        $this->assertContains('case2', $cases);
    }

    /**
     * @covers Desk\Cases\Model\CaseArray::fromResponse
     * @expectedException UnexpectedValueException
     */
    public function testFromResponseThrowsExceptionForInvalidFormat()
    {
        $data = array('foo' => 'bar');

        $response = \Mockery::mock(
            'Guzzle\\Http\\Message\\Response',
            array('json' => $data, 'getBody' => json_encode($data))
        );

        CaseArray::fromResponse($response);
    }
}
