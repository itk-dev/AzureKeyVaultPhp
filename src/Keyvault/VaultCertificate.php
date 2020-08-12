<?php

/**
 * @file
 * Handle certificates from the vault.
 */

namespace Itkdev\Azurekeyvault\Keyvault;

use Itkdev\Azurekeyvault\Certificate;

/**
 * Class VaultCertificate.
 */
class VaultCertificate extends Vault
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
     * @throws \Itkdev\Azurekeyvault\Exception\CertificateException
     */
    public function getCertificate($name, $version): Certificate
    {
        $apiCall = 'certificates/'.$name.'/'.$version.'?api-version=7.0';
        $response = $this->requestApi('GET', $apiCall, []);

        if (200 === $response['code']) {
            $data = $response['data'];
            $cert = new Certificate($data['id'], $data['cer'], $data['attributes']['enabled'], $data['attributes']['created'], $data['attributes']['updated'], $data['attributes']['exp']);
        } else {
            $cert = new Certificate(null, null, null, null, null, null);
        }

        return $cert;
    }
}
