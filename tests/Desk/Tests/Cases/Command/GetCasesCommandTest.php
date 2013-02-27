<?php

namespace Desk\Tests\Cases\Command;

class GetCasesCommandTest extends \Desk\Testing\UnitTestCase
{

    /**
     * @coversNothing
     */
    public function testSuccess()
    {
        $client = $this->getServiceBuilder()->get('mock.cases');
        $this->setMockResponse($client, 'success');
        $cases = $client->GetCases();

        $this->assertSame(20, count($cases));

        foreach ($cases as $case) {
            $this->assertInstanceOf('Desk\\Cases\\Model\\CaseModel', $case);
        }
    }

    /**
     * @coversNothing
     * @expectedException UnexpectedValueException
     */
    public function testInvalidSchema()
    {
        $client = $this->getServiceBuilder()->get('mock.cases');
        $this->setMockResponse($client, 'invalid-schema');
        $client->GetCases();
    }
}
