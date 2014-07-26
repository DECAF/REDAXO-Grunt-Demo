<?php

if (!isset($REX['MODULE_BILDGALERIE_ID'])) $REX['MODULE_BILDGALERIE_ID'] = 0;
else $REX['MODULE_BILDGALERIE_ID']++;

if ($REX['MODULE_BILDGALERIE_ID']==0)
{
?>
<script type="text/javascript">
var GB_ROOT_DIR = "files/";
</script>
<script type="text/javascript" src="files/ajs.js"></script>
<script type="text/javascript" src="files/ajs_fx.js"></script>
<script type="text/javascript" src="files/gb_scripts.js"></script>
<link href="files/gb_styles.css" rel="stylesheet" type="text/css" />

<?php
}
?>

<div class="galerie">

<?php

$pics_string = "REX_MEDIALIST[1]";
if($pics_string != '')
{
  $i = 1;
  $pics = explode(',',$pics_string);

  foreach($pics as $pic)
  {
    echo '<div class="image">';

    $title = '';
    if ($file = OOMedia::getMediaByFileName($pic)) $title = $file->getTitle();

    echo '<a href="'.$REX['HTDOCS_PATH'].'/files/'.$pic.'" rel="gb_imageset[galerie'.$REX['MODULE_BILDGALERIE_ID'].']"><img src="'.$REX['HTDOCS_PATH'].'index.php?rex_img_type=gallery_overview&rex_img_file='.$pic.'" title="'.$title.'" alt="'.$title.'" /></a>';

    echo '<p>'.$title.'</p>';
    echo '</div>';

    if($i % 2 == 0)
      echo '<div class="clearer"></div>';

    $i++;  
  }
}

?></div>