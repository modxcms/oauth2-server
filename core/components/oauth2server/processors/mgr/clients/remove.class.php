<?php
/**
 * Remove a OAuth2Server Client
 * 
 * @package OAuth2Server
 * @subpackage processors
 */
class OAuth2ServerClientsRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'OAuth2ServerClients';
    public $languageTopics = array('oauth2server:default');
    public $primaryKeyField = 'client_id';
    public $objectType = 'oauth2server.clients';
    /** @var OAuth2ServerClients */
    public $object;

    public function afterRemove()
    {
        /** @var xPDOFileCache $provider */
        $provider = $this->modx->cacheManager->getCacheProvider('oauth2server');
        $provider->flush();

        return parent::afterRemove();
    }
}

return 'OAuth2ServerClientsRemoveProcessor';