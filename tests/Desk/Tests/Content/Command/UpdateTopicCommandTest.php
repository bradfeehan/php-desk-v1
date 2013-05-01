<?php

namespace Desk\Tests\Content\Command;

class UpdateTopicCommandTest extends \Desk\Testing\OperationTestCase
{

    /**
     * {@inheritdoc}
     */
    protected function getClientName()
    {
        return 'mock.content';
    }

    /**
     * {@inheritdoc}
     */
    protected function getOperationName()
    {
        return 'UpdateTopic';
    }

    public function dataParameterValid()
    {
        return array(
            array(array(
                'id' => 100,
                'name' => 'foo',
            )),
            array(array(
                'id' => 200,
                'description' => 'the description',
            )),
            array(array(
                'id' => 343,
                'show_in_portal' => true,
            )),
            array(array(
                'id' => 2401,
                'language' => 'de',
            )),
            array(array(
                'id' => 99,
                'show_in_portal' => false,
                'language' => 'fr',
            )),
            array(array(
                'id' => 123,
                'name' => 'foo',
                'description' => 'the description',
                'show_in_portal' => true,
                'language' => 'de',
            )),
        );
    }

    public function dataParameterInvalid()
    {
        return array(
            array(array()),
            array(array('id' => 'foo')),
            array(array('id' => 12.5)),
            array(array('id' => -1)),
            array(array('id' => -13.4)),
            array(array('id' => false)),
            array(array('id' => true)),
            array(array('id' => null)),
            array(array('id' => new \stdClass())),
            array(array(
                'name' => 'missing ID',
            )),
            array(array(
                'id' => 4,
                'name' => false,
            )),
            array(array(
                'id' => 4,
                'description' => new \stdClass(),
            )),
            array(array(
                'id' => 5,
                'show_in_portal' => 'true',
            )),
            array(array(
                'id' => 6,
                'language' => 'invalid',
            )),
            array(array(
                'id' => 7,
                'language' => true,
            )),
        );
    }

    public function testSystem()
    {
        $client = $this->client();
        $this->setMockResponse($client, 'success');
        $topic = $client->UpdateTopic(
            array(
                'id' => 13,
                'name' => 'Updated',
                'description' => 'Updated Description',
            )
        );

        $this->assertInstanceOf('Desk\\Content\\Model\\TopicModel', $topic);
        $this->assertSame(13, $topic->get('id'));
        $this->assertSame('Updated', $topic->get('name'));
        $this->assertSame('Updated Description', $topic->get('description'));
        $this->assertSame(true, $topic->get('show_in_portal'));
    }

    /**
     * @coversNothing
     * @expectedException UnexpectedValueException
     */
    public function testSystemWithInvalidSchemaResponse()
    {
        $client = $this->client();
        $this->setMockResponse($client, 'invalid-schema');
        $client->CreateTopic(
            array(
                'name' => 'General',
                'description' => 'Everything belongs here',
                'show_in_portal' => true,
            )
        );
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

        $topic = $client->UpdateTopic(
            array(
                'id' => $topicId,
                'description' => 'Updated description',
            )
        );

        $this->assertInstanceOf('Desk\\Content\\Model\\TopicModel', $topic);
        $this->assertSame((integer) $topicId, $topic->get('id'));
        $this->assertSame('Updated description', $topic->get('description'));
    }
}
