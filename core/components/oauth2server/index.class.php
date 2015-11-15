<?php
require_once dirname(__FILE__) . '/model/oauth2server/oauth2server.class.php';
/**
 * @package OAuth2Server
 */

abstract class OAuth2ServerBaseManagerController extends modExtraManagerController {
    /** @var Oauth2Server $oauth2server */
    public $oauth2server;
    public function initialize() {
        $this->oauth2server = new OAuth2Server($this->modx);

        $this->addCss($this->oauth2server->getOption('cssUrl').'mgr.css');
        $this->addJavascript($this->oauth2server->getOption('jsUrl').'mgr/oauth2server.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            oauth2server.config = '.$this->modx->toJSON($this->oauth2server->options).';
            oauth2server.config.connector_url = "'.$this->oauth2server->getOption('connectorUrl').'";
        });
        </script>');
        
        parent::initialize();
    }
    public function getLanguageTopics() {
        return array('oauth2server:default');
    }
    public function checkPermissions() { return true;}
}