MaxCDN.grid.Rules = function(config) {
    config = config || {};

    this.exp = new Ext.grid.RowExpander({
        tpl : new Ext.Template(
            '<p class="mcdn_cdn_url"><strong>' + _('mcdn.cdn_url') + '</strong>: {cdn_url}</p>' +
            '<p class="mcdn_cdn_url"><strong>' + _('mcdn.input') + '</strong>: {input}</p>' +
            '<p class="mcdn_cdn_url"><strong>' + _('mcdn.output') + '</strong>: {output}</p>'
        )
    });

    Ext.applyIf(config,{
        url: MaxCDN.config.connectorUrl
        ,id: 'macdn-grid-rules'
        ,baseParams: {
            action: 'mgr/rules/getlist'
        }
        ,emptyText: _('mcdn.error.noresults')
        ,fields: [
            {name: 'id', type: 'int'}
            ,{name: 'name', type: 'string'}
            ,{name: 'description', type: 'string'}
            ,{name: 'content_type', type: 'int'}
            ,{name: 'all_contexts', type: 'int'}
            ,{name: 'context', type: 'string'}
            ,{name: 'content_type_name', type: 'string'}
            ,{name: 'input', type: 'string'}
            ,{name: 'output', type: 'string'}
            ,{name: 'zone', type: 'string'}
            ,{name: 'scheme', type: 'string'}
            ,{name: 'cdn_url', type: 'string'}
            ,{name: 'disabled', type: 'int'}
            ,{name: 'sortorder', type: 'int'}
        ]
        ,grouping: true
        ,groupBy: 'content_type_name'
        ,singleText: _('mcdn.rule')
        ,pluralText: _('mcdn.rules')
        ,sortBy: 'sortorder'
        ,paging: true
        ,remoteSort: true
        ,plugins: this.exp
        ,columns: [this.exp,{
            header: _('mcdn.content_type')
            ,dataIndex: 'content_type_name'
            ,hidden: true
        },{
            header: _('mcdn.context')
            ,dataIndex: 'context'
            ,sortable: true
            ,width: 30
            ,renderer: function(v) {
                if (v == '') {
                    return _('mcdn.all');
                } else {
                    return v;
                }
            }
        },{
            header: _('mcdn.name')
            ,dataIndex: 'name'
            ,sortable: true
            ,width: 175
        },{
            header: _('mcdn.description')
            ,dataIndex: 'description'
            ,sortable: true
            ,width: 200
        },{
            header: _('mcdn.disabled')
            ,dataIndex: 'disabled'
            ,sortable: true
            ,width: 75
            ,renderer: this.rendYesNo
        },{
            header: _('mcdn.sortorder')
            ,dataIndex: 'sortorder'
            ,sortable: true
            ,width: 50
        }]
        ,tools: [{
            id: 'plus'
            ,qtip: _('expand_all')
            ,handler: this.expandAll
            ,scope: this
        },{
            id: 'minus'
            ,hidden: true
            ,qtip: _('collapse_all')
            ,handler: this.collapseAll
            ,scope: this
        }]
        ,tbar: [{
            text: _('mcdn.add_rule')
            ,handler: this.addRule
            ,scope: this
        }]
    });
    this.view = new Ext.grid.GroupingView({
        emptyText: config.emptyText || _('ext_emptymsg')
        ,forceFit: true
        ,autoFill: true
        ,showPreview: true
        ,enableRowBody: true
        ,scrollOffset: 0
    });
    MaxCDN.grid.Rules.superclass.constructor.call(this,config);
};
Ext.extend(MaxCDN.grid.Rules,MODx.grid.Grid,{
    addRule: function() {
        var win = MODx.load({
            xtype: 'mcdn-window-rule'
            ,listeners: {
                success: {fn: function(r) {
                    this.refresh();
                },scope: this}
                ,scope: this
            }
        });
        win.show();
    }
    ,updateRule: function() {
        var record = this.menu.record;
        var win = MODx.load({
            xtype: 'mcdn-window-rule'
            ,listeners: {
                success: {fn: function(r) {
                    this.refresh();
                },scope: this}
                ,scope: this
            }
            ,isUpdate: true
        });
        win.setValues(record);
        win.show();
    }
    ,duplicateRule: function() {
        MODx.Ajax.request({
            url: MaxCDN.config.connectorUrl
            ,params: {
                action: 'mgr/rules/duplicate'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
    ,removeRule: function() {
        var id = this.menu.record.id;
        MODx.msg.confirm({
            title: _('mcdn.remove_rule')
            ,text: _('mcdn.remove_rule.confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/rules/remove'
                ,id: id
            },
            listeners: {
                success: {fn: function(r) {
                    this.refresh();
                },scope: this}
                ,scope: this
            }
        });
    }
    ,getMenu: function() {
        var m = [];

        m.push({
            text: _('mcdn.update_rule')
            ,handler: this.updateRule
            ,scope: this
        },'-',{
            text: _('mcdn.duplicate_rule')
            ,handler: this.duplicateRule
            ,scope: this
        },'-',{
            text: _('mcdn.remove_rule')
            ,handler: this.removeRule
            ,scope: this
        });
        return m;
    }

});
Ext.reg('mcdn-grid-rules',MaxCDN.grid.Rules);
