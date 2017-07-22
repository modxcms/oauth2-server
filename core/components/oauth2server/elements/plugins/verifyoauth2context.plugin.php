<?php
/**
 * VerifyOAuth2Context
 * 
 * Verifies an OAuth2 request to a specific MODX Context
 * 
 * OPTIONS:
 * contexts -       (string) A comma-separated list of contexts to require OAuth2 verification. Default 'api' 
 * excludeUris -    (string) A comma-separated list of URIs to exclude from verification. Vast majority of use
 *                  cases will likely include the token controller and authorization endpoint. 
 *                  Default 'auth.html,tokens.json'
 * redirectTo -     (string) Accepts either 'error' or 'unauthorized'. Both methods call exit(). 
 *                  Default 'unauthorized'
 *
 * @package OAuth2Server
 * @author @sepiariver <yj@modx.com>
 * Copyright 2015 by YJ Tso
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 **/
 
 // Note: set Plugin priority to a high number to run last
$ctx = $modx->context->get('key');
if ($ctx === 'mgr' || $modx->event->name !== 'OnWebPageInit') return; 

// Options
$contexts = array_filter(array_map('trim', explode(',', $modx->getOption('contexts', $scriptProperties, 'api'))));
// only work on specified contexts
if (!in_array($ctx, $contexts)) return;
$excludeUris = array_map('strtolower',array_map('trim', explode(',', $modx->getOption('excludeUris', $scriptProperties, 'auth.html,tokens.json'))));
// escape if member of excludeUris
$rpa = $modx->getOption('request_param_alias', null, 'q');
if (in_array(strtolower($_REQUEST[$rpa]), $excludeUris)) return;
// 'unauthorized' or 'error' response
$redirectTo = $modx->getOption('redirectTo', $scriptProperties, 'unauthorized');

// Paths
$oauth2Path = $modx->getOption('oauth2server.core_path', null, $modx->getOption('core_path') . 'components/oauth2server/');
$oauth2Path .= 'model/oauth2server/';

// Get Class
if (file_exists($oauth2Path . 'oauth2server.class.php')) $oauth2 = $modx->getService('oauth2server', 'OAuth2Server', $oauth2Path, $scriptProperties);
if (!($oauth2 instanceof OAuth2Server)) {
    $modx->log(modX::LOG_LEVEL_ERROR, '[authorizeOAuth2] could not load the required class!');
    $modx->sendError();
}
// We need these
$server = $oauth2->createServer();
$request = $oauth2->createRequest();
$response = $oauth2->createResponse();
if (!$server || !$request || !$response) {
    $modx->log(modX::LOG_LEVEL_WARN, '[verifyOAuth2]: could not create the required OAuth2 Server objects.');
    $modx->sendError();
}

// Verify resource requests
$verified = $server->verifyResourceRequest($request);
if (!$verified) {
    if ($redirectTo === 'error') {
        $modx->sendError();
    } else {
        $oauth2->sendUnauthorized();
    }
} else {
    header('Access-Control-Allow-Origin: *');
}