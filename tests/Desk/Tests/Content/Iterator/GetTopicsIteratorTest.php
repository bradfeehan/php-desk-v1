<?php

namespace Desk\Tests\Content\Iterator;

class GetTopicsIteratorTest extends \Desk\Testing\UnitTestCase
{

    /**
     * @covers Desk\Content\Iterator\GetTopicsIterator::sendRequest
     */
    public function testSendRequest()
    {
        $client = $this->getServiceBuilder()->get('mock.content');

        $this->setMockResponse(
            $client,
            array(
                'success/1',
                'success/2',
                'success/3',
                'success/4',
            )
        );

        $iterator = $client->getIterator('GetTopics');

        $topics = iterator_to_array($iterator);
        $this->assertSame(12, count($topics));

        $index = 0;
        foreach ($topics as $topic) {
            $this->assertInstanceOf('Desk\\Content\\Model\\TopicModel', $topic);
            $this->assertSame(++$index, $topic['id']);
        }
    }
}
