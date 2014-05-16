Ext.onReady(function() {
    MODx.load({ xtype: 'mcdn-page-home', renderTo: 'mcdn-wrapper-div'});
});
 
MaxCDN.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'mcdn-page-home',
        cls: 'container form-with-labels',
        layout: 'form',
        border: false,
        components: [{
            xtype: 'panel',
            html: '<h2>'+_('mcdn')+'</h2>',
            border: false,
            cls: 'modx-page-header'
        },{
            xtype: 'form',
            id: 'mcdn-formpanel-home',
            border: false,
            items: [{
                xtype: 'modx-tabs',
                width: '98%',
                border: true,
                deferredRender: false,
                defaults: {
                    border: false,
                    autoHeight: true,
                    defaults: {
                        border: false
                    }
                },
                items: [],
                stateful: true,
                stateId: 'mcdn-page-home',
                stateEvents: ['tabchange'],
                getState: function() {
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