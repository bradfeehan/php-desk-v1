<?php

namespace Desk\Tests\Client\Content\Command;

class GetTopicsCommandTest extends \Desk\Testing\OperationTestCase
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
        return 'GetTopics';
    }

    public function dataParameterValid()
    {
        return array(
            array(array('count' => 100)),
            array(array('count' => 3)),
            array(array('page' => 4)),
        );
    }

    public function dataParameterInvalid()
    {
        return array(
            array(array('count' => 200)),
            array(array('count' => -2)),
            array(array('page' => -4)),
        );
    }

    /**
     * @coversNothing
     */
    public function testSystem()
    {
        $client = $this->client();
        $this->setMockResponse($client, 'success');
        $topics = $client->GetTopics();

        $this->assertSame(2, count($topics));

        foreach ($topics as $topic) {
            $this->assertInstanceOf('Desk\\Client\\Content\\Model\\TopicModel', $topic);
        }
    }

    /**
     * @coversNothing
     * @expectedException UnexpectedValueException
     */
    public function testSystemWithInvalidSchemaResponse()
    {
        $client = $this->client();
        $this->setMockResponse($client, 'invalid-schema');
        $client->GetTopics();
    }

    /**
     * @group network
     * @coversNothing
     */
    public function testNetwork()
    {
        $client = $this->getServiceBuilder()->get('test.content');
        $topics = $client->GetTopics();

        $this->assertInternalType('array', $topics);

        // If no topics returned, the foreach will be skipped
        foreach ($topics as $case) {
            $this->assertInstanceOf('Desk\\Client\\Content\\Model\\TopicModel', $case);
        }
    }
}
