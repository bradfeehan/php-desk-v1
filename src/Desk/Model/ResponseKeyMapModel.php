<?php

namespace Desk\Model;

use Desk\Exception\UnexpectedValueException;

abstract class ResponseKeyMapModel extends AbstractModel
{

    /**
     * {@inheritdoc}
     */
    public function getResponseKeyFor($commandName)
    {
        // Get the response key map
        $map = $this->getResponseKeyMap();

        // Ensure the command name exists in the response key map
        if (!is_array($map) || !array_key_exists($commandName, $map)) {
            throw new UnexpectedValueException(
                "Tried to create model '" . get_called_class() . "' " .
                "from command '$commandName', but this command name " .
                "doesn't exist in the response key map for this model"
            );
        }

        return $map[$commandName];
    }

    /**
     * Gets an array mapping command names to keys in the response
     *
     * This array maps names of Guzzle commands to the key in the
     * corresponding response where the model data is found for that
     * command.
     *
     * @return array
     */
    abstract public function getResponseKeyMap();
}
