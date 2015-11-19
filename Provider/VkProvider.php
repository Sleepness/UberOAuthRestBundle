<?php

namespace Uber\OAuthRestBundle\Provider;

use Uber\OAuthRestBundle\Provider\BaseOAuthProvider as BaseProvider;

class VkProvider extends BaseProvider
{
    const ACCESS_TOKEN_URL = 'https://oauth.vk.com/access_token';
    const INFOS_URL = 'https://api.vk.com/method/users.get';

    public function getUserInformation($accessToken)
    {
        $parameters = array(
            'access_token' => $accessToken->access_token,
        );

        $url = $this->normalizeUrl(self::INFOS_URL, $parameters);

        $response = $this->doRequest($url, [], 'GET');

        if (isset($accessToken->email)) {
            $response['response'][0]['email'] = $accessToken->email;
        }

        return $response;
    }

    /**
     * @param $code
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getAccessToken($code)
    {
        $parameters = [
            'code' => $code,
            'grant_type' => 'authorization_code',
            'client_id' => $this->credentials['client_id'],
            'client_secret' => $this->credentials['client_secret'],
            'redirect_uri' => $this->credentials['redirect_uri'],
        ];

        $response = $this->doRequest($this->normalizeUrl(self::ACCESS_TOKEN_URL, $parameters), $parameters, [], 'GET');

        return $response;
    }

    public function getUser($code)
    {
        $accessToken = $this->getAccessToken($code);
        $userInformation = $this->getUserInformation($accessToken);

        return json_encode($userInformation);
    }
}
