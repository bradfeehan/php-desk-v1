<?php

namespace Desk\Cases;

use Desk\AbstractClient;

/**
 * Client for Desk case API
 */
class CasesClient extends AbstractClient
{

    /**
     * {@inheritdoc}
     */
    protected static function getDirectory()
    {
        return __DIR__;
    }
}
