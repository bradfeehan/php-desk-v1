<?php

namespace Desk\Model;

/**
 * Returns a boolean indicating the value of "success" in the response
 *
 * Based on PrimitiveModel, which is a pseudo-model which doesn't
 * return an instance of itself, but rather the exact value specified
 * by getResponseKeyFor() in the response (as a primitive).
 */
class SuccessModel extends PrimitiveModel
{

    /**
     * {@inheritdoc}
     */
    public function getResponseKeyFor($commandName)
    {
        return 'success';
    }
}
