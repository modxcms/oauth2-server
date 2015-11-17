<?php
/**
 * Remove a OAuth2Server RefreshToken
 * 
 * @package OAuth2Server
 * @subpackage processors
 */
class OAuth2ServerRefreshTokensRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'OAuth2ServerRefreshTokens';
    public $languageTopics = array('oauth2server:default');
    public $primaryKeyField = 'refresh_token';
    public $objectType = 'oauth2server.refresh_tokens';
    /** @var OAuth2ServerRefreshTokens */
    public $object;

    public function afterRemove()
    {
        /** @var xPDOFileCache $provider */
        $provider = $this->modx->cacheManager->getCacheProvider('oauth2server');
        $provider->flush();

        return parent::afterRemove();
    }
}

return 'OAuth2ServerRefreshTokensRemoveProcessor';