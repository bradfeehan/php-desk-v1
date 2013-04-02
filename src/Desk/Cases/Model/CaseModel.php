<?php

namespace Desk\Cases\Model;

use Desk\AbstractModel;
use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Command\ResponseClassInterface;
use UnexpectedValueException;

class CaseModel extends AbstractModel implements ResponseClassInterface
{

    /**
     * {@inheritdoc}
     */
    public static function fromCommand(OperationCommand $command)
    {
        $response = $command->getResponse();
        return new static(static::getResponseKey($response, 'case'));
    }
}
