<?php
// Import Folder Functions
function getImportDir()
{
    return rex_path::addonData('import_export', 'backups');
}

// PATCH http://www.redaxo.org/de/forum/bugs-f31/sortierung-nach-datum-broken-t16162.html
function readImportFolder($fileprefix)
{
  $folder = '';
  $folder = readFilteredFolder( getImportDir(), $fileprefix);
  usort($folder, 'compareFiles');

  return $folder;
}

function compareFiles($file_a, $file_b)
{
    $dir = getImportDir();

    $time_a = filemtime( $dir . '/' . $file_a);
    $time_b = filemtime( $dir . '/' . $file_b);

    if ( $time_a == $time_b) {
        return 0;
    }

    return ( $time_a > $time_b) ? -1 : 1;
}
