<?php

namespace Desk\Testing\MockModel;

use Desk\Model\FromResponse;
use Guzzle\Http\Message\Response;

class ResponseModel implements FromResponse
{

    public static function fromResponse(Response $response)
    {
        return new static();
    }
}
