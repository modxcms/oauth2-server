<?php
/**
 * authorizeOAuth2
 * 
 * OAuth2 Authorization endpoint for MODX
 * Filters requests on the User's MODX User Group Membership, 
 * but also exposes the Manager URL for login! Recommended:
 * call this snippet in a Login snippet logoutTpl to implement 
 * custom login page.
 *
 **/

// Check User TODO: best way to handle manager login without exposing manager_url?
if (!$modx->user) {
    $modx->sendRedirect($modx->getOption('manager_url'));
} 
if  (!$modx->user->isMember('Administrator')) return 'Only Administrators can authorize OAuth2 requests.';

// Options
$authTpl = $modx->getOption('authTpl', $scriptProperties, 'oauth2server_auth_tpl');
$authKey = $modx->getOption('authKey', $scriptProperties, 'authorize');

// Paths
$oauth2Path = $modx->getOption('oauth2server.core_path', null, $modx->getOption('core_path') . 'components/oauth2server/');
$oauth2Path .= 'model/oauth2server/';

// Get Class
if (file_exists($oauth2Path . 'oauth2server.class.php')) $oauth2 = $modx->getService('oauth2server', 'OAuth2Server', $oauth2Path, $scriptProperties);
if (!($oauth2 instanceof OAuth2Server)) {
    $modx->log(modX::LOG_LEVEL_ERROR, '[authorizeOAuth2] could not load the required class!');
    return;
}
// We need these
$server = $oauth2->createServer();
$request = $oauth2->createRequest();
$response = $oauth2->createResponse();
if (!$server || !$request || !$response) {
    $modx->log(modX::LOG_LEVEL_WARN, '[verifyOAuth2]: could not create the required OAuth2 Server objects.');
    return;
}

// Validate the authorization request
if (!$server->validateAuthorizeRequest($request, $response)) {
    return 'The authorization request was invalid.';
}

// Display an authorization form
$post = modX::sanitize($_POST, $modx->sanitizePatterns);
if (empty($post)) {
    return $modx->getChunk($authTpl, array('auth_key' => $authKey));
}

// Redirect to stored redirect_uri for this client, if authorized
$is_authorized = ($post[$authKey] === 'yes');
$server->handleAuthorizeRequest($request, $response, $is_authorized);
$response->send();