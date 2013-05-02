<?php

namespace Desk\Testing;

abstract class ModelArrayTestCase extends ModelTestCase
{

    /**
     * No "covers" annotation here, so this will cover anything it
     * touches. Unfortunately there's no way to cover a class and any
     * implementations overridden in child classes. If there was, we
     * could use that on Desk\Model\AbstractModelArray::getModelName
     * and all its child classes.
     */
    public function testGetModelName()
    {
        $modelName = $this->model()->getModelName();
        $this->assertInternalType('string', $modelName);
    }

    /**
     * No "covers" annotation here, so this will cover anything it
     * touches. Unfortunately there's no way to cover a class and any
     * implementations overridden in child classes. If there was, we
     * could use that on Desk\Model\AbstractModelArray::getResultKey
     * and all its child classes.
     */
    public function testGetResultKey()
    {
        $resultKey = $this->model()->getResultKey();
        $this->assertInternalType('string', $resultKey);
    }

    /**
     * @coversNothing
     * @dataProvider dataSystem
     */
    public function testSystem($data, $commandName, $numExpectedModels, $expectedModelClass)
    {
        $modelArrayName = $this->getModelName();
        $command = $this->createMockCommand($data, $commandName);

        $modelArray = $modelArrayName::fromCommand($command);

        $this->assertInternalType('array', $modelArray);
        $this->assertSame((integer) $numExpectedModels, count($modelArray));

        foreach ($modelArray as $model) {
            $this->assertInstanceOf($expectedModelClass, $model);
        }
    }

    /**
     * @coversNothing
     * @dataProvider dataSystemInvalid
     * @expectedException Desk\Exception\UnexpectedValueException
     */
    public function testSystemInvalid($data, $commandName)
    {
        $command = $this->createMockCommand($data, $commandName);
        $modelArrayName = $this->getModelName();
        $modelArrayName::fromCommand($command);
    }

    /**
     * Provides arguments for testSystem()
     *
     * @return array
     */
    abstract public function dataSystem();

    /**
     * Provides arguments for testSystemInvalid
     *
     * @return array
     */
    abstract public function dataSystemInvalid();
}
