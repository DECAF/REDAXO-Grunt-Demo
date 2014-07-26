<?php

if(OOAddon::isAvailable('textile'))
{
  echo '<div class="team">';

  //  Ausrichtung des Bildes 
  if ("REX_VALUE[9]" == "l") $float = "floatLeft";
  if ("REX_VALUE[9]" == "r") $float = "floatRight";

  //  Wenn Bild eingefuegt wurde, Code schreiben 
  $file = "";
  if ("REX_FILE[1]" != "") $file = '<div class="'.$float.'"><img src="'.$REX['HTDOCS_PATH'].'files/REX_FILE[1]" title="'."REX_VALUE[2]".'" alt="'."REX_VALUE[2]".'" /></div>';

  $textile = '';
  if(REX_IS_VALUE[1])
  {
    $textile = htmlspecialchars_decode('REX_VALUE[1]', ENT_QUOTES);
    $textile = str_replace("<br />","",$textile);
    $textile = rex_a79_textile($textile);
  } 
  print $file.$textile;

  echo '</div>';
}
else
{
  echo rex_warning('Dieses Modul benötigt das "textile" Addon!');
}

?>