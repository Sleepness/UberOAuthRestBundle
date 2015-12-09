<?php

namespace Sleepness\UberOAuthRestBundle\Provider;

use Sleepness\UberOAuthRestBundle\Exception\BadRequestException;
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
    protected function doRequest($url, $method, array $options = [])
    {
        try {
            $response = $this->client->request(
                strtoupper($method),
                $url,
                $options
            );
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                throw new BadRequestException(
                    'Error while sending request',
                    $this->credentials['provider_name'],
                    $e->getCode(),
                    $e
                );
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
