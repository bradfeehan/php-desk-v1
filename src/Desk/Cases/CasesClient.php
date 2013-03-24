<?php

namespace Desk\Cases;

use Desk\AbstractClient;
use InvalidArgumentException;

/**
 * Client for Desk case API
 */
class CasesClient extends AbstractClient
{

    /**
     * Represents a case status' ID
     *
     * @var string
     */
    const CASE_STATUS_TYPE_ID = 'id';

    /**
     * Represents a case status' descriptive name
     *
     * @var string
     */
    const CASE_STATUS_TYPE_NAME = 'name';

    /**
     * Maps case status IDs to names
     *
     * @var array
     */
    private static $caseStatusIdToName = array(
        10         => 'new',
        30         => 'open',
        50         => 'pending',
        70         => 'resolved',
        90         => 'closed',
    );

    /**
     * Maps case status names to IDs
     *
     * @var array
     */
    private static $caseStatusNameToId = array(
        'new'      => 10,
        'open'     => 30,
        'pending'  => 50,
        'resolved' => 70,
        'closed'   => 90,
    );

    /**
     * Converts between representations of a case's status
     *
     * This function converts a case status between its numerical ID
     * (used internally by Desk.com) and the descriptive name (also
     * used by Desk.com at times).
     *
     * @param mixed  $status The status to convert
     * @param string $type   The type of status to convert to (either
     *                       CASE_STATUS_TYPE_ID or CASE_STATUS_TYPE_NAME)
     *
     * @return mixed A representation of the status in $status; an
     *               integer if $type === CASE_STATUS_TYPE_ID, or a
     *               string if $type === CASE_STATUS_TYPE_NAME
     */
    public static function getCaseStatus($status, $type = self::CASE_STATUS_TYPE_ID)
    {
        switch ($type) {
            case self::CASE_STATUS_TYPE_ID:
                if (isset(self::$caseStatusNameToId[$status])) {
                    return self::$caseStatusNameToId[$status];
                }
                break;
            case self::CASE_STATUS_TYPE_NAME:
                if (isset(self::$caseStatusIdToName[$status])) {
                    return self::$caseStatusIdToName[$status];
                }
                break;
            default:
                throw new InvalidArgumentException("Invalid case status type '$type'");
        }

        throw new InvalidArgumentException("Invalid case status $type '$status'");
    }
}
