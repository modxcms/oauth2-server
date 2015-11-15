oauth2server.page.Manage = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'oauth2server-panel-manage'
            ,renderTo: 'oauth2server-panel-manage-div'
        }]
    });
    oauth2server.page.Manage.superclass.constructor.call(this, config);
};
Ext.extend(oauth2server.page.Manage, MODx.Component);
Ext.reg('oauth2server-page-manage', oauth2server.page.Manage);
