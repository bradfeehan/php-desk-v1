<?php

namespace Desk\Testing\MockModel;

use Desk\Model\FromData;

class DataModel implements FromData
{

    public static function fromData($data)
    {
        return new static();
    }
}
