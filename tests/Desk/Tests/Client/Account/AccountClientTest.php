<?php

namespace Desk\Tests\Client\Account;

use Desk\Client\Account\AccountClient;

class AccountClientTest extends \Desk\Testing\UnitTestCase
{

    /**
     * @covers Desk\Client\Account\AccountClient::factory
     * @covers Desk\Client\Account\AccountClient::addServiceDescription
     * @covers Desk\Client\Account\AccountClient::addOAuthPlugin
     */
    public function testFactory()
    {
        $client = $this->getServiceBuilder()->get('mock.account');
        $this->assertInstanceOf('Desk\\Client\\Account\\AccountClient', $client);
    }

    /**
     * @covers Desk\Client\Account\AccountClient::factory
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

        $this->assertInstanceOf('Desk\\Client\\Account\\AccountClient', $client);
        $this->assertSame('http://foo.mock.localhost/', $client->getBaseUrl());
    }

    /**
     * @covers Desk\Client\Account\AccountClient::getServiceDescriptionFilename
     * @covers Desk\Client\Account\AccountClient::getChildClassDirectory
     */
    public function testGetServiceDescriptionFilename()
    {
        $filename = AccountClient::getServiceDescriptionFilename();
        $this->assertStringEndsWith('/src/Desk/Client/Account/client.json', $filename);
    }

    /**
     * @covers Desk\Client\Account\AccountClient::getCommand
     */
    public function testGetCommand()
    {
        $client = new AccountClient();

        $command = \Mockery::mock('Guzzle\\Service\\Command\\OperationCommand[]');

        $commandFactory = \Mockery::mock('Guzzle\\Service\\Command\\Factory\\FactoryInterface')
            ->shouldReceive('factory')
            ->andReturn($command)
            ->mock();

        $client->setCommandFactory($commandFactory);

        $result = $client->getCommand('test');
        $this->assertInstanceOf('Desk\\Command\\RequestSerializer', $result->getRequestSerializer());
    }
}
