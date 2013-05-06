<?php

namespace Desk\Model;

/**
 * A "fake" model, which just returns the raw model data as a primitive
 */
abstract class PrimitiveModel extends AbstractModel
{

    /**
     * {@inheritdoc}
     *
     * Factory method to create the model from model data
     *
     * Overridden to return the raw model data, rather than creating
     * an object of this class.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function factory($data)
    {
        return $data;
    }
}
