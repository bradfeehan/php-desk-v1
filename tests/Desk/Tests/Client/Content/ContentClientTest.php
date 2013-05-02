<?php

namespace Desk\Tests\Client\Content;

use Desk\Client\Content\ContentClient;

class ContentClientTest extends \Desk\Testing\UnitTestCase
{

    /**
     * @covers Desk\Client\Content\ContentClient::factory
     * @covers Desk\Client\Content\ContentClient::addServiceDescription
     * @covers Desk\Client\Content\ContentClient::addOAuthPlugin
     */
    public function testFactory()
    {
        $client = $this->getServiceBuilder()->get('mock.content');
        $this->assertInstanceOf('Desk\\Client\\Content\\ContentClient', $client);
    }

    /**
     * @covers Desk\Client\Content\ContentClient::getServiceDescriptionFilename
     * @covers Desk\Client\Content\ContentClient::getChildClassDirectory
     */
    public function testGetServiceDescriptionFilename()
    {
        $filename = ContentClient::getServiceDescriptionFilename();
        $this->assertStringEndsWith('/src/Desk/Client/Content/client.json', $filename);
    }
}
