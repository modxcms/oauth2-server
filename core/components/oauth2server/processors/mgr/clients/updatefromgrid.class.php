<?php
/**
 * Update a OAuth2Server Client from the grid
 *
 * @package OAuth2Server
 * @subpackage processors
 */
require_once (dirname(__FILE__).'/update.class.php');
class OAuth2ServerClientsUpdateFromGridProcessor extends OAuth2ServerClientsUpdateProcessor {
    public function initialize() {
        $data = $this->getProperty('data');
        if (empty($data)) return $this->modx->lexicon('invalid_data');
        $data = $this->modx->fromJSON($data);
        if (empty($data)) return $this->modx->lexicon('invalid_data');
        $this->setProperties($data);
        $this->unsetProperty('data');
        
        return parent::initialize();
    }
}
return 'OAuth2ServerClientsUpdateFromGridProcessor';