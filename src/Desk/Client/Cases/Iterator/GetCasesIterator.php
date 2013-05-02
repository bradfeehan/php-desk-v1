<?php

namespace Desk\Client\Cases\Iterator;

use Guzzle\Service\Resource\ResourceIterator;

/**
 * Iterator for the GetCases command
 */
class GetCasesIterator extends ResourceIterator
{

    /**
     * {@inheritdoc}
     */
    protected function sendRequest()
    {
        if ($this->nextToken) {
            $this->command->set('since_id', $this->nextToken);
        }

        $cases = $this->command->execute();

        // Update nextToken, if there are any results
        $this->nextToken = null;
        foreach ($cases as $case) {
            if ($this->nextToken === null || $case['id'] >= $this->nextToken) {
                $this->nextToken = $case['id'] + 1;
            }
        }

        return count($cases) ? $cases : null;
    }
}
