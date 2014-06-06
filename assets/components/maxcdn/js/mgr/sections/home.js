Ext.onReady(function() {
    MODx.load({ xtype: 'mcdn-page-home', renderTo: 'mcdn-wrapper-div'});
});
 
MaxCDN.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'mcdn-page-home'
        ,cls: 'container form-with-labels'
        ,layout: 'form'
        ,border: false
        ,components: [{
            xtype: 'panel'
            ,html: '<h2>'+_('mcdn.desc')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'form'
            ,id: 'mcdn-formpanel-home'
            ,border: false
            ,items: [{
                xtype: 'modx-tabs'
                ,id: 'mcdn-tabs'
                ,width: '98%'
                ,padding: 10
                ,border: true
                ,deferredRender: false
                ,defaults: {
                    border: false
                    ,autoHeight: true
                    ,defaults: {
                        border: false
                    }
                }
                ,items: [{
                    title: _('mcdn.reporting')
                    ,items: [{
                        html: '<h2 class="mcdn-logo"><img src=" ' + MaxCDN.config.assetsUrl + 'images/maxcdn-logo.png" /></h2>' +
                            '<div class="mcdn-top-stat mcdn-top-stat-last">' +
                            '<p class="mcdn-top-stat-title">' + _('mcdn.reporting_mb_transferred') + '</p>' +
                            '<p class="mcdn-top-stat-figure" id="mcdn-mb-transferred"></p>' +
                            '</div>' +
                            '<div class="mcdn-top-stat">' +
                            '<p class="mcdn-top-stat-title">' + _('mcdn.reporting_non_cache_hits') + '</p>' +
                            '<p class="mcdn-top-stat-figure" id="mcdn-non-cache-hits"></p>' +
                            '</div>' +
                            '<div class="mcdn-top-stat">' +
                            '<p class="mcdn-top-stat-title"> ' + _('mcdn.reporting_cache_hits') + '</p>' +
                            '<p class="mcdn-top-stat-figure" id="mcdn-cache-hits"></p>' +
                            '</div>' +
                            '<div id="mcdn-chart-line-daily"></div>' +
                            '<div id="mcdn-chart-bar-transfer"></div>' +
                            '<div id="mcdn-chart-geo-nodes"></div>' +
                            '<div id="mcdn-chart-pie-ratio"></div>' +
                            '<div class="mcdn-clear"></div><br />'
                    }]
                },{
                    title: _('mcdn.rules')
                    ,items: [{
                        xtype: 'mcdn-grid-rules'
                        ,preventRender: true
                    }]
                },{
                    title: _('mcdn.purge')
                    ,items: this.getPurgeFields(config)
                }]
                ,stateful: true
                ,stateId: 'mcdn-page-home'
                ,stateEvents: ['tabchange']
                ,getState: function() {
                    return {
                        activeTab:this.items.indexOf(this.getActiveTab())
                    };
                }
                ,listeners: {
                    'tabchange': function(tp, t) {
                        var idx = tp.items.indexOf(t);
                        if (idx == 0) {
                            refreshReporting();
                        }
                    }
                }
            }]
        }]
    });
    MaxCDN.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(MaxCDN.page.Home,MODx.Component,{
    getPurgeFields: function(config) {
        config.id = config.id || Ext.id();
        var s = [{
            layout:'form'
            ,border: false
            ,anchor: '100%'
            ,defaults: {
                labelSeparator: ''
                ,labelAlign: 'top'
                ,border: false
                ,layout: 'form'
                ,msgTarget: 'under'
            }
            ,items:[{
                defaults: {
                    border: false
                    ,msgTarget: 'under'
                }
                ,items: [{
                    xtype: 'xcheckbox'
                    ,boxLabel: _('mcdn.purge_all')
                    ,hideLabel: true
                    ,id: config.id + 'mcdn-purge-all'
                    ,name: 'purge_all'
                    ,value: 1
                    ,checked: false
                    ,handler: function(o,v) {
                        if (v == true) {
                            Ext.getCmp(config.id + 'mcdn-purge-files').disable().setValue('');
                        } else {
                            Ext.getCmp(config.id + 'mcdn-purge-files').enable();
                        }
                    }
                },{
                    xtype: 'textarea'
                    ,fieldLabel: _('mcdn.purge_files')
                    ,id: config.id + 'mcdn-purge-files'
                    ,name: 'purge_files'
                    ,anchor: '100%'
                    ,width: '100%'
                    ,height: 200
                },{
                    html: '<p><i>' + _('mcdn.purge_files_desc') + '</i></p>'
                }]
            }]
            ,buttonAlign: 'center'
            ,buttons: [{
                xtype: 'button'
                ,text: _('mcdn.purge')
                ,scope: this
                ,handler: this.purge
            }]
        }];
        return s;
    }

    ,purge: function() {
        Ext.Ajax.request({
            url: MaxCDN.config.connectorUrl
            ,params: {
                action: 'mgr/files/purge'
                ,purge_all: Ext.getCmp(this.config.id + 'mcdn-purge-all').getValue()
                ,purge_files: Ext.getCmp(this.config.id + 'mcdn-purge-files').getValue()
            }
            ,scope: this
            ,success: function(r) {
                var response = Ext.decode(r.responseText);
                MODx.msg.alert(_('mcdn.purge'), response.message);

                Ext.getCmp(this.config.id + 'mcdn-purge-all').setValue(false);
                Ext.getCmp(this.config.id + 'mcdn-purge-files').setValue('');
            }
        });
    }

});
Ext.reg('mcdn-page-home', MaxCDN.page.Home);