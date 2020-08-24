<?php

/**
 * @file
 * Authentication with Azure reset API to obtain oAuth2 token.
 */

namespace ItkDev\AzureKeyVault\Authorisation;

use GuzzleHttp\Client;
use Itkdev\Azurekeyvault\Exception\TokenException;
use Itkdev\Azurekeyvault\Token;

/**
 * Class Token.
 */
class VaultToken
{
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
    public static function getToken($tenantId, $clientId, $clientSecret): Token
    {
        $guzzle = new Client();

        try {
            $response = $guzzle->post(
                'https://login.microsoftonline.com/'.$tenantId.'/oauth2/token',
                [
                    'form_params' => [
                        'client_id' => $clientId,
                        'client_secret' => $clientSecret,
                        'resource' => 'https://vault.azure.net',
                        'grant_type' => 'client_credentials',
                    ],
                ]
            )->getBody()->getContents();
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents(), true);
            throw new TokenException($error['error_description'], $e->getResponse()->getStatusCode(), null, $error['error_uri']);
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            throw new TokenException($e->getMessage(), $e->getCode());
        }

        $data = json_decode($response, true);

        return new Token($data['access_token'], $data['expires_in'], $data['expires_on'], $data['not_before'], $data['resource']);
    }
}
