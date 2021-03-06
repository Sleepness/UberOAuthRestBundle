<?php

namespace Sleepness\UberOAuthRestBundle\Provider;

use Sleepness\UberOAuthRestBundle\Provider\BaseOAuthProvider as BaseProvider;
use Sleepness\UberOAuthRestBundle\Model\User as UserDto;

class VkProvider extends BaseProvider
{
    const ACCESS_TOKEN_URL = 'https://oauth.vk.com/access_token';
    const INFOS_URL = 'https://api.vk.com/method/users.get';
    const PROVIDER_NAME = 'vk';

    /**
     * @param $accessToken
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getUserInformation($accessToken)
    {
        $parameters = array(
            'access_token' => $accessToken->access_token,
        );

        $url = $this->normalizeUrl(self::INFOS_URL, $parameters);

        $response = $this->doRequest($url, self::GET);

        if (isset($accessToken->email)) {
            $response->response[0]->email = $accessToken->email;
        }

        return $response->response[0];
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

        $response = $this->doRequest($this->normalizeUrl(self::ACCESS_TOKEN_URL, $parameters), self::GET, $parameters);

        return $response;
    }

    /**
     * @param $code
     *
     * @return UserDto
     */
    public function getUser($code)
    {
        $accessToken = $this->getAccessToken($code);
        $userInformation = $this->getUserInformation($accessToken);

        $user = new UserDto();
        $user->socialId = $userInformation->uid;
        $user->email = $userInformation->email ?: null;
        $user->firstName = $userInformation->first_name ?: null;
        $user->lastName = $userInformation->last_name ?: null;

        return $user;
    }
}
