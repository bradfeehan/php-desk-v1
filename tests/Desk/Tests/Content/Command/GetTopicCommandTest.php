<?php

namespace Desk\Tests\Content\Command;

class GetTopicCommandTest extends \Desk\Testing\OperationTestCase
{

    protected $client = 'mock.content';

    protected $operation = 'GetTopic';


    public function dataParameterValid()
    {
        return array(
            array(array('id' => 12)),
            array(array('id' => 54)),
            array(array('id' => 23)),
        );
    }

    public function dataParameterInvalid()
    {
        return array(
            array(array('id' => true)),
            array(array('id' => false)),
            array(array('id' => null)),
            array(array('id' => -1)),
            array(array('id' => 12.5)),
            array(array('id' => -13.4)),
            array(array('id' => new \stdClass())),
            array(array('id' => array('foo' => 'bar'))),
        );
    }

    /**
     * @coversNothing
     */
    public function testSystem()
    {
        $client = $this->client();
        $this->setMockResponse($client, 'success');
        $topic = $client->GetTopic(array('id' => 345678));

        $this->assertInstanceOf('Desk\\Content\\Model\\TopicModel', $topic);
        $this->assertSame('Test Topic', $topic->get('name'));
    }

    /**
     * @coversNothing
     * @expectedException UnexpectedValueException
     */
    public function testSystemWithInvalidSchemaResponse()
    {
        $client = $this->client();
        $this->setMockResponse($client, 'invalid-schema');
        $client->GetTopic(array('id' => 345678));
    }

    /**
     * This will be skipped if there is no "example_topic_id" parameter
     * set on the test.content client.
     *
     * @group network
     * @coversNothing
     */
    public function testNetwork()
    {
        $client = $this->getServiceBuilder()->get('test.content');
        $topicId = $client->getConfig()->get('example_topic_id');

        if ($topicId === null) {
            $this->markTestSkipped('No example topic ID set');
            return;
        }

        $topic = $client->GetTopic(array('id' => $topicId));
        $this->assertInstanceOf('Desk\\Content\\Model\\TopicModel', $topic);
        $this->assertSame($topicId, $topic->get('id'));
    }
}
