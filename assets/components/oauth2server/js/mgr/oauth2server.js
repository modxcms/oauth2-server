var OAuth2Server = function(config) {
    config = config || {};
OAuth2Server.superclass.constructor.call(this,config);
};
Ext.extend(OAuth2Server,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {}
});
Ext.reg('oauth2server',OAuth2Server);
oauth2server = new OAuth2Server();