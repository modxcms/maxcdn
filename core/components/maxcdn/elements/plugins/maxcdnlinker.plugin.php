<?php
$eventName = $modx->event->name;
switch($eventName) {
    case 'OnWebPagePrerender':
        $path = $modx->getOption('mcdn.core_path', null, $modx->getOption('core_path') . 'components/maxcdn/');
        $maxcdn = $modx->getService('maxcdn','MaxCDN', $path.'/model/maxcdn/');

        if ($maxcdn->isDisabled(true)) {
            break;
        }``

        $c = $modx->newQuery('mcdnRule');
        $c->where(array(
            'content_type' => $modx->resource->get('content_type')
        ));
        $c->sortby('sortorder', 'ASC');

        $rules = $modx->getIterator('mcdnRule', $c);
        foreach ($rules as $rule) {
            $callback = function($matches) use ($rule) {
                $output = $rule->get('output');
                foreach($matches as $k => $v) {
                    if ($k == 0) continue;
                    $output = str_replace('{match'.$k.'}', $v, $output);
                }
                $output = str_replace('{cdn_url}', $rule->get('cdn_url'), $output);
                return $output;
            };

            $modx->resource->_output = preg_replace_callback($rule->getRegex(), $callback, $modx->resource->_output);
        }
        break;
    default:
        break;
}