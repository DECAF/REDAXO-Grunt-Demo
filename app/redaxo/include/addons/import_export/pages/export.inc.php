<?php

/**
 *
 * @package redaxo4
 * @version svn:$Id$
 */

// Für größere Exports den Speicher für PHP erhöhen.
if (rex_ini_get('memory_limit') < 67108864) {
    @ini_set('memory_limit', '64M');
}

// ------- Addon Includes
include_once $REX['INCLUDE_PATH'] . '/addons/import_export/classes/class.tar.inc.php';
include_once $REX['INCLUDE_PATH'] . '/addons/import_export/classes/class.rex_tar.inc.php';
include_once $REX['INCLUDE_PATH'] . '/addons/import_export/functions/function_import_export.inc.php';
include_once $REX['INCLUDE_PATH'] . '/addons/import_export/functions/function_folder.inc.php';
include_once $REX['INCLUDE_PATH'] . '/addons/import_export/functions/function_import_folder.inc.php';
include_once $REX['INCLUDE_PATH'] . '/addons/import_export/functions/function_string.inc.php';

$info = '';
$warning = '';

// ------------------------------ Requestvars
$function       = rex_request('function', 'string');
$impname        = rex_request('impname', 'string');
$exportfilename = rex_post('exportfilename', 'string');
$exporttype     = rex_post('exporttype', 'string');
$exportdl       = rex_post('exportdl', 'boolean');
$EXPTABLES      = rex_post('EXPTABLES', 'array');
$EXPDIR         = rex_post('EXPDIR', 'array');

if ($impname != '') {
    $impname = str_replace('/', '', $impname);

    if ($function == 'dbimport' && substr($impname, -4, 4) != '.sql') {
        $impname = '';
    } elseif ($function == 'fileimport' && substr($impname, -7, 7) != '.tar.gz') {
        $impname = '';
    }
}

if ($exportfilename == '') {
    $server = preg_replace('@^https?://|/.*|[^\w.-]@', '', $REX['SERVER']);
    $exportfilename = strtolower($server) . '_rex' . $REX['VERSION'] . $REX['SUBVERSION'] . $REX['MINORVERSION'] . '_' . date('Ymd_Hi');
}


if ($function == 'export') {
    // ------------------------------ FUNC EXPORT

    $exportfilename = strtolower($exportfilename);
    $exportfilename = stripslashes($exportfilename);
    $filename       = preg_replace('@[^\.a-z0-9_\-]@', '', $exportfilename);

    // ---- multiple extension check
    foreach ($REX['MEDIAPOOL']['BLOCKED_EXTENSIONS'] as $ext) {
        $filename = str_replace($ext, '', $filename);
    }

    if ($filename != $exportfilename) {
        $info = $I18N->msg('im_export_filename_updated');
        $exportfilename = $filename;
    } else {
        $content     = '';
        $hasContent  = false;
        $header      = '';
        $ext         = $exporttype == 'sql' ? '.sql' : '.tar.gz';
        $export_path = getImportDir() . '/';
        if (!is_dir($export_path)) {
            rex_dir::copy(
                rex_path::addon('import_export', 'backup'),
                rex_path::addonData('import_export', 'backups')
            );
        }

        if (file_exists($export_path . $filename . $ext)) {
            $i = 1;
            while (file_exists($export_path . $filename . '_' . $i . $ext)) {
                $i++;
            }
            $filename = $filename . '_' . $i;
        }

        if ($exporttype == 'sql') {
            // ------------------------------ FUNC EXPORT SQL
            $header = 'plain/text';

            $hasContent = rex_a1_export_db($export_path . $filename . $ext, $EXPTABLES);
            // ------------------------------ /FUNC EXPORT SQL
        } elseif ($exporttype == 'files') {
            // ------------------------------ FUNC EXPORT FILES
            $header = 'tar/gzip';

            if (empty($EXPDIR)) {
                $warning = $I18N->msg('im_export_please_choose_folder');
            } else {
                $content    = rex_a1_export_files($EXPDIR);
                $hasContent = rex_put_file_contents($export_path . $filename . $ext, $content);
            }
            // ------------------------------ /FUNC EXPORT FILES
        }

        if ($hasContent) {
            if ($exportdl) {
                while (ob_get_level()) {
                    ob_end_clean();
                }
                $filename = $filename . $ext;
                header("Content-type: $header");
                header("Content-Disposition: attachment; filename=$filename");
                readfile($export_path . $filename);
                unlink($export_path . $filename);
                exit;
            } else {
                $info = $I18N->msg('im_export_file_generated_in') . ' ' . strtr($filename . $ext, '\\', '/');
            }
        } else {
            $warning = $I18N->msg('im_export_file_could_not_be_generated') . ' ' . $I18N->msg('im_export_check_rights_in_directory') . ' ' . $export_path;
        }
    }
}

if ($info != '') {
    echo rex_info($info);
}
if ($warning != '') {
    echo rex_warning($warning);
}

?>

