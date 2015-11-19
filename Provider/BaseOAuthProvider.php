<?php

namespace Uber\OAuthRestBundle\Provider;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

abstract class BaseOAuthProvider implements OAuthProviderInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $credentials;

    /**
     * BaseOAuthProvider constructor.
     *
     * @param $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * @param array $credentials
     */
    public function setCredentials(array $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * @param $url
     * @param array $parameters
     * @param array $headers
     * @param null  $method
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    protected function getTokenResponse($url, array $parameters = [], $headers = array(), $method = null)
    {
        $methodToUse = $method ? $method : 'GET';

        return $this->doRequest($url, http_build_query($parameters, '', '&'), $headers, $methodToUse);
    }

    /**
     * @param $url
     * @param null $content
     * @param $headers
     * @param $method
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    protected function doRequest($url, $content = null, $headers, $method)
    {
        if (is_string($content)) {
            $contentLength = strlen($content);
        } elseif (is_array($content)) {
            $contentLength = strlen(implode('', $content));
        } else {
            $contentLength = 0;
        }

        $headers = array_merge(['Content-Length: '.$contentLength], $headers);

        try {
            $response = $this->client->request(strtoupper($method), $url, $headers);
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                return json_decode($e->getResponse()->getBody()->getContents());
            }
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $url
     * @param array $parameters
     *
     * @return string
     */
    protected function normalizeUrl($url, array $parameters = array())
    {
        $normalizedUrl = $url;
        if (!empty($parameters)) {
            $normalizedUrl .= (false !== strpos($url, '?') ? '&' : '?').http_build_query($parameters, '', '&');
        }

        return $normalizedUrl;
    }
}
