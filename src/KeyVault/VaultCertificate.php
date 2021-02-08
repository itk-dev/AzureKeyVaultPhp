<?php

/**
 * @file
 * Handle certificates from the vault.
 */

namespace ItkDev\AzureKeyVault\KeyVault;

use ItkDev\AzureKeyVault\Certificate;
use ItkDev\AzureKeyVault\Exception\CertificateException;
use ItkDev\AzureKeyVault\Exception\VaultException;

/**
 * Class VaultCertificate.
 */
class VaultCertificate extends AbstractVault
{
    /**
     * Get certificate from the vault.
     *
     * @param $name
     *   Name of the certificate in the vault
     * @param $version
     *   Version to get
     *
     * @return certificate
     *   The fetched certificate
     *
     * @throws CertificateException
     */
    public function getCertificate($name, $version): Certificate
    {
        $apiCall = 'certificates/'.$name.'/'.$version.'?api-version=7.0';

        try {
            $response = $this->requestApi('GET', $apiCall, []);
        } catch (VaultException $e) {
            throw new CertificateException($e->getMessage(), $e->getCode());
        }

        if (200 === $response['code']) {
            $data = $response['data'];
            $cert = new Certificate(
                $data['id'],
                $data['cer'],
                $data['attributes']['enabled'],
                $data['attributes']['created'],
                $data['attributes']['updated'],
                $data['attributes']['exp']
            );
        } else {
            $cert = new Certificate(null, null, null, null, null, null);
        }

        return $cert;
    }
}
