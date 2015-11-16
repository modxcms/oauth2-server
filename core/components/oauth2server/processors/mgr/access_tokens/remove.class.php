<?php
/**
 * Remove a OAuth2Server AccessToken
 * 
 * @package OAuth2Server
 * @subpackage processors
 */
class OAuth2ServerAccessTokensRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'OAuth2ServerAccessTokens';
    public $languageTopics = array('oauth2server:default');
    public $primaryKeyField = 'access_token';
    public $objectType = 'oauth2server.access_tokens';
    /** @var OAuth2ServerAccessTokens */
    public $object;

    public function afterRemove()
    {
        /** @var xPDOFileCache $provider */
        $provider = $this->modx->cacheManager->getCacheProvider('oauth2server');
        $provider->flush();

        return parent::afterRemove();
    }
}

return 'OAuth2ServerAccessTokensRemoveProcessor';