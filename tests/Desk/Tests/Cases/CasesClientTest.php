<?php

namespace Desk\Tests\Cases;

use Desk\Cases\CasesClient;

class CasesClientTest extends \Desk\Testing\UnitTestCase
{

    /**
     * @covers Desk\Cases\CasesClient::factory
     * @covers Desk\Cases\CasesClient::addServiceDescription
     * @covers Desk\Cases\CasesClient::addOAuthPlugin
     */
    public function testFactory()
    {
        $client = $this->getServiceBuilder()->get('mock.cases');
        $this->assertInstanceOf('Desk\\Cases\\CasesClient', $client);
    }

    /**
     * @covers Desk\Cases\CasesClient::getServiceDescriptionFilename
     * @covers Desk\Cases\CasesClient::getDirectory
     */
    public function testGetServiceDescriptionFilename()
    {
        $filename = CasesClient::getServiceDescriptionFilename();
        $this->assertStringEndsWith('/src/Desk/Cases/client.json', $filename);
    }
}
