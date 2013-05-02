<?php

namespace Desk\Tests\Client\Cases\Command;

class UpdateCaseCommandTest extends \Desk\Testing\OperationTestCase
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
        return 'UpdateCase';
    }

    public function dataParameterValid()
    {
        return array(
            array(
                array(
                    'id' => 22,
                    'subject' => 'New Subject',
                    'labels' => array('foo', 'bar'),
                ),
            ),
            array(
                array(
                    'id' => 43,
                    'status' => 'pending',
                ),
                array('postFields' => '/case_status_type_id=50/'),
            ),
        );
    }

    public function dataParameterInvalid()
    {
        return array(
            array(array(
                'subject' => 'Missing ID',
            )),
            array(array(
                'id' => 34,
                'status' => 'not_a_valid_status',
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
        $case = $client->UpdateCase(array('id' => 2, 'priority' => 4));

        $this->assertInstanceOf('Desk\\Client\\Cases\\Model\\CaseModel', $case);
        $this->assertEquals('1000006', $case->get('last_saved_by_id'));
    }

    /**
     * @coversNothing
     * @expectedException Guzzle\Http\Exception\ClientErrorResponseException
     */
    public function testErrorOnAttemptUpdateClosedCase()
    {
        $client = $this->client();
        $this->setMockResponse($client, 'attempt-update-closed-case');
        $client->UpdateCase(array('id' => 1, 'priority' => 4));
    }
}
