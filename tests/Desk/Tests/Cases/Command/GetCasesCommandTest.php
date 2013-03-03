<?php

namespace Desk\Tests\Cases\Command;

class GetCasesCommandTest extends \Desk\Testing\UnitTestCase
{

    /**
     * @coversNothing
     * @dataProvider dataParameter
     *
     * @param string $name       Parameter name
     * @param mixed  $value      Value to set the parameter to
     * @param string $queryRegex A regex to apply against the resulting
     *                           request object's query string (optional).
     *                           If omitted, this test just asserts that
     *                           the request is created correctly.
     */
    public function testParameter($name, $value, $queryRegex = null)
    {
        $request = $this->getServiceBuilder()->get('test.cases')
            ->getCommand('GetCases', array($name => $value))
            ->prepare();

        $requestInterface = 'Guzzle\\Http\\Message\\RequestInterface';
        $this->assertInstanceOf($requestInterface, $request);

        if ($queryRegex !== null) {
            $this->assertRegExp($queryRegex, (string) $request->getQuery());
        }
    }

    public function dataParameter()
    {
        return array(
            array('name', 'Test Name', '/name=Test%20Name/'),
            array('first_name', array('Firstname1', 'Firstname2'), '/first_name=Firstname1,Firstname2/'),
            array('email', 'test@example.com', '/email=test%40example.com/'),
            array('case_id', array(1, 2, 4)),
            array('case_id', 1),
            array('status', array('open')),
            array('status', array('open', 'resolved')),
            array('status', 'pending'),
            array('priority', array(1)),
            array('priority', array(1, 2, 6, 7)),
            array('priority', 10),
            array('channels', array('email')),
            array('channels', array('phone', 'callback')),
            array('created', 'today'),
            array('updated', 'year'),
            array('since_created_at',
                new \DateTime('2013-03-01 10:03am', new \DateTimeZone('UTC')),
                '/since_created_at=1362132180/'
            ),
            array('max_updated_at', '2013-03-04 10:03am'),
            array('max_id', 22),
        );
    }

    /**
     * @coversNothing
     * @dataProvider dataParameterInvalid
     * @expectedException Guzzle\Service\Exception\ValidationException
     */
    public function testParameterInvalid($name, $value)
    {
        $this->getServiceBuilder()->get('test.cases')
            ->getCommand('GetCases', array($name => $value))
            ->prepare();
    }

    public function dataParameterInvalid()
    {
        return array(
            array('name', new \stdClass()),
            array('first_name', true),
            array('last_name', false),
            array('email', 'invalid_e-mail_address'),
            array('case_id', array('foobar')),
            array('case_id', 'foobar'),
            array('status', array('bar-baz')),
            array('status', array('open', 'bar-baz')),
            array('status', 'bar-baz'),
            array('priority', array(0)),
            array('priority', array(11)),
            array('priority', array(-1)),
            array('priority', array(1, 13)),
            array('priority', -2),
            array('priority', 3.14),
            array('channels', array('quux')),
            array('channels', array('twitter', 'quuux')),
            array('created', array('today')),
            array('updated', 'not-an-option'),
            array('since_id', array(44)),
        );
    }

    /**
     * @coversNothing
     */
    public function testSystem()
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
    public function testSystemWithInvalidSchemaResponse()
    {
        $client = $this->getServiceBuilder()->get('mock.cases');
        $this->setMockResponse($client, 'invalid-schema');
        $client->GetCases();
    }
}
