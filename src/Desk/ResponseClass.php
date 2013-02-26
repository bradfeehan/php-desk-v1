<?php

namespace Desk;

use Guzzle\Http\Message\Response;

interface ResponseClass
{

    /**
     * Creates an instance of this class from a Response object
     *
     * @param Guzzle\Http\Message\Response $response
     *
     * @return Desk\ClassResponse
     */
    public static function fromResponse(Response $response);
}
