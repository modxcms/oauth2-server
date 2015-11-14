<?php
/**
 * @package oauth2server
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/oauth2serverrefreshtokens.class.php');
class OAuth2ServerRefreshTokens_mysql extends OAuth2ServerRefreshTokens {}
?>