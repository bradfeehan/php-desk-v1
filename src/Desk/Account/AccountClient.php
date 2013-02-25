<?php

namespace Desk\Account;

use Desk\AbstractClient;

/**
 * Client for Desk account API
 */
class AccountClient extends AbstractClient
{

    /**
     * {@inheritdoc}
     */
    protected static function getDirectory()
    {
        return __DIR__;
    }
}
