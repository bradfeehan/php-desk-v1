<?php

namespace Desk;

abstract class AbstractModelArray extends AbstractModel
{

    /**
     * {@inheritdoc}
     */
    public function factory($data)
    {
        $modelName = $this->getModelName();
        $resultKey = $this->getResultKey();

        // Build up an array of Model objects from the results
        $cases = array();

        foreach ((array) $data as $result) {
            $cases[] = $modelName::instance()->factory($result[$resultKey]);
        }

        return $cases;
    }

    /**
     * The class of the model in this ModelArray
     *
     * @return string
     */
    abstract public function getModelName();

    /**
     * The key in the result containing the model data
     *
     * @return string
     */
    abstract public function getResultKey();
}
