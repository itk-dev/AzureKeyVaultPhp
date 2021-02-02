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
class VaultSecret extends AbstractVault
{
    /**
     * Get secret from the vault.
     *
     * @param string $name    the name of the secret in the vault
     * @param string $version the version of the secret to get from the vault
     *
     * @return Secret
     *
     * @throws SecretException
     */
    public function getSecret(string $name, string $version): Secret
    {
        $apiCall = 'secrets/'.$name.'/'.$version.'?api-version=7.0';

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
