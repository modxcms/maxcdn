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
                            '<div class="mcdn-clear"></div>' +
                            '<div id="mcdn-table-popularfiles"></div>' +
                            '<div class="mcdn-clear"></div><br />'
                    }]
                },{
                    title: _('mcdn.rules')
                    ,items: [{
                        html: '<p>'+_('mcdn.desc')+'</p><br />'
                    },{
                        xtype: 'mcdn-grid-rules'
                        ,preventRender: true
                    }]
                }]
                ,stateful: true
                ,stateId: 'mcdn-page-home'
                ,stateEvents: ['tabchange']
                ,getState: function() {
                    return {
                        activeTab:this.items.indexOf(this.getActiveTab())
                    };
                }
            }]
        }]
    });
    MaxCDN.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(MaxCDN.page.Home,MODx.Component,{

});
Ext.reg('mcdn-page-home', MaxCDN.page.Home);