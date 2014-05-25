MaxCDN.combo.CDNURLs = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: MaxCDN.config.connectorUrl
        ,baseParams: {
            action: 'mgr/combos/cdn/getlist'
            ,combo: true
        }
        ,fields: ['cdn_url']
        ,hiddenName: config.name || 'cdn_url'
        ,pageSize: 15
        ,valueField: 'cdn_url'
        ,displayField: 'cdn_url'
    });
    MaxCDN.combo.CDNURLs.superclass.constructor.call(this,config);
};
Ext.extend(MaxCDN.combo.CDNURLs,MODx.combo.ComboBox);
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