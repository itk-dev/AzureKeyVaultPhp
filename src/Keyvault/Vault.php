<?php

namespace Itkdev\Azurekeyvault\Keyvault;

use GuzzleHttp\Client;
use Itkdev\Azurekeyvault\Exception\CertificateException;

abstract class Vault
{
    private $accessToken;
    private $keyVault;

    public function __construct($vaultName, $accessToken)
    {
        $this->keyVault = "https://".$vaultName.".vault.azure.net/";
        $this->accessToken = $accessToken;
    }

    protected function requestApi($method, $apiCall, $json = null)
    {
        $client = new Client(
            [
                'base_uri'    => $this->keyVault,
                'timeout'     => 2.0
            ]
        );

        try {
            $result = $client->request(
                $method,
                $apiCall,
                [
                    'headers' => [
                        'User-Agent'    => 'browser/1.0',
                        'Accept'        => 'application/json',
                        'Content-Type'  => 'application/json',
                        'Authorization' => "Bearer " . $this->accessToken
                    ],
                    'json' => $json
                ]
            );

            return $this->output(
                $result->getStatusCode(),
                $result->getReasonPhrase(),
                json_decode($result->getBody()->getContents(), true)
            );
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents(), true);
            throw new CertificateException($error['message'], $e->getResponse()->getStatusCode());
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            throw new CertificateException($e->getMessage(), 500);
        }
    }

    private function output($code, $message, $data = null)
    {
        return [
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];
    }
}