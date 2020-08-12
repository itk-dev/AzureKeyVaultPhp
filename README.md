# Azure Key Vault
This is a php library to access certificates stored in Azure key vault through their rest API.

See https://docs.microsoft.com/en-gb/azure/key-vault/general/

# Installation

Add the github repository to your composer.json.

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/itk-dev/AzureKeyVaultPhp"
    }
],
```

Use composer to install the library.
```sh
composer require itkdev/azure-key-vault-php": "dev-master"
```

# Usage


```php
<?php

$autoloader = require_once 'vendor/autoload.php';

use Itkdev\Azurekeyvault\Authorisation\VaultToken;
use Itkdev\Azurekeyvault\Keyvault\VaultCertificate;

// Requires that you have an tenant if, client id and client secret.
$token = VaultToken::getToken(
    'xxxx',
    'yyyy',
    'zzzz');

// Get vault with the name 'testVault' using the access token.
$vault = new VaultCertificate('testVault', $token->getAccessToken());


$cert = $vault->getCertificate('TestCert', '8cb726a7bd52460a96a5496672562df0');
echo $cert->getCert();
```
