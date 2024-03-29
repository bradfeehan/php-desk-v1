<?php

namespace Desk\Tests\Client\Account\Command;

class VerifyCredentialsCommandTest extends \Desk\Testing\UnitTestCase
{

    /**
     * @coversNothing
     * @group network
     */
    public function testNetwork()
    {
        $client = $this->getServiceBuilder()->get('test.account');
        $command = $client->getCommand('VerifyCredentials');

        $result = $client->execute($command);
        $message = 'No user object returned for VerifyCredentials call';
        $this->assertArrayHasKey('user', $result, $message);
    }
}
