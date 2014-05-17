<?php
$eventName = $modx->event->name;
switch($eventName) {
    case 'OnWebPagePrerender':
        if (!function_exists('cdnLinkerReplace')) {
            function cdnLinkerReplace($matches) {
                return $matches[1].'http://maxcdn-main.devsite.me/'.$matches[3].'"';
            }

        }

        $regex = '((?:src|href)=")((?:http://[^/\s]+/)|/)?(.*\.(?:jpe?g|png|gif|ttf|otf|svg|woff|xml|js|css))"';
        $modx->resource->_output = preg_replace_callback("#{$regex}#i", 'cdnLinkerReplace', $modx->resource->_output);
        break;
    default:
        break;
}