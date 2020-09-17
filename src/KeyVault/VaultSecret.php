<?php

/**
 * @file
 * Handle secrets from the vault.
 */

namespace ItkDev\AzureKeyVault\KeyVault;

use ItkDev\AzureKeyVault\Exception\SecretException;
use ItkDev\AzureKeyVault\Exception\VaultException;
use ItkDev\AzureKeyVault\Secret;

/**
 * Class VaultSecret.
 */
class VaultSecret extends Vault
{
    /**
     * Get secret from the vault.
     *
     * @param string $name
     * @param string $secretId
     *
     * @return Secret
     *
     * @throws SecretException
     */
    public function getSecret(string $name, string $secretId): Secret
    {
        $apiCall = 'secrets/'.$name.'/'.$secretId.'?api-version=7.0';

        try {
            $response = $this->requestApi('GET', $apiCall, []);
        } catch (VaultException $e) {
            throw new SecretException($e->getMessage(), $e->getCode());
        }

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
