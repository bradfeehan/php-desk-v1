<?php

use Desk\Testing\UnitTestCase;
use Guzzle\Service\Builder\ServiceBuilder;

// report on absolutely any PHP error/warning/notice/etc.
error_reporting(-1);

$ds = DIRECTORY_SEPARATOR;

// Ensure that composer has installed all dependencies
if (!file_exists(dirname(__DIR__) . $ds . 'composer.lock')) {
    die(
        "Dependencies must be installed using composer:\n\n" .
        "composer.phar install --dev\n\n" .
        "See https://github.com/composer/composer/blob/master/README.md " .
        "for help with installing composer\n"
    );
}

// Include the composer autoloader
require_once dirname(__DIR__) . "{$ds}vendor{$ds}autoload.php";

// Configure Guzzle service builder
if (isset($_SERVER['DESK_TEST_CONFIG'])) {
    $path = $_SERVER['DESK_TEST_CONFIG'];
} else {
    $path = __DIR__ . '/service/mock.json';
}

UnitTestCase::setServiceBuilder(ServiceBuilder::factory($path));
UnitTestCase::setTestsBasePath(__DIR__);
UnitTestCase::setMockBasePath(__DIR__ . '/mock');
