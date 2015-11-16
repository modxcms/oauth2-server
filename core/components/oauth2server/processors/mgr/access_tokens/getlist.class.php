<?php
/**
 * Get list of OAuth2Server AccessTokens
 *
 * @package OAuth2Server
 * @subpackage processors
 */
class OAuth2ServerAccessTokensGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'OAuth2ServerAccessTokens';
    public $languageTopics = array('oauth2server:default');
    public $primaryKeyField = 'access_token';
    public $defaultSortField = 'client_id';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'oauth2server.access_tokens';
    /** @var OAuth2ServerAccessTokens */
    public $object;
}

return 'OAuth2ServerAccessTokensGetListProcessor';