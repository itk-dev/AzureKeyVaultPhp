# Azure Key Vault
This is a php library to access certificates and secrets stored in Azure key vault through their rest API.

See https://docs.microsoft.com/en-gb/azure/key-vault/general/

# Installation

Add the github repository to your composer.json.

```json
"repositories": {
    "itk-dev/azure-key-vault-php": {
        "type": "vcs",
        "url": "https://github.com/itk-dev/AzureKeyVaultPhp"
    }
},
```

Use composer to install the library.
```sh
composer require itk-dev/azure-key-vault-php": "dev-master"
```

# Usage


```php
<?php

$autoloader = require_once 'vendor/autoload.php';

use Itkdev\AzureKeyVault\Authorisation\VaultToken;
use Itkdev\AzureKeyVault\KeyVault\VaultCertificate;
use Itkdev\AzureKeyVault\KeyVault\VaultSecret;

// The VaultToken class requires a PSR-18 compatible http client and a PSR-17 compatible request factory.
$vaultToken = new VaultToken($httpClient, $requestFactory);

// Requires that you have an tenant if, client id and client secret.
$token = $vaultToken->getToken(
    'xxxx',
    'yyyy',
    'zzzz'
);    

// Certificates
// This requires a PSR-18 compatible http client and a PSR-17 compatible request factory.
// Get vault with the name 'testVault' using the access token.
$vault = new VaultCertificate($httpClient, $requestFactory, 'testVault', $token->getAccessToken());

$cert = $vault->getCertificate('TestCert', '8cb726a7bd52460a96a5496672562df0');
echo $cert->getCert();

// Secrets
// This requires a PSR-18 compatible http client and a PSR-17 compatible request factory.
// Get vault with the name 'testVault' using the access token.
$vault = new VaultSecret($httpClient, $requestFactory, 'testVault', $token->getAccessToken());

$secret = $vault->getSecret('TestCert', '8cb726a7bd52460a96a5496672562df0');
echo $secret->getValue();
```

# Storing certificates in the vault

You may have to rename your `.p12` file to `.pfx` before being able to upload to the Azure Key Vault.

## Removing passphrase from PKCS12 certificates

If you don't want to have a passphrase on the certificate stored in the Azure Key Vault,
you can use the following command to remove the passphrase:

```shell
openssl pkcs12 -in certificate.p12 -nodes | openssl pkcs12 -export -out certificate.passwordless.pfx
```

<!--
# Convert p12 file to pem

<https://github.com/MicrosoftDocs/azure-docs/issues/23558#issuecomment-823693525>

```sh
openssl pkcs12 -in hatogbriller.p12 -out tmp.pem -nodes
(openssl x509 -in tmp.pem; openssl pkcs8 -topk8 -nocrypt -in tmp.pem) >| hatogbriller.pem
rm tmp.pem
```
-->

