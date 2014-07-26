<?php

if(OOAddon::isAvailable('textile'))
{
?>

<strong>Fliesstext</strong>:<br />
<textarea name="VALUE[1]" cols="80" rows="10" class="inp100">REX_HTML_VALUE[1]</textarea>
<br />

<?php

rex_a79_help_overview(); 

}else
{
  echo rex_warning('Dieses Modul benötigt das "textile" Addon!');
}

?>