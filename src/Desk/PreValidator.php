<?php

namespace Desk;

use Guzzle\Common\Event;
use Guzzle\Common\ToArrayInterface;
use Guzzle\Service\Command\CommandInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PreValidator implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return array(
            'command.before_prepare' => 'castPrimitivesToArrays',
        );
    }

    /**
     * Casts primitives set on parameters that require an array
     *
     * Looks for any parameters that require an array but have a
     * primitive set. For each of these, it wraps the primitive in an
     * array (so $foo becomes array($foo), now satisfying the type
     * requirement).
     *
     * @param Guzzle\Common\Event Event object, containing 'command'
     */
    public function castPrimitivesToArrays(Event $event)
    {
        $command = $event['command'];

        // short-circuit if the command wasn't set or is wrong type
        if (!($command instanceof CommandInterface)) {
            return;
        }

        $operation = $command->getOperation();
        $params = $operation->getParams();

        foreach ((array) $params as $name => $param) {
            if ($param->getType() === 'array') {
                $value = $command->get($name);

                // Treat ToArrayInterface classes effectively as arrays
                if ($value instanceof ToArrayInterface) {
                    $value = $value->toArray();
                }

                // Wrap the value as the only element in an array if
                // it's still not an array
                if (!is_array($value)) {
                    $command->set($name, array($value));
                }
            }
        }
    }
}
