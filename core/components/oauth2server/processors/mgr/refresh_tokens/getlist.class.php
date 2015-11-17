<?php
/**
 * Get list of OAuth2Server RefreshTokens
 *
 * @package OAuth2Server
 * @subpackage processors
 */
class OAuth2ServerRefreshTokensGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'OAuth2ServerRefreshTokens';
    public $languageTopics = array('oauth2server:default');
    public $primaryKeyField = 'refresh_token';
    public $defaultSortField = 'client_id';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'oauth2server.refresh_tokens';
    /** @var OAuth2ServerRefreshTokens */
    public $object;
}

return 'OAuth2ServerRefreshTokensGetListProcessor';