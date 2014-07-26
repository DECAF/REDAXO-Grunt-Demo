<?php
/**
 * image_manager Addon
 *
 * @author office[at]vscope[dot]at Wolfgang Hutteger
 * @author <a href="http://www.vscope.at">www.vscope.at</a>
 *
 * @author markus[dot]staab[at]redaxo[dot]de Markus Staab
 *
 *
 * @package redaxo4
 * @version svn:$Id$
 */

$error = '';

if (!extension_loaded('gd')) {
    $error = 'GD-LIB-extension not available! See <a href="http://www.php.net/gd">http://www.php.net/gd</a>';
}

if ($error == '') {
    $file = $REX['GENERATED_PATH'] . '/files';

    if (($state = rex_is_writable($file)) !== true) {
        $error = $state;
    }
}

if ($error != '') {
    $REX['ADDON']['installmsg']['image_manager'] = $error;
} else {
    $REX['ADDON']['install']['image_manager'] = true;
}
