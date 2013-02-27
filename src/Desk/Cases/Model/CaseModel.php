<?php

namespace Desk\Cases\Model;

use Desk\Model\FromData;
use Guzzle\Common\Collection;

class CaseModel extends Collection implements FromData
{

    public static function fromData($data)
    {
        return new static((array) $data);
    }
}
