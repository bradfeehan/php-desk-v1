<?php

namespace Desk\Tests\Content\Model;

use Desk\Content\Model\TopicModel;

class TopicModelTest extends \Desk\Testing\UnitTestCase
{

    /**
     * @covers Desk\Content\Model\TopicModel::fromCommand
     */
    public function testFromCommand()
    {
        $command = $this->createMockCommand(
            array(
                'topic' => array('foo' => 'bar'),
            )
        );

        $topic = TopicModel::fromCommand($command);
        $this->assertInstanceOf('Desk\\Content\\Model\\TopicModel', $topic);
    }

    /**
     * @covers Desk\Content\Model\TopicModel::fromCommand
     * @expectedException UnexpectedValueException
     */
    public function testFromCommandThrowsExceptionForInvalidFormat()
    {
        $command = $this->createMockCommand(array('foo' => 'bar'));
        TopicModel::fromCommand($command);
    }
}
