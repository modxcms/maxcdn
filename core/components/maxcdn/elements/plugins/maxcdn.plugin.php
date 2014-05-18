<?php
$event = $modx->event->name;
switch ($event) {
    case 'OnDocFormPrerender':
        $path = $modx->getOption('mcdn.core_path', null, $modx->getOption('core_path') . 'components/maxcdn/');
        $maxcdn = $modx->getService('maxcdn','MaxCDN', $path.'model/maxcdn/');

        if ($maxcdn->isDisabled()) {
            break;
        }

        $modx->lexicon->load('maxcdn:default');
        $urlParameter = $modx->getOption('mcdn.url_preview_param', null, 'guid');

        $modx->regClientStartupScript('
				<script type="text/javascript">
						function generateUUID() {
							var d = new Date().getTime();
							var uuid = "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function(c) {
								var r = (d + Math.random()*16)%16 | 0;
								d = Math.floor(d/16);
								return (c=="x" ? r : (r&0x7|0x8)).toString(16);
							});
							return uuid;
						}

						Ext.override(MODx.page.UpdateResource, {
							preview: function() {
								var separator = this.config.preview_url.indexOf("?") == -1 ? "?" : "&";
								window.open(this.config.preview_url + separator + "' . $urlParameter . '=" + generateUUID());
							}
						});
						
						Ext.onReady(function() {
							var modab = Ext.getCmp("modx-action-buttons");
							var panel = Ext.getCmp("modx-page-update-resource");
							var btns = panel.getButtons(panel.config);
							btns.unshift("-");
							btns.unshift({
								xtype: "button"
								,process: "update"
								,text: "' . $modx->lexicon('mcdn.save_and_purge') . '"
								,method: "remote"
								,handler: function() {
									if (!Ext.getCmp("modx-update-resource-purgecdn")) {
										var tab = Ext.getCmp("modx-panel-resource");
										tab.add({
											xtype: "hidden"
											,name: "purge_cdn"
											,id: "modx-update-resource-purgecdn"
											,value: 1
										});
										tab.doLayout();
									}
									modab.handleClick(Ext.getCmp("modx-abtn-saveandpurge"));
								}
								,id: "modx-abtn-saveandpurge"
								,checkDirty: true
							});
							panel.config.buttons = btns;
							modab.removeAll();
							modab.checkDirtyBtns = [];
							var length = btns.length, btn = null;
							for (var i = 0; i < length; i++) {
  								btn = btns[i];
  								modab.add(btn);
  							}
							modab.doLayout();
						});
				</script>
		');
        break;
    case 'OnDocFormSave':
        if (isset($_POST['purge_cdn'])) {
            $path = $modx->getOption('mcdn.core_path', null, $modx->getOption('core_path') . 'components/maxcdn/');
            $maxcdn = $modx->getService('maxcdn','MaxCDN', $path.'model/maxcdn/');

            if ($maxcdn->isDisabled()) {
                break;
            }

            if($maxcdn->authenticate()) {
                $response = $maxcdn->purgeFile($modx->makeUrl($_POST['id'], '', '', -1));
                $response = $modx->fromJSON($response);
                if ($response['code'] !== '200') {
                    $modx->log(modX::LOG_LEVEL_ERROR, $response['error']['type']. ': ' .$response['error']['message']);
                }
            }
        }
        break;
    default:
        break;
}
return;