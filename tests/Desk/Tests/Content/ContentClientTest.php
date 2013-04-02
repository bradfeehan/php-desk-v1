<?php

namespace Desk\Tests\Content;

use Desk\Content\ContentClient;

class ContentClientTest extends \Desk\Testing\UnitTestCase
{

    /**
     * @covers Desk\Content\ContentClient::factory
     * @covers Desk\Content\ContentClient::addServiceDescription
     * @covers Desk\Content\ContentClient::addOAuthPlugin
     */
    public function testFactory()
    {
        $client = $this->getServiceBuilder()->get('mock.content');
        $this->assertInstanceOf('Desk\\Content\\ContentClient', $client);
    }

    /**
     * @covers Desk\Content\ContentClient::getServiceDescriptionFilename
     * @covers Desk\Content\ContentClient::getChildClassDirectory
     */
    public function testGetServiceDescriptionFilename()
    {
        $filename = ContentClient::getServiceDescriptionFilename();
        $this->assertStringEndsWith('/src/Desk/Content/client.json', $filename);
    }
}
