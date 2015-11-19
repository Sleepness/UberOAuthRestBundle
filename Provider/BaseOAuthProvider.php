<?php

namespace Uber\OAuthRestBundle\Provider;

use Uber\OAuthRestBundle\Exception\BadRequestException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

abstract class BaseOAuthProvider implements OAuthProviderInterface
{
    const GET = 'GET';
    const POST = 'POST';

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
     * @param null $content
     * @param $headers
     * @param $method
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    protected function doRequest($url, $method, $content = null, $headers = [])
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
                throw new BadRequestException('Error while sending request', $this->credentials['provider_name'], $e->getCode(), $e);
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
