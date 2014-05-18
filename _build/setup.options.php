<?php
$output = '';
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        $output = '
            <label for="mcdn_alias">Alias:</label>
            <input type="text" name="alias" id="mcdn_alias" width="300" value="" />
            <br /><br />

            <label for="mcdn_consumer_key">Consumer Key:</label>
            <input type="text" name="consumer_key" id="mcdn_consumer_key" width="300" value="" />
            <br /><br />

            <label for="mcdn_consumer_secret">Consumer Secret:</label>
            <input type="text" name="consumer_secret" id="mcdn_consumer_secret" width="300" value="" />
            <br /><br />

            <label for="mcdn_zone_id">Zone ID:</label>
            <input type="text" name="zone_id" id="mcdn_zone_id" width="300" value="" />
            <br /><br />

            <label for="mcdn_url_preview_param">URL Preview Parameter:</label>
            <input type="text" name="url_preview_param" id="mcdn_url_preview_param" width="300" value="" />
            <br /><br />

            <label for="mcdn_enabled">Enable MaxCDN:</label>
            <input type="radio" name="enabled" value="1" checked="checked">Yes<br />
            <input type="radio" name="enabled" value="0">No

        ';

        break;
    case xPDOTransport::ACTION_UPGRADE:
        break;
    case xPDOTransport::ACTION_UNINSTALL:
        break;
}

return $output;