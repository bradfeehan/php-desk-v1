<?php

namespace Desk\Tests;

use Desk\AbstractModel;
use Desk\ModelFactory;

class AbstractModelTest extends \Desk\Testing\UnitTestCase
{

    /**
     * Resets the singleton instances for all models
     */
    public function tearDown()
    {
        AbstractModel::setInstance();
        ModelFactory::setInstance();
    }

    /**
     * @covers Desk\AbstractModel::instance
     */
    public function testInstance()
    {
        // Make sure subsequent calls are the same singleton
        $modelName = get_class($this->model());
        $this->assertInstanceOf($modelName, $modelName::instance());
        $this->assertSame($modelName::instance(), $modelName::instance());

        // Different objects should get independent singletons
        $model2Name = get_class($this->model());
        $this->assertNotSame($modelName::instance(), $model2Name::instance());
    }

    /**
     * @covers Desk\AbstractModel::setInstance
     */
    public function testSetInstance()
    {
        $model = $this->model();
        $modelName = get_class($model);

        $modelName::setInstance($model);
        $this->assertSame($model, $modelName::instance());
    }

    /**
     * @covers Desk\AbstractModel::fromCommand
     */
    public function testFromCommand()
    {
        $modelName = get_class($this->model());
        $command = $this->createMockCommand();

        $factory = \Mockery::mock('Desk\\ModelFactory[factory]')
            ->shouldReceive('factory')
                ->with($modelName, $command)
                ->andReturn('factoryResult')
            ->shouldReceive('factory')->never()
            ->mock();

        ModelFactory::setInstance($factory);
        $model = $modelName::fromCommand($command);

        $this->assertSame('factoryResult', $model);
    }

    /**
     * @covers Desk\AbstractModel::factory
     */
    public function testFactory()
    {
        $model = $this->model();
        $result = $model->factory(null);
        $this->assertInstanceOf(get_class($model), $model->factory(null));
    }

    private function model()
    {
        return $this->createAbstractMock('Desk\\AbstractModel');
    }
}
