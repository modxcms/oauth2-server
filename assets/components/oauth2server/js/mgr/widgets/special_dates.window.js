weather.window.SpecialDates = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('weather.special_dates.add')
        ,closeAction: 'close'
        ,url: weather.config.connectorUrl
        ,action: 'mgr/special_dates/create'
        ,autoHeight: true
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'datefield'
            ,editable: false
            ,fieldLabel: _('weather.special_dates.date')
            ,name: 'date'
            ,anchor: '100%'
        },{
            xtype: 'weather-combo-contexts'
            ,fieldLabel: _('weather.special_dates.contexts')
            ,name: 'contexts'
            ,anchor: '100%'
        },{
            xtype: 'modx-combo-browser'
            ,triggerClass: 'x-form-image-trigger'
            ,fieldLabel: _('weather.special_dates.icon')
            ,name: 'icon'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('weather.special_dates.link')
            ,name: 'link'
            ,anchor: '100%'
        }]
    });
    weather.window.SpecialDates.superclass.constructor.call(this,config);
};
Ext.extend(weather.window.SpecialDates, MODx.Window);
Ext.reg('weather-window-special-dates', weather.window.SpecialDates);