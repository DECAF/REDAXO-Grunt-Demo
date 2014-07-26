<?php

/**
 * Addonlist
 * @package redaxo4
 * @version svn:$Id$
 */

// ----------------- addons
unset($REX['ADDON']);
$REX['ADDON'] = array();

// ----------------- DONT EDIT BELOW THIS
// --- DYN
$REX['ADDON']['install']['be_dashboard'] = '0';
$REX['ADDON']['status']['be_dashboard'] = '0';

$REX['ADDON']['install']['be_search'] = '1';
$REX['ADDON']['status']['be_search'] = '1';

$REX['ADDON']['install']['be_style'] = '1';
$REX['ADDON']['status']['be_style'] = '1';

$REX['ADDON']['install']['cronjob'] = '0';
$REX['ADDON']['status']['cronjob'] = '0';

$REX['ADDON']['install']['developer'] = '1';
$REX['ADDON']['status']['developer'] = '1';

$REX['ADDON']['install']['image_manager'] = '1';
$REX['ADDON']['status']['image_manager'] = '1';

$REX['ADDON']['install']['import_export'] = '1';
$REX['ADDON']['status']['import_export'] = '1';

$REX['ADDON']['install']['install'] = '1';
$REX['ADDON']['status']['install'] = '1';

$REX['ADDON']['install']['metainfo'] = '1';
$REX['ADDON']['status']['metainfo'] = '1';

$REX['ADDON']['install']['phpmailer'] = '0';
$REX['ADDON']['status']['phpmailer'] = '0';

$REX['ADDON']['install']['textile'] = '1';
$REX['ADDON']['status']['textile'] = '1';

$REX['ADDON']['install']['version'] = '0';
$REX['ADDON']['status']['version'] = '0';

$REX['ADDON']['install']['xform'] = '0';
$REX['ADDON']['status']['xform'] = '0';
// --- /DYN
// ----------------- /DONT EDIT BELOW THIS

require $REX['INCLUDE_PATH'] . '/plugins.inc.php';

foreach (OOAddon::getAvailableAddons() as $addonName) {
    $addonConfig = rex_addons_folder($addonName) . 'config.inc.php';
    if (file_exists($addonConfig)) {
        require $addonConfig;
    }

    foreach (OOPlugin::getAvailablePlugins($addonName) as $pluginName) {
        $pluginConfig = rex_plugins_folder($addonName, $pluginName) . 'config.inc.php';
        if (file_exists($pluginConfig)) {
            rex_pluginManager::addon2plugin($addonName, $pluginName, $pluginConfig);
        }
    }
}

// ----- all addons configs included
rex_register_extension_point('ADDONS_INCLUDED');
