<?php

namespace Itkdev\Azurekeyvault\Keyvault;

use GuzzleHttp\Client;

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

            return $this->setOutput(
                $result->getStatusCode(),
                $result->getReasonPhrase(),
                json_decode($result->getBody()->getContents(), true)
            );
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return $this->setOutput(
                $e->getResponse()->getStatusCode(),
                array_shift(json_decode($e->getResponse()->getBody()->getContents(), true))
            );
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return $this->setOutput(
                500,
                $e->getHandlerContext()['error']
            );
        }
    }

    private function setOutput($code, $message, $data = null)
    {
        return [
            'code' => $code,
            'responseMessage' => $message,
            'data' => $data
        ];
    }
}