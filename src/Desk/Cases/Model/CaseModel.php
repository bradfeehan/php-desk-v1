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
        $path = static::getCasePath($command);

        return new static(static::getResponseKey($response, $path));
    }

    public static function getCasePath(OperationCommand $command)
    {
        if ($command->getName() === 'UpdateCase') {
            return 'results/case';
        }

        return 'case';
    }
}
