<?php

namespace Desk\Tests;

use Desk\PreValidator;
use Guzzle\Common\Event;
use Guzzle\Common\ToArrayInterface;
use Guzzle\Service\Client;
use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Description\Operation;

class PreValidatorTest extends \Desk\Testing\UnitTestCase
{

    /**
     * @covers Desk\PreValidator::getSubscribedEvents
     */
    public function testGetSubscribedEvents()
    {
        $events = PreValidator::getSubscribedEvents();
        $this->assertInternalType('array', $events);
    }

    /**
     * @covers Desk\PreValidator::castPrimitivesToArrays
     * @dataProvider dataCastPrimitivesToArrays
     */
    public function testCastPrimitivesToArrays($command, $expected)
    {
        $preValidator = new PreValidator();

        $event = new Event(array('command' => $command));
        $preValidator->castPrimitivesToArrays($event);

        $actual = $command->get('foo');
        if ($actual instanceof ToArrayInterface) {
            $actual = $actual->toArray();
        }

        $this->assertSame($expected, $actual);
    }

    public function dataCastPrimitivesToArrays($command)
    {
        return array(
            array(
                $this->command(
                    // service description
                    array(
                        // "foo" parameter must be array of integers
                        'foo' => array(
                            'name' => 'foo',
                            'type' => 'array',
                            'items' => array(
                                'type' => 'integer',
                            ),
                        ),
                    ),
                    // Set "foo" to a bare integer (not in an array)
                    array('foo' => 36)
                ),
                // Expected result: should be wrapped in an array
                array(36),
            ),
            array(
                $this->command(
                    // service description
                    array(
                        // "foo" parameter must be array of integers
                        'foo' => array(
                            'name' => 'foo',
                            'type' => 'array',
                            'items' => array(
                                'type' => 'integer',
                            ),
                        ),
                    ),
                    // Set "foo" to object implementing ToArrayInterface
                    array(
                        'foo' => \Mockery::mock(
                            'Guzzle\\Common\\ToArrayInterface',
                            array('toArray' => array(45))
                        ),
                    )
                ),
                // Expected result: value of object's toArray() function
                array(45),
            ),
            array(
                $this->command(
                    // service description
                    array(
                        // "foo" parameter must be array of integers
                        'foo' => array(
                            'name' => 'foo',
                            'type' => 'array',
                            'items' => array(
                                'type' => 'integer',
                            ),
                        ),
                    ),
                    // Set no parameters in constructor
                    array()
                ),
                // Expected result: "foo" parameter not set (is NULL)
                null,
            ),
        );
    }

    /**
     * @covers Desk\PreValidator::castPrimitivesToArrays
     */
    public function testCastPrimitivesToArraysIgnoresBadEvents()
    {
        $preValidator = new PreValidator();

        $event = new Event(array('command' => new \stdClass()));
        $preValidator->castPrimitivesToArrays($event);

        $this->assertTrue(true); // assert no exception thrown
    }

    /**
     * Configures a command with parameters and values
     *
     * The parameters of the operation associated with the command will
     * be setup using the definitions in $params, and the values of the
     * parameters is set using $values (key-value).
     *
     * @param array $params Parameter definitions
     * @param array $values Values of each parameter
     *
     * @return Guzzle\Service\Command\OperationCommand
     */
    private function command($params, $values)
    {
        $operation = new Operation(array('parameters' => $params));
        $command = new OperationCommand($values, $operation);

        return $command->setClient(new Client());
    }
}
