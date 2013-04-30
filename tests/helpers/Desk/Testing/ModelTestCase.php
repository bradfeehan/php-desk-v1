<?php

namespace Desk\Testing;

abstract class ModelTestCase extends UnitTestCase
{

    /**
     * No "covers" annotation here, so this will cover anything it
     * touches. Unfortunately there's no way to cover a class and any
     * implementations overridden in child classes. If there was, we
     * could use that on Desk\AbstractModel::getResponseKeyMap and all
     * its child classes.
     */
    public function testGetResponseKeyMap()
    {
        $map = $this->model()->getResponseKeyMap();
        $this->assertInternalType('array', $map);
    }

    /**
     * Gets an instance of the model being tested
     *
     * @return Desk\AbstractModel
     */
    protected function model()
    {
        $modelName = $this->getModelName();
        return new $modelName;
    }

    /**
     * The class name of the model being tested
     *
     * Used by self::model() to know which class to construct.
     *
     * @var string
     */
    abstract protected function getModelName();
}
