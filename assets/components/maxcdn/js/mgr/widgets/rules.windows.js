MaxCDN.window.Rule = function(config) {
    config = config || {};
    config.id = config.id || Ext.id(),
        Ext.applyIf(config,{
            title: (config.isUpdate) ?
                _('mcdn.update_rule') :
                _('mcdn.add_rule')
            ,autoHeight: true
            ,url: MaxCDN.config.connectorUrl
            ,baseParams: {
                action: (config.isUpdate) ?
                    'mgr/rules/update' :
                    'mgr/rules/create'
            }
            ,width: 750
            ,fields: [{
                xtype: 'hidden',
                name: 'id'
            },{
                layout: 'column',
                items: [{
                    columnWidth: 0.75
                    ,layout: 'form'
                    ,items: [{
                        xtype: 'textfield'
                        ,name: 'name'
                        ,fieldLabel: _('mcdn.name')
                        ,allowBlank: false
                        ,anchor: '100%'
                    },{
                        xtype: 'textarea'
                        ,name: 'description'
                        ,fieldLabel: _('mcdn.description')
                        ,anchor: '100%'
                    },{
                        xtype: 'mcdn-combo-scheme'
                        ,name: 'scheme'
                        ,fieldLabel: _('mcdn.scheme')
                        ,allowBlank: false
                        ,anchor: '50%'
                    },{
                        xtype: 'mcdn-combo-cdnurls'
                        ,name: 'cdn_url'
                        ,fieldLabel: _('mcdn.cdn_url')
                        ,allowBlank: false
                        ,anchor: '100%'
                    }]
                },{
                    columnWidth: 0.25,
                    layout: 'form',
                    items: [{
                        xtype: 'numberfield'
                        ,name: 'sortorder'
                        ,fieldLabel: _('mcdn.sortorder')
                        ,allowBlank: false
                        ,minValue: 0
                        ,maxValue: 9999999999
                        ,anchor: '100%'
                        ,value: 0

                    },{
                        xtype: 'modx-combo-content-type'
                        ,name: 'content_type'
                        ,fieldLabel: _('mcdn.content_type')
                        ,allowBlank: false
                        ,anchor: '100%'
                    },{
                        xtype: 'checkbox'
                        ,name: 'disabled'
                        ,fieldLabel: _('mcdn.disabled')
                        ,anchor: '100%'
                    },{
                        xtype: 'checkbox'
                        ,id: config.id + 'mcdn-checkbox-all-contexts'
                        ,name: 'all_contexts'
                        ,fieldLabel: _('mcdn.all_contexts')
                        ,anchor: '100%'
                        ,itemCls: 'mcdn-all-contexts'
                        ,handler: function(o,v) {
                            if (v == true) {
                                Ext.getCmp(config.id + 'mcdn-combo-context').disable();
                            } else {
                                Ext.getCmp(config.id + 'mcdn-combo-context').enable();
                            }
                        }
                    },{
                        xtype: 'modx-combo-context'
                        ,id: config.id + 'mcdn-combo-context'
                        ,name: 'context'
                        ,fieldLabel: _('mcdn.context')
                        ,anchor: '100%'
                    }]
                }]
            },{
                xtype: 'textarea'
                ,name: 'input'
                ,fieldLabel: _('mcdn.input')
                ,anchor: '100%'
            },{
                xtype: 'textarea'
                ,name: 'output'
                ,fieldLabel: _('mcdn.output')
                ,anchor: '100%'
            }]
            ,keys: [] /*prevent enter in textarea from firing submit */
        });
    MaxCDN.window.Rule.superclass.constructor.call(this,config);
    this.on('beforeshow', this.setup, this);
};
Ext.extend(MaxCDN.window.Rule,MODx.Window, {
    setup: function(w) {
        if (w.config.isUpdate !== true) {
            Ext.getCmp(w.config.id + 'mcdn-checkbox-all-contexts').setValue(true);
            Ext.getCmp(w.config.id + 'mcdn-combo-context').disable();
        } else {
            if (Ext.getCmp(w.config.id + 'mcdn-checkbox-all-contexts').getValue() == true) {
                Ext.getCmp(w.config.id + 'mcdn-combo-context').disable();
            }
        }
    }
});
Ext.reg('mcdn-window-rule',MaxCDN.window.Rule);
