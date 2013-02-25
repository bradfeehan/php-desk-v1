<?php

namespace Desk\Tests\Account;

use Desk\Account\AccountClient;

class AccountClientTest extends \Guzzle\Tests\GuzzleTestCase
{

    /**
     * @covers Desk\Account\AccountClient::factory
     * @covers Desk\Account\AccountClient::addServiceDescription
     * @covers Desk\Account\AccountClient::addOAuthPlugin
     */
    public function testFactory()
    {
        $client = $this->getServiceBuilder()->get('mock.account');
        $this->assertInstanceOf('Desk\\Account\\AccountClient', $client);
    }

    /**
     * @covers Desk\Account\AccountClient::factory
     */
    public function testFactoryWithSubdomain()
    {
        $client = AccountClient::factory(
            array(
                'base_url' => 'http://{subdomain}.mock.localhost/',
                'subdomain' => 'foo',
                'consumer_key' => 'bar',
                'consumer_secret' => 'baz',
                'token' => 'quux',
                'token_secret' => 'grault',
            )
        );

        $this->assertInstanceOf('Desk\\Account\\AccountClient', $client);
        $this->assertSame('http://foo.mock.localhost/', $client->getBaseUrl());
    }

    /**
     * @covers Desk\Account\AccountClient::getServiceDescriptionFilename
     * @covers Desk\Account\AccountClient::getDirectory
     */
    public function testGetServiceDescriptionFilename()
    {
        $filename = AccountClient::getServiceDescriptionFilename();
        $this->assertStringEndsWith('/src/Desk/Account/client.json', $filename);
    }
}
