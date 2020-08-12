<?php

namespace Itkdev\Azurekeyvault\Keyvault;

use Itkdev\Azurekeyvault\Certificate;

class VaultCertificate extends Vault {

    public function __construct($vaultName, $accessToken)
    {
        parent::__construct($vaultName, $accessToken);
    }

    public function getCertificate($name, $version): Certificate
    {
        $apiCall = 'certificates/'.$name.'/'.$version.'?api-version=7.0';
        $response = $this->requestApi('GET', $apiCall);

        if ($response['code'] === 200) {
            $data = $response['data'];
            $cert = new Certificate($data['id'], $data['cer'], $data['attributes']['enabled'], $data['attributes']['created'], $data['attributes']['updated'], $data['attributes']['exp']);
        }
        else {
            $cert = new Certificate(null, null, null, null, null, null);
        }

        return $cert;
    }
}