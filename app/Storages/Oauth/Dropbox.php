<?php namespace Nimbus\Storages\Oauth;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;

class Dropbox extends AbstractProvider {

    public function urlAuthorize()
    {
        return 'https://www.dropbox.com/1/oauth2/authorize';
    }

    public function urlAccessToken()
    {
        return 'https://api.dropbox.com/1/oauth2/token';
    }

    public function urlUserDetails(AccessToken $token)
    {
        return 'https://api.dropbox.com/1/account/info?access_token='.$token;
    }

    public function userDetails($response, AccessToken $token)
    {
        return $response;
    }


    /**
     * Copied from parent class so that I can comment out the 'approval_prompt' variable -
     * breaks Dropbox overwise
     * @param array $options
     * @return string
     */
    public function getAuthorizationUrl($options = [])
    {
        $this->state = isset($options['state']) ? $options['state'] : md5(uniqid(rand(), true));

        $params = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'state' => $this->state,
            'scope' => is_array($this->scopes) ? implode($this->scopeSeparator, $this->scopes) : $this->scopes,
            'response_type' => isset($options['response_type']) ? $options['response_type'] : 'code',
            //'approval_prompt' => 'auto',
        ];

        return $this->urlAuthorize().'?'.$this->httpBuildQuery($params, '', '&');
    }


} 