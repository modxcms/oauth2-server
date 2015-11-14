<?php
/**
 * @package oauth2server
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/oauth2serverauthorizationcodes.class.php');
class OAuth2ServerAuthorizationCodes_mysql extends OAuth2ServerAuthorizationCodes {}
?>