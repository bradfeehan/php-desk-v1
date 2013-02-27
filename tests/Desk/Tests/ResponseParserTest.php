<?php

namespace Desk\Tests;

use Desk\Model\FromResponse;
use Desk\Model\ModelFactory;
use Desk\ResponseParser;
use Guzzle\Http\Message\Response;
use Guzzle\Service\Client;
use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Description\ServiceDescription;

class ResponseParserTest extends \Desk\Testing\UnitTestCase
{

    /**
     * @covers Desk\ResponseParser::getInstance
     */
    public function testGetInstance()
    {
        $parser = ResponseParser::getInstance();
        $this->assertInstanceOf('Desk\\ResponseParser', $parser);
    }

    /**
     * @covers Desk\ResponseParser::handleParsing
     */
    public function testHandleParsing()
    {
        // Prepare input
        $parser = ResponseParser::getInstance();
        $description = ServiceDescription::factory(
            array(
                'operations' => array(
                    'test' => array(
                        'responseClass' => 'MyClass',
                        'responseType'  => 'class',
                    ),
                ),
            )
        );

        $operation = $description->getOperation('test');
        $command = new OperationCommand(array(), $operation);
        $command->setResponseParser($parser)->setClient(new Client());

        $response = \Mockery::mock('Guzzle\\Http\\Message\\Response[]');
        $command->prepare()->setResponse($response, true);

        // Set up expectations
        $factory = \Mockery::mock('Desk\\Model\\ModelFactory')
            ->shouldReceive('fromResponse')->once()
            ->with('MyClass', $response)
            ->andReturn('test')
            ->mock();

        ModelFactory::setInstance($factory);

        $result = $command->execute();
        $this->assertSame('test', $result);
    }

    /**
     * @covers Desk\ResponseParser::handleParsing
     */
    public function testHandleParsingForNonClassResponseType()
    {
        $parser = ResponseParser::getInstance();
        $description = ServiceDescription::factory(
            array(
                'operations' => array(
                    'test' => array(),
                ),
            )
        );

        $operation = $description->getOperation('test');
        $command = new OperationCommand(array(), $operation);
        $command->setResponseParser($parser)->setClient(new Client());

        $command->prepare()->setResponse($this->getJsonResponse(), true);

        $result = $command->execute();
        $this->assertInternalType('array', $result);
    }

    private function getJsonResponse()
    {
        $content = array('foo' => 'bar');
        $headers = array('Content-Type' => 'application/json');

        return new Response(200, $headers, json_encode($content));
    }
}
