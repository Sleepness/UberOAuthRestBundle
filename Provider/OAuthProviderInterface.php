<?php

namespace Uber\OAuthRestBundle\Provider;

//use Guzzle\Http\Client;
//use Guzzle\Http\Exception\ClientErrorResponseException;
//use Guzzle\Http\Message\RequestInterface;

interface OAuthProviderInterface
{
    public function setCredentials(array $credentials);

//    {
//        $this->credentials = $credentials;
//    }
//
//    protected function getTokenResponse($url, array $parameters = [], $headers = array(), $method = null)
//    {
//        $methodToUse = $method ? $method : RequestInterface::GET;
//
//        return $this->doRequest($url, http_build_query($parameters, '', '&'), $headers, strtolower($methodToUse));
//    }
//
//    protected function doRequest($url, $content = null, $headers, $method)
//    {
//        if (is_string($content)) {
//            $contentLength = strlen($content);
//        } elseif (is_array($content)) {
//            $contentLength = strlen(implode('', $content));
//        } else {
//            $contentLength = 0;
//        }
//
//        $headers = array_merge(['Content-Length: '.$contentLength], $headers);
//
//        try {
//            $response = $this->$method($url, $headers, $content);
//        } catch (ClientErrorResponseException $e) {
//            $error = json_decode($e->getResponse()->getBody(true));
//            throw new \Exception($error->error_description);
//        }
//
//        return $response;
//    }
//
//    protected function get($url, $headers, $content)
//    {
//        return $this->client->get($url.'?'.$content, $headers)->send();
//    }
//
//    protected function post($url, $headers, $content)
//    {
//        return $this->client->post($url, $headers, $content)->send();
//    }
//
//    protected function normalizeUrl($url, array $parameters = array())
//    {
//        $normalizedUrl = $url;
//        if (!empty($parameters)) {
//            $normalizedUrl .= (false !== strpos($url, '?') ? '&' : '?').http_build_query($parameters, '', '&');
//        }
//
//        return $normalizedUrl;
//    }
}
