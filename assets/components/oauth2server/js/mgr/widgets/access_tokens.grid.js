oauth2server.grid.OAuth2ServerAccessTokens = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: oauth2server.config.connectorUrl
        ,baseParams: {
            action: 'mgr/access_tokens/getlist'
        }
        ,fields: ['client_id', 'access_token', 'expires', 'scope', 'user_id']
        ,autoHeight: true
        ,paging: true
        ,remoteSort: true
        ,columns: [{
            header: _('oauth2server.access_tokens.client_id')
            ,dataIndex: 'client_id'
            ,sortable: true
            ,width: 60
        },{
            header: _('oauth2server.access_tokens.access_token')
            ,dataIndex: 'access_token'
            ,sortable: true
            ,width: 160
        },{
            header: _('oauth2server.access_tokens.expires')
            ,dataIndex: 'expires'
            ,sortable: true
            ,width: 80
        },{
            header: _('oauth2server.access_tokens.scope')
            ,dataIndex: 'scope'
            ,sortable: true
            ,width: 60
        },{
            header: _('oauth2server.access_tokens.user_id')
            ,dataIndex: 'user_id'
            ,sortable: true
            ,width: 50
        }]
    });
    oauth2server.grid.OAuth2ServerAccessTokens.superclass.constructor.call(this,config);
};
Ext.extend(oauth2server.grid.OAuth2ServerAccessTokens,MODx.grid.Grid,{
    filters: []
    
    ,getMenu: function() {
        var m = [];
        m.push({
            text: _('oauth2server.access_tokens.remove')
            ,handler: this.removeToken
        });
        this.addContextMenuItem(m);
    }
    
    ,removeToken: function(btn,e) {
        if (!this.menu.record) return false;
        
        MODx.msg.confirm({
            title: _('oauth2server.access_tokens.remove')
            ,text: _('oauth2server.access_tokens.remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/access_tokens/remove'
                ,access_token: this.menu.record.access_token
            }
            ,listeners: {
                'success': {fn:function(r) { this.refresh(); },scope:this}
            }
        });
    }
});
Ext.reg('oauth2server-grid-access-tokens',oauth2server.grid.OAuth2ServerAccessTokens);
