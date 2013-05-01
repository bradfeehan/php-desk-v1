<?php

namespace Desk\Tests\Cases\Command;

class GetCaseCommandTest extends \Desk\Testing\OperationTestCase
{

    /**
     * {@inheritdoc}
     */
    protected function getClientName()
    {
        return 'mock.cases';
    }

    /**
     * {@inheritdoc}
     */
    protected function getOperationName()
    {
        return 'GetCase';
    }

    public function dataParameterValid()
    {
        return array(
            array(array(
                'id' => 44,
            )),
            array(array(
                'id' => 54,
                'by' => 'id',
            )),
            array(array(
                'id' => 23,
                'by' => 'external_id',
            )),
        );
    }

    public function dataParameterInvalid()
    {
        return array(
            array(array('id' => false)),
            array(array('id' => null)),
            array(array('id' => new \stdClass())),
            array(array('by' => 'id')),
            array(array('by' => 'external_id')),
        );
    }

    /**
     * @coversNothing
     */
    public function testSystem()
    {
        $client = $this->client();
        $this->setMockResponse($client, 'success');
        $case = $client->GetCase(array('id' => 1));

        $this->assertInstanceOf('Desk\\Cases\\Model\\CaseModel', $case);
        $this->assertSame('email', $case->get('channel'));
    }

    /**
     * @coversNothing
     * @expectedException UnexpectedValueException
     */
    public function testSystemWithInvalidSchemaResponse()
    {
        $client = $this->client();
        $this->setMockResponse($client, 'invalid-schema');
        $client->GetCase(array('id' => 1));
    }

    /**
     * This will fail if there are no cases currently in Desk, as it
     * attempts to retrieve the first case.
     *
     * @group network
     * @coversNothing
     */
    public function testNetwork()
    {
        $client = $this->getServiceBuilder()->get('test.cases');
        $case = $client->GetCase(array('id' => 1));
        $this->assertInstanceOf('Desk\\Cases\\Model\\CaseModel', $case);
        $this->assertSame(1, $case->get('id'));
    }
}
