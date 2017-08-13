<?php
/**
 * Resolve creating db tables
 *
 * THIS RESOLVER IS AUTOMATICALLY GENERATED, NO CHANGES WILL APPLY
 *
 * @package oauth2server
 * @subpackage build
 *
 * @var mixed $object
 * @var modX $modx
 * @var array $options
 */

if ($object->xpdo) {
    $modx =& $object->xpdo;
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $modelPath = $modx->getOption('oauth2server.core_path', null, $modx->getOption('core_path') . 'components/oauth2server/') . 'model/';
            
            $modx->addPackage('oauth2server', $modelPath, null);


            $manager = $modx->getManager();

            $manager->createObjectContainer('OAuth2ServerClients');
            $manager->createObjectContainer('OAuth2ServerAccessTokens');
            $manager->createObjectContainer('OAuth2ServerAuthorizationCodes');
            $manager->createObjectContainer('OAuth2ServerRefreshTokens');
            $manager->createObjectContainer('OAuth2ServerScopes');
            $manager->createObjectContainer('OAuth2ServerJwt');

            break;
    }
}

return true;