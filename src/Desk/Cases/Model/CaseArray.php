<?php

namespace Desk\Cases\Model;

use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Command\ResponseClassInterface;
use UnexpectedValueException;

class CaseArray implements ResponseClassInterface
{

    /**
     * {@inheritdoc}
     */
    public static function fromCommand(OperationCommand $command)
    {
        $response = $command->getResponse();
        $content = $response->json();

        // ensure the results element exists
        if (!isset($content['results'])) {
            $message = "Invalid response format from Desk API. ";
            $message .= "Full response:\n{$response->getBody()}";
            throw new UnexpectedValueException($message);
        }

        $cases = array();

        foreach ((array) $content['results'] as $result) {
            $cases[] = new CaseModel($result['case']);
        }

        return $cases;
    }
}
