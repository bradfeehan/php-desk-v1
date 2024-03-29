<?php

namespace Desk\Testing;

abstract class OperationTestCase extends UnitTestCase
{

    /**
     * Gets the client specified in self::getClientName()
     *
     * @return Guzzle\Service\Client
     */
    final public function client()
    {
        return $this->getServiceBuilder()->get($this->getClientName());
    }

    /**
     * @coversNothing
     * @dataProvider dataParameterValid
     *
     * @param array $parameters Parameter names => parameter values
     * @param array $assertions Assertions to make after setting value.
     *    If this parameter is omitted, the test will just assert that
     *    the request is created correctly. Valid keys include:
     *     - query:      A regex to apply against the resulting request
     *                   object's query string.
     *     - postFields: A regex to apply against the resulting request
     *                   object's post fields.
     */
    public function testParameterValid($parameters, $assertions = null)
    {
        $request = $this->client()
            ->getCommand($this->getOperationName(), $parameters)
            ->prepare();

        $requestInterface = 'Guzzle\\Http\\Message\\RequestInterface';
        $this->assertInstanceOf($requestInterface, $request);

        if (isset($assertions['query'])) {
            $this->assertRegExp($assertions['query'], (string) $request->getQuery());
        }

        if (isset($assertions['postFields'])) {
            $this->assertRegExp($assertions['postFields'], (string) $request->getPostFields());
        }
    }

    /**
     * @coversNothing
     * @dataProvider dataParameterInvalid
     * @expectedException Guzzle\Service\Exception\ValidationException
     */
    public function testParameterInvalid($parameters)
    {
        $this->client()
            ->getCommand($this->getOperationName(), $parameters)
            ->prepare();
    }

    /**
     * The name of the client to be tested
     *
     * This should be one of the keys under "services" in the service
     * description used for the tests.
     *
     * @return string
     */
    abstract protected function getClientName();

    /**
     * The name of the operation to be tested
     *
     * This should be one of the keys under "operation" in the client's
     * service description.
     *
     * @var string
     */
    abstract protected function getOperationName();

    /**
     * Provides data for testParameterValid
     *
     * Should return an array in the following format:
     *
     * array(
     *   array($name1, $value1, $queryRegex1),
     *   array($name2, $value2, $queryRegex2),
     *   // ...
     * );
     *
     * The test will be ran once for each element in the root of the
     * array (e.g. twice in the example above).
     *
     * The parameter with key $name1 will be set to $value1 and the
     * query string of the request will be tested to ensure it matches
     * $queryRegex1. If an exception is thrown or the regex doesn't
     * match, the test will fail.
     */
    abstract public function dataParameterValid();

    /**
     * Provides data for testParameterInvalid
     *
     * Should return an array in the following format:
     *
     * array(
     *   array($name1, $value1),
     *   array($name2, $value2),
     *   // ...
     * );
     *
     * The test will be ran once for each element in the root of the
     * array (e.g. twice in the example above).
     *
     * The parameter with key $name1 will be set to $value1, and the
     * Command should throw a ValidationException.
     */
    abstract public function dataParameterInvalid();
}
