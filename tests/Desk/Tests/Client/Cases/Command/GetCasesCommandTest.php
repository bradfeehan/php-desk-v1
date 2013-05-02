<?php

namespace Desk\Tests\Client\Cases\Command;

class GetCasesCommandTest extends \Desk\Testing\OperationTestCase
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
        return 'GetCases';
    }

    public function dataParameterValid()
    {
        return array(
            array(array('name' => 'Test Name', array('query' => '/name=Test%20Name/'))),
            array(
                array('first_name' => array('Firstname1', 'Firstname2')),
                array('query' => '/first_name=Firstname1,Firstname2/')
            ),
            array(array('email' => 'test@example.com', array('query' => '/email=test%40example.com/'))),
            array(array('case_id' => array(1, 2, 4))),
            array(array('case_id' => 1)),
            array(array('status' => array('open'))),
            array(array('status' => array('open', 'resolved'))),
            array(array('status' => 'pending')),
            array(array('priority' => array(1))),
            array(array('priority' => array(1, 2, 6, 7))),
            array(array('priority' => 10)),
            array(array('channels' => array('email'))),
            array(array('channels' => array('phone', 'callback'))),
            array(array('created' => 'today')),
            array(array('updated' => 'year')),
            array(
                array('since_created_at' => new \DateTime('2013-03-01 10:03am', new \DateTimeZone('UTC'))),
                array('query' => '/since_created_at=1362132180/')
            ),
            array(array('max_updated_at' => '2013-03-04 10:03am')),
            array(array('max_id' => 22)),
            array(array('count' => 20)),
            array(array('count' => 100)),
            array(array('page' => 12)),
        );
    }

    public function dataParameterInvalid()
    {
        return array(
            array(array('name' => new \stdClass())),
            array(array('first_name' => true)),
            array(array('last_name' => false)),
            array(array('email' => 'invalid_e-mail_address')),
            array(array('case_id' => array('foobar'))),
            array(array('case_id' => 'foobar')),
            array(array('case_id' => -43)),
            array(array('status' => array('bar-baz'))),
            array(array('status' => array('open', 'bar-baz'))),
            array(array('status' => 'bar-baz')),
            array(array('priority' => array(0))),
            array(array('priority' => array(11))),
            array(array('priority' => array(-1))),
            array(array('priority' => array(1, 13))),
            array(array('priority' => -2)),
            array(array('priority' => 3.14)),
            array(array('channels' => array('quux'))),
            array(array('channels' => array('twitter', 'quuux'))),
            array(array('created' => array('today'))),
            array(array('updated' => 'not-an-option')),
            array(array('since_id' => array(44))),
            array(array('count' => -2)),
            array(array('count' => 101)),
            array(array('page' => 0)),
        );
    }

    /**
     * @coversNothing
     */
    public function testSystem()
    {
        $client = $this->client();
        $this->setMockResponse($client, 'success');
        $cases = $client->GetCases();

        $this->assertSame(20, count($cases));

        foreach ($cases as $case) {
            $this->assertInstanceOf('Desk\\Client\\Cases\\Model\\CaseModel', $case);
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
        $client->GetCases();
    }

    /**
     * @group network
     * @coversNothing
     */
    public function testNetwork()
    {
        $client = $this->getServiceBuilder()->get('test.cases');
        $cases = $client->GetCases();

        $this->assertInternalType('array', $cases);

        // If no cases returned, the foreach will be skipped
        foreach ($cases as $case) {
            $this->assertInstanceOf('Desk\\Client\\Cases\\Model\\CaseModel', $case);
        }
    }
}
