<?php

namespace ItkDev\AzureKeyVault\KeyVault;

use ItkDev\AzureKeyVault\Exception\VaultException;
use ItkDev\AzureKeyVault\Secret;

/**
 * Class VaultSecret
 */
class VaultSecret extends Vault
{
    /**
     * @param $name
     * @param $secretId
     *
     * @return Secret
     *
     * @throws VaultException
     */
    public function getSecret($name, $secretId): Secret
    {
        $apiCall = 'secrets/'.$name.'/'.$secretId.'?api-version=7.0';
        $response = $this->requestApi('GET', $apiCall, []);

        if (200 == $response['code']) {

            $data = $response['data'];
            return new Secret(
                $data['id'],
                $data['value'],
                $data['managed'],
                $data['attributes']['enabled'],
                $data['attributes']['created'],
                $data['attributes']['updated'],
                $data['attributes']['recoveryLevel']
            );
        }

        return new Secret(
            null,
            null,
            null,
            null,
            null,
            null,
            null
        );
    }
}
