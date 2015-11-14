<?php
/**
 * @package oauth2server
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/oauth2serverclients.class.php');
class OAuth2ServerClients_mysql extends OAuth2ServerClients {}
?>