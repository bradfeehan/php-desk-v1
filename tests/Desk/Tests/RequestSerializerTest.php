<?php

namespace Desk\Tests;

use Desk\RequestSerializer;
use Guzzle\Service\Client as ServiceClient;
use Guzzle\Service\Command\OperationCommand;

class RequestSerializerTest extends \Desk\Testing\UnitTestCase
{

    private static function createRequest()
    {
        $command = new OperationCommand();
        $command->setClient(new ServiceClient());

        return RequestSerializer::getInstance()
            ->createRequest($command);
    }

    /**
     * @covers Desk\RequestSerializer::getInstance
     */
    public function testGetInstance()
    {
        $instance = RequestSerializer::getInstance();
        $this->assertInstanceOf('Desk\\RequestSerializer', $instance);
    }

    /**
     * @covers Desk\RequestSerializer::createRequest()
     */
    public function testCreateRequest()
    {
        $request = self::createRequest();
        $requestType = 'Guzzle\\Http\\Message\\RequestInterface';
        $this->assertInstanceOf($requestType, $request);
    }

    /**
     * @covers Desk\RequestSerializer::createRequest()
     */
    public function testRequestUsesCommaAggregator()
    {
        $query = self::createRequest()->getQuery();

        // Get value of aggregator -- needs to be retrieved from the
        // private property because it's not exposed
        $reflection = new \ReflectionObject($query);
        $property = $reflection->getProperty('aggregator');
        $property->setAccessible(true);
        $aggregator = $property->getValue($query);

        // Check that it's using the CommaAggregator
        $commaAggregator = 'Guzzle\\Http\\QueryAggregator\\CommaAggregator';
        $this->assertInstanceOf($commaAggregator, $aggregator);
    }
}
