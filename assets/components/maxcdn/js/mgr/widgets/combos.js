MaxCDN.combo.CDNURLs = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: MaxCDN.config.connectorUrl,
        baseParams: {
            action: 'mgr/combos/cdn/getlist',
            combo: true
        },
        fields: ['cdn_url'],
        hiddenName: config.name || 'cdn_url',
        pageSize: 15,
        valueField: 'cdn_url',
        displayField: 'cdn_url'
    });
    MaxCDN.combo.CDNURLs.superclass.constructor.call(this,config);
};
Ext.extend(MaxCDN.combo.CDNURLs,MODx.combo.ComboBox);
Ext.reg('mcdn-combo-cdnurls',MaxCDN.combo.CDNURLs);