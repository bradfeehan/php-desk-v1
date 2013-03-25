<?php

namespace Desk\Cases\Model;

use Guzzle\Common\Collection;
use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Command\ResponseClassInterface;
use UnexpectedValueException;

class CaseModel extends Collection implements ResponseClassInterface
{

    /**
     * {@inheritdoc}
     */
    public static function fromCommand(OperationCommand $command)
    {
        $response = $command->getResponse();
        $content = $response->json();

        // ensure the results element exists
        if (!isset($content['case'])) {
            $message = "Invalid response format from Desk API. ";
            $message .= "Full response:\n{$response->getBody()}";
            throw new UnexpectedValueException($message);
        }

        return new self($content['case']);
    }
}
