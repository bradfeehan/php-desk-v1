<?php

namespace Desk\Tests\Account;

use Desk\Account\AccountClient;

class AccountClientTest extends \Desk\Testing\UnitTestCase
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

    /**
     * @covers Desk\Account\AccountClient::getCommand
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
        $this->assertInstanceOf('Desk\\RequestSerializer', $result->getRequestSerializer());
    }
}