<div class="rex-addon-output">

        <h3 class="rex-hl2"><?php echo $I18N->msg('im_export_export'); ?></h3>

        <div class="rex-addon-content">
            <p class="rex-tx1"><?php echo $I18N->msg('im_export_intro_export') ?></p>
        </div>

            <div class="rex-form" id="rex-form-export">
            <form action="index.php" enctype="multipart/form-data" method="post" >
                <fieldset class="rex-form-col-1">
                    <legend><?php echo $I18N->msg('im_export_select'); ?></legend>

                    <div class="rex-form-wrapper">
                        <input type="hidden" name="page" value="import_export" />
                        <input type="hidden" name="function" value="export" />
<?php
$checkedsql = '';
$checkedfiles = '';

if ($exporttype == 'files') {
    $checkedfiles = ' checked="checked"';
} else {
    $checkedsql = ' checked="checked"';
}
?>
                        <div class="rex-form-row">
                            <p class="rex-form-radio rex-form-label-right">
                                <input class="rex-form-radio" type="radio" id="exporttype_sql" name="exporttype" value="sql"<?php echo $checkedsql ?> />
                                <label for="exporttype_sql"><?php echo $I18N->msg('im_export_database_export'); ?></label>
                            </p>

                            <p class="rex-form-col-a rex-form-select">
                                <label for="export_tables"><?php echo $I18N->msg('im_export_choose_tables'); ?></label>
<?php
    $tableSelect = new rex_select();
    $tableSelect->setMultiple();
    $tableSelect->setName('EXPTABLES[]');
    $tableSelect->setId('export_tables');
    $tableSelect->setSize('8');
    $tables = rex_sql::showTables();
    foreach ($tables as $table) {
        $tableSelect->addOption($table, $table);
        if ($table != $REX['TABLE_PREFIX'] . 'user' && 0 === strpos($table, $REX['TABLE_PREFIX']) && 0 !== strpos($table, $REX['TABLE_PREFIX'] . $REX['TEMP_PREFIX'])) {
            $tableSelect->setSelected($table);
        }
    }
    $tableSelect->show();
?>
                            </p>
                        </div>

                        <div class="rex-form-row rex-form-element-v2">
                            <p class="rex-form-radio rex-form-label-right">
                                <input class="rex-form-radio" type="radio" id="exporttype_files" name="exporttype" value="files"<?php echo $checkedfiles ?> />
                                <label for="exporttype_files"><?php echo $I18N->msg('im_export_file_export'); ?></label>
                            </p>

                            <div class="rex-form-checkboxes">
                                <div class="rex-form-checkboxes-wrapper">
<?php
    $dir = $REX['INCLUDE_PATH'] . '/../../';
    $folders = readSubFolders($dir);

    foreach ($folders as $file) {
        if ($file == 'redaxo') {
            continue;
        }

        $checked = '';
        if (array_key_exists($file, $EXPDIR) !== false) {
            $checked = ' checked="checked"';
        }

        echo '<p class="rex-form-checkbox rex-form-label-right">
                        <input class="rex-form-checkbox" type="checkbox" onchange="checkInput(\'exporttype_files\');" id="EXPDIR_' . $file . '" name="EXPDIR[' . $file . ']" value="true"' . $checked . ' />
                        <label for="EXPDIR_' . $file . '">' . $file . '</label>
                    </p>
        ';
    }
?>
        </div><!-- END rex-form-checkboxes-wrapper -->
    </div><!-- END rex-form-checkboxes -->
</div><!-- END rex-form-row -->
<?php
$checked0 = '';
$checked1 = '';

if ($exportdl) {
    $checked1 = ' checked="checked"';
} else {
    $checked0 = ' checked="checked"';
}
?>
                </div>
                </fieldset>
                <fieldset>
                    <legend><?php echo $I18N->msg('im_export_select_location'); ?></legend>
                    <div class="rex-form-wrapper">

                        <div class="rex-form-row">
                            <p class="rex-form-radio rex-form-label-right">
                                <input class="rex-form-radio" type="radio" id="exportdl_server" name="exportdl" value="0"<?php echo $checked0; ?> />
                                <label for="exportdl_server"><?php echo $I18N->msg('im_export_save_on_server'); ?></label>
                            </p>
                        </div>
                        <div class="rex-form-row">
                            <p class="rex-form-radio rex-form-label-right">
                                <input class="rex-form-radio" type="radio" id="exportdl_download" name="exportdl" value="1"<?php echo $checked1; ?> />
                                <label for="exportdl_download"><?php echo $I18N->msg('im_export_download_as_file'); ?></label>
                            </p>
                        </div>

                </div>
                </fieldset>
                <fieldset>
                    <legend><?php echo $I18N->msg('im_export_select_filename'); ?></legend>
                    <div class="rex-form-wrapper">

                        <div class="rex-form-row">
                            <p class="rex-form-text">
                                <label for="exportfilename"><?php echo $I18N->msg('im_export_filename'); ?></label>
                                <input class="rex-form-text" type="text" id="exportfilename" name="exportfilename" value="<?php echo $exportfilename; ?>" />
                            </p>
                        </div>
                        <div class="rex-form-row">
                            <p class="rex-form-submit">
                                <input class="rex-form-submit" type="submit" value="<?php echo $I18N->msg('im_export_db_export'); ?>" />
                            </p>
                        </div>
                    </div>
                </fieldset>
            </form>
            </div><!-- END rex-form -->
    <div class="rex-clearer"></div>
</div><!-- END rex-area -->
