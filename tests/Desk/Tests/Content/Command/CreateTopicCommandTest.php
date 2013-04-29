<?php

namespace Desk\Tests\Content\Command;

class CreateTopicCommandTest extends \Desk\Testing\OperationTestCase
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
        return 'CreateTopic';
    }

    public function dataParameterValid()
    {
        return array(
            array(array(
                'name' => 'Test Topic',
            )),
            array(array(
                'name' => 'Topic 1',
                'description' => 'Topic 1 description',
            )),
            array(array(
                'name' => 'Topic 2',
                'show_in_portal' => true,
            )),
            array(array(
                'name' => 'Topic 3',
                'description' => 'Topic 3 description',
                'show_in_portal' => true,
            )),
            array(array(
                'name' => 'Topic 4',
                'description' => 'Topic 4 description',
                'show_in_portal' => false,
            )),
        );
    }

    public function dataParameterInvalid()
    {
        return array(
            array(array('name' => true)),
            array(array('name' => false)),
            array(array('name' => null)),
            array(array('name' => new \stdClass())),
            array(array(
                'name' => 'valid',
                'description' => false,
            )),
            array(array(
                'name' => 'valid',
                'show_in_portal' => 'invalid',
            )),
            array(array(
                'description' => 'missing name',
            )),
            array(array(
                'show_in_portal' => true,
            )),
        );
    }

    /**
     * @coversNothing
     */
    public function testSystem()
    {
        $client = $this->client();
        $this->setMockResponse($client, 'success');
        $topic = $client->CreateTopic(
            array(
                'name' => 'General',
                'description' => 'Everything belongs here',
                'show_in_portal' => true,
            )
        );

        $this->assertInstanceOf('Desk\\Content\\Model\\TopicModel', $topic);
        $this->assertSame(9, $topic->get('id'));
        $this->assertSame('General', $topic->get('name'));
        $this->assertSame('Everything belongs here', $topic->get('description'));
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
}
