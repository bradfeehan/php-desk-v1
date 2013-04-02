<?php

namespace Desk\Cases\Model;

use Desk\AbstractModel;
use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Command\ResponseClassInterface;
use UnexpectedValueException;

class CaseArray extends AbstractModel implements ResponseClassInterface
{

    /**
     * {@inheritdoc}
     */
    public static function fromCommand(OperationCommand $command)
    {
        $response = $command->getResponse();

        // Make sure "results" key exists
        $casesData = static::getResponseKey($response, 'results');

        // Build up an array of CaseModel objects from the results
        $cases = array();

        foreach ((array) $casesData as $result) {
            $cases[] = new CaseModel($result['case']);
        }

        return $cases;
    }
}
