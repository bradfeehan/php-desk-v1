<?php

namespace Desk\Testing;

use Guzzle\Service\Client;
use ReflectionClass;
use ReflectionMethod;

abstract class UnitTestCase extends \Guzzle\Tests\GuzzleTestCase
{

    /**
     * The base path of all test cases (usually PROJECT_BASE_DIR/tests)
     *
     * @var string
     */
    private static $testsBasePath;


    /**
     * Set up the base path of all test cases
     *
     * @param string $path The path to the test case root folder
     */
    public static function setTestsBasePath($path)
    {
        self::$testsBasePath = $path;
    }


    /**
     * Set a mock response from a mock file on the next client request
     *
     * Overridden to use some magic to determine the location of the
     * mock files. If the test case is defined in:
     *
     *   PROJECT_ROOT/tests/Foo/Bar/Baz/QuuxTest.php
     *
     * then a $responseName of "grault" will be found in:
     *
     *   PROJECT_ROOT/tests/mock/Foo/Bar/Baz/QuuxTest/grault.txt
     *
     * @param Guzzle\Service\Client Client object to modify
     * @param string $paths Path to files within the Mock
     *                              folder of the service
     *
     * @return Guzzle\Plugin\Mock\MockPlugin The created mock plugin
     */
    public function setMockResponse(Client $client, $responseNames)
    {
        $paths = array();

        foreach ((array) $responseNames as $responseName) {
            $paths[] = $this->getMockResponseDirectory() . "/$responseName.txt";
        }

        return parent::setMockResponse($client, $paths);
    }

    /**
     * Creates a mock Guzzle command with data set in its response
     *
     * The mock command returned will be a Mockery object, but will
     * extend from the OperationCommand class. It will implement the
     * following methods:
     *    - getResponse() - mock Response object with the following methods:
     *        - json() - returns the data in $data
     *        - getBody() - returns JSON-encoded version of $data
     *    - getName() - returns $commandName
     *
     * @param array  $data        Associative array of data in response object
     * @param string $commandName Command name, returned from getName()
     *
     * @return Guzzle\Service\Command\OperationCommand Mock command
     */
    public function createMockCommand($data = array(), $commandName = 'MyCommand')
    {
        return \Mockery::mock(
            'Guzzle\\Service\\Command\\OperationCommand',
            array(
                'getResponse' => $this->createMockResponse($data),
                'getName' => $commandName,
            )
        );
    }

    /**
     * Creates a mock Guzzle response with data
     *
     * The mock response returned will be a Mockery object, but will
     * extend from the Response class. It will implement the following
     * methods:
     *    - json() - returns the data in $data
     *    - getBody() - returns JSON-encoded version of $data
     *
     * @param array $data Associative array of data in response object
     *
     * @return Guzzle\Http\Message\Response Mock command
     */
    public function createMockResponse($data)
    {
        return \Mockery::mock(
            'Guzzle\\Http\\Message\\Response',
            array(
                'json' => $data,
                'getBody' => json_encode($data),
            )
        );
    }

    /**
     * Creates a Mockery mock object with stubs for abstract methods
     *
     * This will create a Mockery mock object which extends the class
     * specified in $className. Any abstract methods which were defined
     * on the $className class will be implemented by the mock (and
     * will return NULL by default, unless any other expectations are
     * later set on the mock).
     *
     * Note that with partial mocks (which this will be), all methods
     * that will be mocked need to be specified at the time the mock is
     * defined (when this method is being called). If there are any
     * methods which are non-abstract that will be mocked by this
     * object, their names should be passed in to the $extraMethods
     * array.
     *
     * @param string $className    The (abstract) class name to mock
     * @param string $extraMethods Any extra methods to stub
     *
     * @return Mockery\MockInterface
     */
    public function createAbstractMock($className, $extraMethods = array())
    {
        $methodNames = $this->getAbstractMethodNames($className);
        $methodNameList = implode(',', array_merge($methodNames, $extraMethods));

        $mock = \Mockery::mock("{$className}[{$methodNameList}]");

        foreach ($methodNames as $method) {
            $mock->shouldReceive($method)->never()->byDefault();
        }

        return $mock;
    }

    /**
     * Gets the names of any abstract methods defined on a class
     *
     * @param string $className The name of the (abstract) class
     *
     * @return array
     */
    private function getAbstractMethodNames($className)
    {
        $class = new ReflectionClass($className);
        $methods = $class->getMethods(ReflectionMethod::IS_ABSTRACT);

        // convert array of ReflectionMethods, to array of method names
        return array_map(
            function ($method) {
                return $method->getName();
            },
            $methods
        );
    }

    /**
     * Gets the path for this test case's mock responses
     *
     * @return string
     */
    private function getMockResponseDirectory()
    {
        $path = $this->getChildClassDirectory();

        // remove test base path, mock response base path is prepended
        $testsBasePath = preg_quote(self::$testsBasePath, '#');
        $path = preg_replace("#^{$testsBasePath}/?#", '', $path);

        return "$path/" . $this->getChildClassName();
    }

    /**
     * Gets the class name of the child class (without namespace)
     *
     * @return string
     */
    private function getChildClassName()
    {
        $class = explode('\\', get_called_class());

        return end($class);
    }

    /**
     * Gets the directory the child class test case is in
     *
     * So not __DIR__ (that would be the directory *this* file is in),
     * but the directory which contains the file containing the
     * definition of the concrete subclass of this class.
     *
     * @return string
     */
    private function getChildClassDirectory()
    {
        $reflectionClass = new ReflectionClass($this);

        return dirname($reflectionClass->getFileName());
    }
}
