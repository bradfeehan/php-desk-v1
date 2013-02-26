<?php

namespace Desk;

use Desk\ResponseParser;
use Guzzle\Common\Collection;
use Guzzle\Plugin\Oauth\OauthPlugin;
use Guzzle\Service\Description\ServiceDescription;

/**
 * Abstract base client class for Desk API
 */
abstract class AbstractClient extends \Guzzle\Service\Client
{

    /**
     * Factory method to create a new AccountClient
     *
     * Available configuration options:
     *  - subdomain:   The subdomain of desk.com to use
     *  - api_version: Desk.com API version (optional, defaults to 1)
     *
     * @return Desk\AbstractClient static
     */
    public static function factory($config = array())
    {
        $default = array(
            'api_version' => '1',
            'base_url' => 'https://{subdomain}.desk.com/api/v{api_version}/'
        );

        $required = array(
            'consumer_key',
            'consumer_secret',
            'token',
            'token_secret',
        );

        // Subdomain is required if the base URL is the default (not set), or
        // if it contains {subdomain} somewhere.
        if (!isset($config['base_url']) || strpos($config['base_url'], '{subdomain}') !== false) {
            $required[] = 'subdomain';
        }

        // Construct self, using parent::factory()
        $config = Collection::fromConfig($config, $default, $required);
        $client = parent::factory($config);

        self::addServiceDescription($client);
        self::addOAuthPlugin($client, $config);

        return $client;
    }

    /**
     * Adds the right service description for the client
     *
     * @param Desk\AbstractClient $client The client to add the description to
     *
     * @return Desk\AbstractClient The client with the description added
     */
    private static function addServiceDescription(AbstractClient &$client)
    {
        $file = self::getServiceDescriptionFilename();
        $description = ServiceDescription::factory($file);

        return $client->setDescription($description);
    }

    /**
     * Adds the Guzzle OAuth plugin to a client, to handle authentication
     *
     * @param Desk\AbstractClient      $client The client to add the plugin to
     * @param Guzzle\Common\Collection $config Client configuration, including:
     *  - consumer_key:    OAuth consumer key
     *  - consumer_secret: OAuth consumer secret
     *  - token:           OAuth token
     *  - token_secret:    OAuth token secret
     *
     * @return Desk\AbstractClient The client with the plugin added
     */
    private static function addOAuthPlugin(AbstractClient &$client, Collection $config)
    {
        $oauth = new OauthPlugin(
            array(
                'consumer_key'    => $config->get('consumer_key'),
                'consumer_secret' => $config->get('consumer_secret'),
                'token'           => $config->get('token'),
                'token_secret'    => $config->get('token_secret'),
            )
        );

        return $client->addSubscriber($oauth);
    }

    /**
     * Gets the path to the service description
     *
     * @return string
     */
    public static function getServiceDescriptionFilename()
    {
        return static::getDirectory() . '/client.json';
    }

    /**
     * Returns the directory of the concrete class
     *
     * This should just "return __DIR__;" in descendant classes.
     *
     * @return string
     */
    abstract protected static function getDirectory();

    /*
     * Overridden to use a custom response parser for each command.
     */
    public function getCommand($name, array $args = array())
    {
        return parent::getCommand($name, $args)
            ->setResponseParser(ResponseParser::getInstance());
    }
}
