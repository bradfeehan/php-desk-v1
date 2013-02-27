<?php

namespace Desk\Testing;

use Guzzle\Service\Client;
use ReflectionClass;

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
