<?php

namespace Sleepness\UberOAuthRestBundle\Provider;

use Sleepness\UberOAuthRestBundle\Provider\BaseOAuthProvider as BaseProvider;
use Sleepness\UberOAuthRestBundle\Model\User;

class GooglePlusProvider extends BaseProvider
{
    const ACCESS_TOKEN_URL = 'https://accounts.google.com/o/oauth2/token';
    const INFOS_URL = 'https://www.googleapis.com/oauth2/v1/userinfo';
    const PROVIDER_NAME = 'gp';
    const SCOPE = 'https://www.googleapis.com/auth/userinfo.email';

    /**
     * @param $accessToken
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getUserInformation($accessToken)
    {
        $parameters = array(
            'access_token' => $accessToken->access_token,
            'scope' => self::SCOPE
        );

        $url = $this->normalizeUrl(self::INFOS_URL, $parameters);

        $response = $this->doRequest($url, self::GET);

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
            'client_id' => $this->credentials['client_id'],
            'client_secret' => $this->credentials['client_secret'],
            'redirect_uri' => $this->credentials['redirect_uri'],
            'grant_type' => 'authorization_code'
        ];

        $content = http_build_query($parameters, '', '&');

        $response = $this->doRequest(self::ACCESS_TOKEN_URL, self::POST, $content, ['body' => $content]);

        return $response;
    }

    /**
     * @param $code
     *
     * @return User
     */
    public function getUser($code)
    {
        $accessToken = $this->getAccessToken($code);
        var_dump($accessToken);
        $userInformation = $this->getUserInformation($accessToken);

        $user = new User();
        $user->socialId = $userInformation->id;
        $user->email = $userInformation->email;
        $user->firstName = $userInformation->first_name;
        $user->lastName = $userInformation->last_name;

        return $user;
    }
}
