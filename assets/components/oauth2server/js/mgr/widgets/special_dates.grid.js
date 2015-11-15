weather.grid.SpecialDates = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: weather.config.connectorUrl
        ,baseParams: {
            action: 'mgr/special_dates/getlist'
        }
        ,fields: ['id', 'date', 'icon', 'link', 'contexts']
        ,autoHeight: true
        ,paging: true
        ,remoteSort: true
        ,columns: [{
            header: _('id')
            ,dataIndex: 'id'
            ,width: 70
            ,hidden: true
        },{
            header: _('weather.special_dates.date')
            ,dataIndex: 'date'
            ,sortable: true
            ,width: 200
        },{
            header: _('weather.special_dates.contexts')
            ,dataIndex: 'contexts'
            ,width: 250
            ,renderer: function(value, metaData) {
                var joined = '';
                
                Ext.each(value, function(ctx, index){
                    joined += ctx;
                    
                    if ((index + 1) % 3 == 0) {
                        joined += '<br />';
                    } else {
                        if (value[index + 1]) {
                            joined += ', ';
                        }
                    }
                });
                
                metaData.attr = 'ext:qtip="' + joined + '"';
                
                return value;
            }
        },{
            header: _('weather.special_dates.icon')
            ,dataIndex: 'icon'
            ,width: 250
        },{
            header: _('weather.special_dates.link')
            ,dataIndex: 'link'
            ,width: 250
        }]
        ,tbar: [{
            text: _('weather.special_dates.add')
            ,handler: this.addDate
            ,scope: this
        },'->',{
            xtype: 'weather-combo-context'
            ,width: 150
            ,emptyText: _('weather.special_dates.filter_by_context')
            ,name: 'context'
            ,listeners: {
                render: {
                    fn: function(contextCombo){
                        this.filters.push(contextCombo);                 
                    }
                    ,scope: this
                }
                ,select: {
                    fn: this.filterByContext
                    ,scope:this
                }
            }
        },{
            xtype: 'datefield'
            ,width: 130
            ,editable: false
            ,emptyText: _('weather.special_dates.filter_by_date')
            ,name: 'date'
            ,listeners: {
                render: {
                    fn: function(dateField){
                        this.filters.push(dateField);                 
                    }
                    ,scope: this
                }
                ,select: {
                    fn: this.filterByDate
                    ,scope:this
                }
            }
        },' ', {
            text: _('weather.global.clear_filters')
            ,handler: this.clearFilters
        }]
    });
    weather.grid.SpecialDates.superclass.constructor.call(this,config);
};
Ext.extend(weather.grid.SpecialDates,MODx.grid.Grid,{
    filters: []
    
    ,getMenu: function() {
        var m = [];
        m.push({
            text: _('weather.special_dates.update')
            ,handler: this.updateDate
        });
        m.push({
            text: _('weather.special_dates.duplicate')
            ,handler: this.duplicateDate
        });
        m.push('-');
        m.push({
            text: _('weather.special_dates.remove')
            ,handler: this.removeDate
        });
        this.addContextMenuItem(m);
    }
    
    ,addDate: function(btn,e) {

        var addDate = MODx.load({
            xtype: 'weather-window-special-dates'
            ,listeners: {
                'success': {fn:function() { this.refresh(); },scope:this}
            }
        });

        addDate.show(e.target);
    }

    ,updateDate: function(btn,e) {
        if (!this.menu.record || !this.menu.record.id) return false;
        
        this.menu.record['contexts[]'] = this.menu.record.contexts;
        
        var updateDate = MODx.load({
            xtype: 'weather-window-special-dates'
            ,title: _('weather.special_dates.update')
            ,action: 'mgr/special_dates/update'
            ,record: this.menu.record
            ,listeners: {
                'success': {fn:function() { this.refresh(); },scope:this}
            }
        });

        updateDate.show(e.target);
        updateDate.setValues(this.menu.record);
    }
    
    ,duplicateDate: function(btn,e) {
        if (!this.menu.record || !this.menu.record.id) return false;
        
        this.menu.record['contexts[]'] = this.menu.record.contexts;
        
        var duplicateDate = MODx.load({
            xtype: 'weather-window-special-dates'
            ,title: _('weather.special_dates.duplicate')
            ,action: 'mgr/special_dates/create'
            ,record: this.menu.record
            ,listeners: {
                'success': {fn:function() { this.refresh(); },scope:this}
            }
        });

        duplicateDate.show(e.target);
        duplicateDate.setValues(this.menu.record);
    }
    
    ,removeDate: function(btn,e) {
        if (!this.menu.record) return false;
        
        MODx.msg.confirm({
            title: _('weather.special_dates.remove')
            ,text: _('weather.special_dates.remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/special_dates/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:function(r) { this.refresh(); },scope:this}
            }
        });
    }

    ,filterByDate: function(dateField, value) {
        this.getStore().baseParams[dateField.name] = value;
        this.getBottomToolbar().changePage(1);
    }
    
    ,filterByContext: function(combo, value){
        this.getStore().baseParams[combo.name] = value.data.key;
        this.getBottomToolbar().changePage(1);       
    }

    ,clearFilters: function(){
        var baseParams = this.getStore().baseParams;
        
        Ext.each(this.filters, function(filter){
            delete baseParams[filter.name];
            filter.setValue();             
        });

        this.getBottomToolbar().changePage(1);
    }
    
});
Ext.reg('weather-grid-special-dates',weather.grid.SpecialDates);

