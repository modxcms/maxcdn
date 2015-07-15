MaxCDN.combo.CDNURLs = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        xtype: 'superboxselect'
        ,mode: 'remote'
        ,triggerAction: 'all'
        ,extraItemCls: 'x-tag'
        ,expandBtnCls: 'x-form-trigger'
        ,clearBtnCls: 'x-form-trigger'
        ,fields: ['cdn_url']
        ,displayField: 'cdn_url'
        ,valueField: 'cdn_url'
        ,store: new Ext.data.JsonStore({
                 id:'cdn_url'
                ,url: MaxCDN.config.connectorUrl
                ,root:'results'
                ,fields: ['cdn_url']
                ,baseParams: {
                    action: 'mgr/combos/cdn/getlist'
                }
        })
        ,pageSize: 15
        ,hiddenName: 'cdn_url[]'
    });
    MaxCDN.combo.CDNURLs.superclass.constructor.call(this,config);
};
Ext.extend(MaxCDN.combo.CDNURLs,Ext.ux.form.SuperBoxSelect);
Ext.reg('mcdn-combo-cdnurls',MaxCDN.combo.CDNURLs);

MaxCDN.combo.Scheme = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.JsonStore({
            fields: ['name','scheme']
            ,data: [
                {"name": _('mcdn.http'),"scheme": 'http://'}
                ,{"name": _('mcdn.https'),"scheme": 'https://'}
                ,{"name": _('mcdn.schemeless'),"scheme": '//'}
            ]
        })
        ,displayField: 'name'
        ,valueField: 'scheme'
        ,hiddenName: config.name || 'scheme'
        ,mode: 'local'
        ,triggerAction: 'all'
        ,editable: false
        ,selectOnFocus: false
        ,preventRender: true
        ,forceSelection: true
        ,enableKeyEvents: true
    });
    MaxCDN.combo.Scheme.superclass.constructor.call(this,config);
};
Ext.extend(MaxCDN.combo.Scheme,Ext.form.ComboBox);
Ext.reg('mcdn-combo-scheme',MaxCDN.combo.Scheme);