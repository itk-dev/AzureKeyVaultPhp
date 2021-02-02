<?php

/**
 * @file
 * Authentication with Azure reset API to obtain oAuth2 token.
 */

namespace ItkDev\AzureKeyVault\Authorisation;

use ItkDev\AzureKeyVault\Exception\TokenException;
use ItkDev\AzureKeyVault\Token;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

/**
 * Class Token.
 */
class VaultToken
{
    private $httpClient;
    private $requestFactory;

    /**
     * VaultToken constructor.
     *
     * @param ClientInterface $httpClient
     * @param RequestFactoryInterface $requestFactory
     */
    public function __construct(ClientInterface $httpClient, RequestFactoryInterface $requestFactory)
    {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
    }

    /**
     * Get oAuth token.
     *
     * @param $tenantId
     *   Azure tenant id
     * @param $clientId
     *   Client id (Azure application id)
     * @param $clientSecret
     *   Client secret
     *
     * @return token
     *   Token object with the access token and expire information
     *
     * @throws tokenException
     *   Throw exception if error is returned
     */
    public function getToken($tenantId, $clientId, $clientSecret): Token
    {
        $request = $this->requestFactory->createRequest(
            'POST',
            'https://login.microsoftonline.com/'.$tenantId.'/oauth2/token'
        );

        $params = [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'resource' => 'https://vault.azure.net',
            'grant_type' => 'client_credentials',
        ];

        $request->getBody()->write(http_build_query($params, '', '&'));

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new TokenException($e->getMessage(), $e->getCode());
        }

        $data = json_decode($response->getBody()->getContents(), true);

        return new Token(
            $data['access_token'],
            $data['expires_in'],
            $data['expires_on'],
            $data['not_before'],
            $data['resource']
        );
    }
}
