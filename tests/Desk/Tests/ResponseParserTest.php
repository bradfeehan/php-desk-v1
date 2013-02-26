<?php

namespace Desk\Tests;

use Desk\ResponseClass;
use Desk\ResponseParser;
use Guzzle\Http\Message\Response;
use Guzzle\Service\Client;
use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Description\ServiceDescription;

class ResponseParserTest extends \Guzzle\Tests\GuzzleTestCase
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
        $responseClass = 'Desk\\Testing\\MockResponseClass';

        $parser = ResponseParser::getInstance();
        $description = ServiceDescription::factory(
            array(
                'operations' => array(
                    'test' => array(
                        'responseClass' => $responseClass,
                        'responseType'  => 'class',
                    ),
                ),
            )
        );

        $operation = $description->getOperation('test');
        $command = new OperationCommand(array(), $operation);
        $command->setResponseParser($parser)->setClient(new Client());

        $command->prepare()->setResponse($this->getJsonResponse(), true);

        $result = $command->execute();
        $this->assertInstanceOf('Desk\\ResponseClass', $result);
    }

    /**
     * @covers Desk\ResponseParser::handleParsing
     * @expectedException UnexpectedValueException
     */
    public function testHandleParsingThrowsExceptionForWrongClass()
    {
        $responseClass = 'stdClass';

        $parser = ResponseParser::getInstance();
        $description = ServiceDescription::factory(
            array(
                'operations' => array(
                    'test' => array(
                        'responseClass' => $responseClass,
                        'responseType'  => 'class',
                    ),
                ),
            )
        );

        $operation = $description->getOperation('test');
        $command = new OperationCommand(array(), $operation);
        $command->setResponseParser($parser)->setClient(new Client());

        $command->prepare()->setResponse($this->getJsonResponse(), true);

        $result = $command->execute();
        $this->assertInstanceOf('Desk\\ResponseClass', $result);
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
