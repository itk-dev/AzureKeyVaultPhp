<?php

/**
 * @file
 * Abstract class to handle request to Azure key vault.
 */

namespace ItkDev\AzureKeyVault\KeyVault;

use ItkDev\AzureKeyVault\Exception\VaultException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

/**
 * Class Vault.
 */
abstract class AbstractVault
{
    private $accessToken;
    private $keyVault;
    private $httpClient;
    private $requestFactory;

    /**
     * Vault constructor.
     *
     * @param ClientInterface $httpClient     PSR-18 compatible client for making http requests
     * @param RequestFactoryInterface $requestFactory PSR-17 compatible request factory for making PSR-7 requests
     * @param string $vaultName      Name of the vault
     * @param string $accessToken    oAuth2 access token for the vault
     */
    public function __construct(ClientInterface $httpClient, RequestFactoryInterface $requestFactory, string $vaultName, string $accessToken)
    {
        $this->keyVault = 'https://'.$vaultName.'.vault.azure.net/';
        $this->accessToken = $accessToken;
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
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
     * @throws VaultException
     */
    protected function requestApi($method, $apiCall, array $json)
    {
        $uri = $this->keyVault.$apiCall;

        $request = $this->requestFactory->createRequest($method, $uri)
            ->withHeader('User-Agent', 'browser/1.0')
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Authorization', 'Bearer '.$this->accessToken);

        $request->getBody()->write(json_encode($json));

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new VaultException($e->getMessage(), $e->getCode());
        }

        return $this->output(
            $response->getStatusCode(),
            $response->getReasonPhrase(),
            json_decode($response->getBody()->getContents(), true)
        );
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
