<?php

/**
 * @file
 * Abstract class to handle request to Azure key vault.
 */

namespace Itkdev\Azurekeyvault\Keyvault;

use GuzzleHttp\Client;
use Itkdev\Azurekeyvault\Exception\CertificateException;

/**
 * Class Vault.
 */
abstract class Vault
{
    private $accessToken;
    private $keyVault;

    /**
     * Vault constructor.
     *
     * @param string $vaultName
     *   Name of the vault
     * @param string $accessToken
     *   oAuth2 access token for the vault
     */
    public function __construct($vaultName, $accessToken)
    {
        $this->keyVault = 'https://'.$vaultName.'.vault.azure.net/';
        $this->accessToken = $accessToken;
    }

    /**
     * Send request to the Azure vault rest API.
     *
     * @param string $method
     *   HTTP method
     * @param string $apiCall
     *   API endpoint (URI)
     * @param array $json
     *   JSON payload
     *
     * @return array
     *   Data from the rest API. Indexed by 'code', 'message' and 'data'.
     *
     * @throws CertificateException
     */
    protected function requestApi($method, $apiCall, array $json)
    {
        $client = new Client(
            [
                'base_uri' => $this->keyVault,
                'timeout' => 2.0,
            ]
        );

        try {
            $result = $client->request(
                $method,
                $apiCall,
                [
                    'headers' => [
                        'User-Agent' => 'browser/1.0',
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer '.$this->accessToken,
                    ],
                    'json' => $json,
                ]
            );

            return $this->output(
                $result->getStatusCode(),
                $result->getReasonPhrase(),
                json_decode($result->getBody()->getContents(), true)
            );
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents(), true);
            throw new CertificateException($error['error']['message'], $e->getResponse()->getStatusCode());
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            throw new CertificateException($e->getMessage(), 500);
        }
    }

    /**
     * Helper function to return response from the rest API.
     *
     * @param string $code
     *   HTTP status code
     * @param string $message
     *   HTTP Message
     * @param array $data
     *   JSON decoded data from the API
     *
     * @return array
     *   Indexed parsed information form the API
     */
    private function output($code, $message, array $data)
    {
        return [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];
    }
}
