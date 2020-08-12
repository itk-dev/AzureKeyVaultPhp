<?php

namespace Itkdev\Azurekeyvault\Authorisation;

class Token
{
    public static function getKeyVaultToken(array $azureAppDetails)
    {
        $guzzle = new \GuzzleHttp\Client();

        $token = $guzzle->post(
            "https://login.microsoftonline.com/{$azureAppDetails['appTenantDomainName']}/oauth2/token",
            [
                'form_params' => [
                    'client_id'     => $azureAppDetails['clientId'],
                    'client_secret' => $azureAppDetails['clientSecret'],
                    'resource'      => 'https://vault.azure.net',
                    'grant_type'    => 'client_credentials',
                ]
            ]
        )->getBody()->getContents();

        return json_decode($token, true)['access_token'];
    }
}