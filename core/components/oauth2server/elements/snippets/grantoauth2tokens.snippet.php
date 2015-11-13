<?php
/**
 * serveOAuth2
 * 
 * Serves as OAuth2 endpoint in MODX
 *
 *
 **/

// Options

// Paths
$corePath = $modx->getOption('oauth2server.core_path', null, $modx->getOption('core_path') . 'components/oauth2server/');
$oAuth2Path = $corePath . 'model/OAuth2/';

// Load OAuth2
require_once($oAuth2Path . 'Autoloader.php');
OAuth2\Autoloader::register();

// Init storage and server
$storage = new OAuth2\Storage\Pdo($modx->config['connections'][0]);
$server = new OAuth2\Server($storage, array('enforce_state' => false));

$server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));
$server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));

// Process request/response
$request = OAuth2\Request::createFromGlobals();
$response = new OAuth2\Response();

// Only handle token requests if POST
$post = modX::sanitize($_POST, $modx->sanitizePatterns);
if (!empty($post)) {
    $server->handleTokenRequest($request)->send();
} else {
    // Only handle resource requests if GET
    if (!$server->verifyResourceRequest($request)) {
        return $modx->toJSON(array('success' => false, 'message' => 'Unauthorized.'));
    }
    // If verified, do stuff:
    return $modx->toJSON(array('success' => true, 'message' => 'You accessed my APIs!'));
}