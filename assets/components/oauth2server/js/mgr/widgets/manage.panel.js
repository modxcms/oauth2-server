oauth2server.panel.Manage = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h2>'+_('oauth2server.menu.manage')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,activeTab: 0
            ,hideMode: 'offsets'
            ,items: [{
                title: _('oauth2server.clients.clients')
                ,items: [{
                    html: '<p>'+_('oauth2server.clients.intro_msg')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'oauth2server-grid-clients'
                    ,preventRender: true
                    ,cls: 'main-wrapper'
                }]
            },{
                title: _('oauth2server.access_tokens.access_tokens')
                ,items: [{
                    html: '<p>'+_('oauth2server.access_tokens.intro_msg')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'oauth2server-grid-access-tokens'
                    ,preventRender: true
                    ,cls: 'main-wrapper'
                }]
            },{
                title: _('oauth2server.refresh_tokens.refresh_tokens')
                ,items: [{
                    html: '<p>'+_('oauth2server.refresh_tokens.intro_msg')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'oauth2server-grid-refresh-tokens'
                    ,preventRender: true
                    ,cls: 'main-wrapper'
                }]
            }]
        }]
    });
    oauth2server.panel.Manage.superclass.constructor.call(this,config);
};
Ext.extend(oauth2server.panel.Manage, MODx.Panel);
Ext.reg('oauth2server-panel-manage', oauth2server.panel.Manage);
