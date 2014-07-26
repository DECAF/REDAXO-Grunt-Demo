<?php

$page = 'xform';

include $REX['INCLUDE_PATH'] . '/layout/top.php';

$subpage = rex_request('subpage', 'string');

function deep_in_array($value, $array, $case_insensitive = false)
{
     foreach ($array as $item) {
         if (is_array($item)) {
             $ret = deep_in_array($value, $item, $case_insensitive);
         } else {
             $ret = ($case_insensitive) ? strtolower($item) == $value : $item == $value;
         } if ($ret) {
             return $ret;
         }
     }
     return false;
}

if (!deep_in_array($subpage, $REX['ADDON'][$page]['SUBPAGES'])) {
    $subpage = '';
}

if ($subpage != '') {
    switch ($subpage) {
        case 'description':
            include $REX['INCLUDE_PATH'] . "/addons/$page/pages/$subpage.inc.php";
            break;
        default:
            include $REX['INCLUDE_PATH'] . "/addons/$page/plugins/$subpage/pages/index.inc.php";
            break;
    }

} else {

    rex_title('XForm', $REX['ADDON'][$page]['SUBPAGES']);

    echo '<div class="rex-addon-output">';
    echo '<h2 class="rex-hl2">XFORM - ' . $I18N->msg('xform_overview') . '</h2>';

    echo '<div class="rex-addon-content"><ul>';
    foreach ($REX['ADDON'][$page]['SUBPAGES'] as $sp) {
        echo '<li><a href="index.php?page=' . $page . '&amp;subpage=' . $sp[0] . '">' . $sp[1] . '</a></li>';
    }
    echo '</ul></div>';
    echo '</div>';
}

include $REX['INCLUDE_PATH'] . '/layout/bottom.php';
