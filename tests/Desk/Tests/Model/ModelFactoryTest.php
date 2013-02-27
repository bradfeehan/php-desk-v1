<?php

namespace Desk\Tests\Model;

use Desk\Model\FromData;
use Desk\Model\FromResponse;
use Desk\Model\ModelFactory;
use Desk\Testing\MockModel\DataModel;
use Desk\Testing\MockModel\ResponseModel;
use Guzzle\Http\Message\Response;

class ModelFactoryTest extends \Guzzle\Tests\GuzzleTestCase
{

    public function setUp()
    {
        ModelFactory::setInstance(null);
    }

    /**
     * @covers Desk\Model\ModelFactory::getInstance
     */
    public function testGetInstance()
    {
        $factory = ModelFactory::getInstance();
        $this->assertInstanceOf('Desk\\Model\\ModelFactory', $factory);
    }

    /**
     * @covers Desk\Model\ModelFactory::setInstance
     */
    public function testSetInstance()
    {
        $factory = \Mockery::mock('Desk\\Model\\ModelFactory');
        ModelFactory::setInstance($factory);
        $this->assertSame($factory, ModelFactory::getInstance());
    }

    /**
     * @covers Desk\Model\ModelFactory::fromResponse
     */
    public function testFromResponse()
    {
        $response = \Mockery::mock('Guzzle\\Http\\Message\\Response');
        $model = 'Desk\\Testing\\MockModel\\ResponseModel';
        $result = ModelFactory::getInstance()->fromResponse($model, $response);
        $this->assertInstanceOf($model, $result);
    }

    /**
     * @covers Desk\Model\ModelFactory::fromData
     * @covers Desk\Model\ModelFactory::checkInterface
     */
    public function testFromData()
    {
        $data = array();
        $model = 'Desk\\Testing\\MockModel\\DataModel';
        $result = ModelFactory::getInstance()->fromData($model, $data);
        $this->assertInstanceOf($model, $result);
    }

    /**
     * @covers Desk\Model\ModelFactory::checkInterface
     * @expectedException UnexpectedValueException
     */
    public function testCheckInterfaceThrowsExceptionForWrongModel()
    {
        $data = array();
        $model = 'Desk\\Testing\\MockModel\\ResponseModel'; // wrong model
        $result = ModelFactory::getInstance()->fromData($model, $data);
        $this->assertInstanceOf($model, $result);
    }
}
