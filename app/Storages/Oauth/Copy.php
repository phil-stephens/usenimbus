<?php namespace Nimbus\Storages\Oauth;

use League\OAuth1\Client\Credentials\TokenCredentials;
use League\OAuth1\Client\Server\Server;

class Copy extends Server
{

    /**
     * {@inheritDoc}
     */
    public function urlTemporaryCredentials()
    {
        return 'https://api.copy.com/oauth/request';
    }

    /**
     * {@inheritDoc}
     */
    public function urlAuthorization()
    {
        return 'https://www.copy.com/applications/authorize';
    }

    /**
     * {@inheritDoc}
     */
    public function urlTokenCredentials()
    {
        return 'https://api.copy.com/oauth/access';
    }

    /**
     * {@inheritDoc}
     */
    public function urlUserDetails()
    {
        return 'https://api.copy.com/rest/user';
    }

    /**
     * {@inheritDoc}
     */
    public function userDetails($data, TokenCredentials $tokenCredentials)
    {
        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function userUid($data, TokenCredentials $tokenCredentials)
    {
        return;
    }

    /**
     * {@inheritDoc}
     */
    public function userEmail($data, TokenCredentials $tokenCredentials)
    {
        return;
    }

    /**
     * {@inheritDoc}
     */
    public function userScreenName($data, TokenCredentials $tokenCredentials)
    {
        return;
    }

    protected function fetchUserDetails(TokenCredentials $tokenCredentials, $force = true)
    {
        if ( ! $this->cachedUserDetailsResponse || $force == true) {
            $url = $this->urlUserDetails();

            $client = $this->createHttpClient();

            try {
                $response = $client->get($url, array(
                    'Authorization' => $this->protocolHeader('GET', $url, $tokenCredentials),
                    'X-Api-Version' => 1
                ))->send();
            } catch (BadResponseException $e) {
                $response = $e->getResponse();
                $body = $response->getBody();
                $statusCode = $response->getStatusCode();

                throw new \Exception("Received error [$body] with status code [$statusCode] when retrieving token credentials.");
            }

            switch ($this->responseType) {
                case 'json':
                    $this->cachedUserDetailsResponse = $response->json();
                    break;

                case 'xml':
                    $this->cachedUserDetailsResponse = $response->xml();
                    break;

                case 'string':
                    parse_str($response->getBody(), $this->cachedUserDetailsResponse);
                    break;

                default:
                    throw new \InvalidArgumentException("Invalid response type [{$this->responseType}].");
            }
        }

        return $this->cachedUserDetailsResponse;
    }

}
