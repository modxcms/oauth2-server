<?php
/**
 * verifyOAuth2
 * 
 * Verifies an OAuth2 request in MODX
 * 
 * OPTIONS:
 * redirectUnauthorized -   (int) Sends unauthorized response, preventing anything below this Snippet 
 *                          in the Resource/Template from being processed. If disabled, exit() WILL NOT
 *                          be called!. Return values can be customized in the properties below. Default 1 
 * redirectTo -             (string) Accepts either 'error' or 'unauthorized'. Both methods call exit(). 
 *                          Default 'unauthorized'
 * returnOnUnauthorized -   (mixed) Specify a return value if request is unauthorized. Default 0
 * returnOnSuccess -        (mixed) Specify a return value if request is successfully verified. Default 1
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

// Options
$redirectUnauthorized = (int) $modx->getOption('redirectUnauthorized', $scriptProperties, 1);
$redirectTo = $modx->getOption('redirectTo', $scriptProperties, 'unauthorized');
$returnOnUnauthorized = $modx->getOption('returnOnUnauthorized', $scriptProperties, 0);
$returnOnSuccess = $modx->getOption('returnOnSuccess', $scriptProperties, 1);

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

// Verify resource requests
$verified = $server->verifyResourceRequest($request);
if (!$verified) {
    if ($redirectUnauthorized) {
        if ($redirectTo === 'error') {
            $modx->sendError();
        } else {
            $oauth2->sendUnauthorized();
        }
    } else {
        return $returnOnUnauthorized;
    }
} else {
    return $returnOnSuccess;
}