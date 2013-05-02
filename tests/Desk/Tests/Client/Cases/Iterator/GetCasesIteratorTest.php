<?php

namespace Desk\Tests\Client\Cases\Iterator;

class GetCasesIteratorTest extends \Desk\Testing\UnitTestCase
{

    /**
     * @covers Desk\Client\Cases\Iterator\GetCasesIterator::sendRequest
     */
    public function testSendRequest()
    {
        $client = $this->getServiceBuilder()->get('mock.cases');

        $this->setMockResponse(
            $client,
            array(
                'success/1',
                'success/2',
                'success/3',
                'success/4',
            )
        );

        $iterator = $client->getIterator(
            'GetCases',
            array('max_id' => 15)
        );

        $cases = iterator_to_array($iterator);
        $this->assertSame(15, count($cases));

        $index = 0;
        foreach ($cases as $case) {
            $this->assertSame(++$index, $case['id']);
        }
    }
}
