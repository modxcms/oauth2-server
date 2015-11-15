<?php
/**
 * OAuth2Server Connector
 *
 * @package OAuth2Server
 */
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$corePath = $modx->getOption('oauth2server.core_path', null, $modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/oauth2server/');
$oauth2server = $modx->getService(
    'oauth2server',
    'OAuth2Server',
    $corePath . 'model/oauth2server/',
    array(
        'core_path' => $corePath
    )
);

/* handle request */
$modx->request->handleRequest(
    array(
        'processors_path' => $oauth2server->getOption('processorsPath', null, $corePath . 'processors/'),
        'location' => '',
    )
);