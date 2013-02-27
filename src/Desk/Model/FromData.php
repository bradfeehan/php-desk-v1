<?php

namespace Desk\Model;

interface FromData
{

    /**
     * Creates an instance of this model from a data array
     *
     * @param array $data
     *
     * @return Desk\Model\FromData
     */
    public static function fromData($data);
}
