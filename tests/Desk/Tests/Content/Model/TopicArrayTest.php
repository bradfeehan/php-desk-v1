<?php

namespace Desk\Tests\Content\Model;

use Desk\Content\Model\TopicArray;

class TopicArrayTest extends \Desk\Testing\UnitTestCase
{

    /**
     * @covers Desk\Content\Model\TopicArray::fromCommand
     */
    public function testFromCommand()
    {
        $command = $this->createMockCommand(
            array(
                'results' => array(
                    0 => array('topic' => array('foo' => 'bar')),
                    1 => array('topic' => array('bar' => 'baz')),
                ),
            )
        );

        $topics = TopicArray::fromCommand($command);
        $this->assertSame(2, count($topics), 'Wrong number of topics returned');

        foreach ($topics as $topic) {
            $this->assertInstanceOf('Desk\\Content\\Model\\TopicModel', $topic);
        }
    }

    /**
     * @covers Desk\Content\Model\TopicArray::fromCommand
     * @expectedException UnexpectedValueException
     */
    public function testFromCommandThrowsExceptionForInvalidFormat()
    {
        $command = $this->createMockCommand(array('foo' => 'bar'));
        TopicArray::fromCommand($command);
    }
}
