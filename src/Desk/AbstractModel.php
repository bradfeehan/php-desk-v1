<?php

namespace Desk;

use Desk\Exception\ResponseFormatException;
use Guzzle\Common\Collection;
use Guzzle\Http\Message\Response;

abstract class AbstractModel extends Collection
{

    /**
     * Gets a value from a Desk.com API response
     *
     * Interprets a response as JSON, and looks through the resulting
     * structure to retrieve the specified key. An exception of type
     * UnexpectedValueException is thrown if the key is missing.
     *
     * Nested keys can be retrieved using "/", e.g. "foo/bar/baz" will
     * return "quux" if the response JSON is the following:
     *
     * {
     *   "foo": {
     *     "bar": {
     *       "baz": "quux"
     *     }
     *   }
     * }
     *
     * If any of the "foo", "bar", or "baz" keys are missing from the
     * response, an exception will be thrown.
     *
     * @param Desk\Http\Message\Response $response The response to check
     * @param string                     $path     Key path to search
     *
     * @return mixed The value of the $path key in the response
     *
     * @throws Desk\Exception\ResponseFormatException For missing $path
     */
    public static function getResponseKey(Response $response, $path)
    {
        $contents = $response->json();
        $keys = explode('/', $path);

        foreach ($keys as $key) {
            if (!is_array($contents) || !array_key_exists($key, $contents)) {
                throw new ResponseFormatException(
                    "Invalid response format from Desk API " .
                    "(expected '$path' element in response). " .
                    "Full response:\n{$response->getBody()}"
                );
            }

            $contents = $contents[$key];
        }

        return $contents;
    }
}
