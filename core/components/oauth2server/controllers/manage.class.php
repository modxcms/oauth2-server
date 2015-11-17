<?php
require_once dirname(dirname(__FILE__)) . '/index.class.php';
/**
 * Loads the home page.
 *
 * @package OAuth2Server
 * @subpackage controllers
 */
class OAuth2ServerManageManagerController extends OAuth2ServerBaseManagerController {
    public function process(array $scriptProperties = array()) {

    }
    public function getPageTitle() { return $this->modx->lexicon('oauth2server'); }
    public function loadCustomCssJs() {
        
        $this->addJavascript($this->oauth2server->getOption('jsUrl').'mgr/widgets/clients.window.js');
        
        $this->addJavascript($this->oauth2server->getOption('jsUrl').'mgr/widgets/clients.grid.js');
        $this->addJavascript($this->oauth2server->getOption('jsUrl').'mgr/widgets/access_tokens.grid.js');
        $this->addJavascript($this->oauth2server->getOption('jsUrl').'mgr/widgets/refresh_tokens.grid.js');
        
        $this->addJavascript($this->oauth2server->getOption('jsUrl').'mgr/widgets/manage.panel.js');
        $this->addLastJavascript($this->oauth2server->getOption('jsUrl').'mgr/sections/manage.js');
    
        $this->addHtml("<script>
            Ext.onReady(function() {
                MODx.load({ xtype: 'oauth2server-page-manage'});
            });
        </script>");
        
    }

    public function getTemplateFile() { return $this->oauth2server->getOption('templatesPath') . 'manage.tpl'; }
}