<?php

namespace Desk\Model;

use Guzzle\Http\Message\Response;

interface FromResponse
{

    /**
     * Creates an instance of this model from a Guzzle Response object
     *
     * @param Guzzle\Http\Message\Response $response
     *
     * @return Desk\Model\FromResponse
     */
    public static function fromResponse(Response $response);
}
