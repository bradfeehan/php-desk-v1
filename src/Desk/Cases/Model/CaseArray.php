<?php

namespace Desk\Cases\Model;

use Desk\Model\FromResponse;
use Desk\Model\ModelFactory;
use Guzzle\Http\Message\Response;
use UnexpectedValueException;

class CaseArray implements FromResponse
{

    /**
     * Creates an array of CaseModels from a Guzzle response
     *
     * @param Guzzle\Http\Message\Response $response Guzzle Response
     *
     * @return array An array of Desk\Case\Model\CaseModel objects
     */
    public static function fromResponse(Response $response)
    {
        $content = $response->json();

        // ensure the results element exists
        if (!isset($content['results'])) {
            $message = "Invalid response format from Desk API. ";
            $message .= "Full response:\n{$response->getBody()}";
            throw new UnexpectedValueException($message);
        }

        $cases = array();
        foreach ((array) $content['results'] as $result) {
            $cases[] = ModelFactory::getInstance()
                ->fromData('Desk\\Cases\\Model\\CaseModel', $result['case']);
        }

        return $cases;
    }
}
