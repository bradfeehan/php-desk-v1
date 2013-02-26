<?php

namespace Desk\Testing;

use Desk\ResponseClass;
use Guzzle\Http\Message\Response;

/**
 * Class for mocking ResponseClass interface
 */
class MockResponseClass implements ResponseClass
{

    public static function fromResponse(Response $response)
    {
        return new static();
    }
}
