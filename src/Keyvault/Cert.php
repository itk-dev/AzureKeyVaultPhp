<?php

namespace Itkdev\Azurekeyvault\Keyvault;

class Certificate extends Vault {

    public function __construct($vaultName, $accessToken)
    {
        parent::__construct($vaultName, $accessToken);
    }

    public function getCetificate($name, $version)
    {

        $apiCall = 'certificates/'.$name.'/'.$version.'?api-version=7.0';

        return $this->requestApi('GET', $apiCall);
    }
}