<?php
require __DIR__ . '/vendor/autoload.php';

use Jumbojett\OpenIDConnectClient;

$oidc = new OpenIDConnectClient('https://id.provider.com',
                                'ClientIDHere',
                                'ClientSecretHere');
$oidc->setCertPath('/path/to/my.cert');
$oidc->authenticate();
$name = $oidc->requestUserInfo('given_name');
