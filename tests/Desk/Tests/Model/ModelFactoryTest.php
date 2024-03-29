<?php

namespace Desk\Tests\Model;

use Desk\Model\ModelFactory;

class ModelFactoryTest extends \Desk\Testing\UnitTestCase
{

    /**
     * Ensure the instance is reset
     */
    public function setup()
    {
        ModelFactory::setInstance();
    }

    /**
     * @covers Desk\Model\ModelFactory::instance
     */
    public function testInstance()
    {
        $factory = ModelFactory::instance();
        $this->assertInstanceOf('Desk\\Model\\ModelFactory', $factory);
    }

    /**
     * @covers Desk\Model\ModelFactory::setInstance
     */
    public function testSetInstance()
    {
        $instance = \Mockery::mock('Desk\\Model\\ModelFactory');
        ModelFactory::setInstance($instance);

        $this->assertSame($instance, ModelFactory::instance());
    }

    /**
     * @covers Desk\Model\ModelFactory::factory
     */
    public function testFactory()
    {
        $model = $this->createAbstractMock('Desk\\Model\\AbstractModel');
        $modelName = get_class($model);

        $command = $this->createMockCommand(array(), 'MyCommand');

        $factory = \Mockery::mock('Desk\\Model\\ModelFactory[getResponseKey,getResponseData]')
            ->shouldReceive('getResponseKey')
                ->with($modelName, 'MyCommand')
                ->andReturn('pathtokey')
            ->shouldReceive('getResponseData')
                ->with($command->getResponse(), 'pathtokey')
                ->andReturn(null)
            ->mock();

        $modelName::setInstance($model);

        $model = $factory->factory($modelName, $command);
        $this->assertInstanceOf($modelName, $model);
    }

    /**
     * @covers Desk\Model\ModelFactory::getResponseKey
     */
    public function testGetResponseKey()
    {
        $model = \Mockery::mock('Desk\\Model\\AbstractModel[getResponseKeyFor]')
            ->shouldReceive('getResponseKeyFor')
            ->with('fooCommand')
            ->andReturn('path/to/key')
            ->mock();

        $modelName = get_class($model);
        $modelName::setInstance($model);

        $key = $this->instance()->getResponseKey($modelName, 'fooCommand');

        $this->assertSame('path/to/key', $key);
    }

    /**
     * @covers Desk\Model\ModelFactory::getResponseKey
     * @expectedException Desk\Exception\UnexpectedValueException
     */
    public function testGetResponseKeyThrowsExceptionForInvalidModel()
    {
        $model = \Mockery::mock('stdClass');
        $this->instance()->getResponseKey(get_class($model), 'irrelevant');
    }

    /**
     * Tests valid calls to Desk\Model\ModelFactory::getResponseData()
     *
     * @covers Desk\Model\ModelFactory::getResponseData
     * @dataProvider dataGetResponseDataValid
     */
    public function testGetResponseDataValid($content, $key, $expected)
    {
        $response = $this->createMockResponse($content);
        $actual = $this->instance()->getResponseData($response, $key);
        $this->assertSame($expected, $actual);
    }

    public function dataGetResponseDataValid()
    {
        return array(
            array(array('foo' => 'bar'), 'foo', 'bar'),
            array(array('foo' => array('bar' => 'baz')), 'foo/bar', 'baz'),
            array(array('foo' => array('bar' => array('baz' => 'quux'))), 'foo/bar/baz', 'quux'),
            array(array('foo' => array('bar' => array('baz' => 'quux'))), 'foo/bar', array('baz' => 'quux')),
        );
    }

    /**
     * Tests invalid calls to Desk\Model\ModelFactory::getResponseData()
     *
     * @covers Desk\Model\ModelFactory::getResponseData
     * @dataProvider dataGetResponseDataInvalid
     * @expectedException Desk\Exception\ResponseFormatException
     */
    public function testGetResponseDataInvalid($content, $key)
    {
        $response = $this->createMockResponse($content);
        $this->instance()->getResponseData($response, $key);
    }

    public function dataGetResponseDataInvalid()
    {
        return array(
            array(array('foo' => 'bar'), 'nonexistent_key'),
            array(array('foo' => array('bar' => 'baz')), 'foo/baz'),
        );
    }

    private function instance()
    {
        return new ModelFactory();
    }
}
