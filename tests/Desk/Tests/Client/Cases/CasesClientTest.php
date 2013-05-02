<?php

namespace Desk\Tests\Client\Cases;

use Desk\Client\Cases\CasesClient;

class CasesClientTest extends \Desk\Testing\UnitTestCase
{

    /**
     * @covers Desk\Client\Cases\CasesClient::factory
     * @covers Desk\Client\Cases\CasesClient::addServiceDescription
     * @covers Desk\Client\Cases\CasesClient::addOAuthPlugin
     */
    public function testFactory()
    {
        $client = $this->getServiceBuilder()->get('mock.cases');
        $this->assertInstanceOf('Desk\\Client\\Cases\\CasesClient', $client);
    }

    /**
     * @covers Desk\Client\Cases\CasesClient::getServiceDescriptionFilename
     * @covers Desk\Client\Cases\CasesClient::getChildClassDirectory
     */
    public function testGetServiceDescriptionFilename()
    {
        $filename = CasesClient::getServiceDescriptionFilename();
        $this->assertStringEndsWith('/src/Desk/Client/Cases/client.json', $filename);
    }

    /**
     * @covers Desk\Client\Cases\CasesClient::getCaseStatus
     * @dataProvider dataGetCaseStatusValid
     */
    public function testGetCaseStatusValid($status, $type, $expected)
    {
        $result = CasesClient::getCaseStatus($status, $type);
        $this->assertSame($expected, $result);
    }

    public function dataGetCaseStatusValid()
    {
        return array(
            array(10, CasesClient::CASE_STATUS_TYPE_NAME, 'new'),
            array(30, CasesClient::CASE_STATUS_TYPE_NAME, 'open'),
            array('pending', CasesClient::CASE_STATUS_TYPE_ID, 50),
            array('resolved', CasesClient::CASE_STATUS_TYPE_ID, 70),
        );
    }

    /**
     * @covers Desk\Client\Cases\CasesClient::getCaseStatus
     * @dataProvider dataGetCaseStatusInvalid
     * @expectedException InvalidArgumentException
     */
    public function testGetCaseStatusInvalid($status, $type)
    {
        CasesClient::getCaseStatus($status, $type);
    }

    public function dataGetCaseStatusInvalid()
    {
        return array(
            array('opne', CasesClient::CASE_STATUS_TYPE_ID), // typo
            array(20, CasesClient::CASE_STATUS_TYPE_NAME), // invalid
            array(10, CasesClient::CASE_STATUS_TYPE_ID), // wrong type
            array(10, 'foobar'), // wrong type
        );
    }
}
