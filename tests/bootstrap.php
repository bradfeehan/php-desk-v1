<?php

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
