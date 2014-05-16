var MaxCDN = function(config) {
    config = config || {};
    MaxCDN.superclass.constructor.call(this,config);
};
Ext.extend(MaxCDN,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},tabs:{},combo:{},
    config: {
        connector_url: ''
    },
    inVersion: false
});
Ext.reg('maxcdn',MaxCDN);
MaxCDN = new MaxCDN();
