<?php
/**
 * serveOAuth2
 * 
 * Serves an OAuth2 endpoint in MODX
 * 
 * OPTIONS:
 * redirectUnauthorized -   (int) Redirects unauthorized requests, preventing anything below this Snippet in the Resource/Template from being processed. Default 1 
 * redirectTo -             (string) Accepts either 'error' or 'unauthorized' page, to which to redirect users. Default 'unauthorized'
 * returnOnUnauthorized -   (mixed) Specify a return value if request is unauthorized. Default 0
 * returnOnSuccess -        (mixed) Specify a return value if request is successfully verified. Default 1
 * 
 **/

// Options
$redirectUnauthorized = (int) $modx->getOption('redirectUnauthorized', $scriptProperties, 0);
$redirectTo = $modx->getOption('redirectTo', $scriptProperties, 'unauthorized');
$returnOnUnauthorized = $modx->getOption('returnOnUnauthorized', $scriptProperties, 0);
$returnOnSuccess = $modx->getOption('returnOnSuccess', $scriptProperties, 1);

// Paths
$corePath = $modx->getOption('oauth2server.core_path', null, $modx->getOption('core_path') . 'components/oauth2server/');
$oAuth2Path = $corePath . 'model/OAuth2/';

// Load OAuth2
require_once($oAuth2Path . 'Autoloader.php');
OAuth2\Autoloader::register();

// Init storage and server
$storage = new OAuth2\Storage\Pdo($modx->config['connections'][0]);
$server = new OAuth2\Server($storage, array('enforce_state' => false));

// Only auth code grant type supported right now
$server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));

// Process request/response
$request = OAuth2\Request::createFromGlobals();
$response = new OAuth2\Response();

// Verify resource requests
$verified = $server->verifyResourceRequest($request);
if (!$verified) {
    if ($redirectUnauthorized) {
        if ($redirectTo === 'error') {
            $modx->sendErrorPage();
        } else {
            $modx->sendUnauthorizedPage();
        }
    } else {
        return $returnOnUnauthorized;
    }
} else {
    return $returnOnSuccess;
}