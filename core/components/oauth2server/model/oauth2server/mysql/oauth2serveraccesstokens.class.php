<?php
/**
 * @package oauth2server
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/oauth2serveraccesstokens.class.php');
class OAuth2ServerAccessTokens_mysql extends OAuth2ServerAccessTokens {}
?>