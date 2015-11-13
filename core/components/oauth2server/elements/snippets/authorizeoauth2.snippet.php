<?php
/**
 * authorizeOAuth2
 * 
 * OAuth2 Authorization endpoint for MODX
 * Filters requests on the User's MODX User Group Membership, 
 * but also exposes the Manager URL for login!
 *
 **/

// Check User TODO: best way to handle manager login without exposing manager_url?
if (!$modx->user) {
    $modx->sendRedirect($modx->getOption('manager_url'));
} 
if  (!$modx->user->isMember('Administrator')) return 'Only Administrators can authorize OAuth2 requests.';

// Options
$authTpl = $modx->getOption('authTpl', $scriptProperties, 'oauth2server_authTpl');
$authKey = $modx->getOption('authKey', $scriptProperties, 'authorize');

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

// Do stuff
$request = OAuth2\Request::createFromGlobals();
$response = new OAuth2\Response();

// validate the authorize request
if (!$server->validateAuthorizeRequest($request, $response)) {
    return 'The authorization request was invalid.';
}
// display an authorization form
$post = modX::sanitize($_POST, $modx->sanitizePatterns);
if (empty($post)) {
    return $modx->getChunk($authTpl, array('auth_key' => $authKey));
}

// print the authorization code if the user has authorized your client
$is_authorized = ($post[$authKey] === 'yes');
$server->handleAuthorizeRequest($request, $response, $is_authorized);
$response->send();