<?php
/**
 * Get list of OAuth2Server Clients
 *
 * @package OAuth2Server
 * @subpackage processors
 */
class OAuth2ServerClientsGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'OAuth2ServerClients';
    public $languageTopics = array('oauth2server:default');
    public $primaryKeyField = 'client_id';
    public $defaultSortField = 'client_id';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'oauth2server.clients';
    /** @var OAuth2ServerClients */
    public $object;
}

return 'OAuth2ServerClientsGetListProcessor';