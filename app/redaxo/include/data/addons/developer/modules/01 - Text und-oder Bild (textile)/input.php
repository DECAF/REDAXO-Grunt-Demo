<?php
if(OOAddon::isAvailable('textile'))
{
?>

<strong>Fliesstext</strong>:<br />
<textarea name="VALUE[1]" cols="80" rows="10" class="inp100">REX_HTML_VALUE[1]</textarea>
<br /><br />

<strong>Artikelfoto</strong>:<br />
REX_MEDIA_BUTTON[1]
<?php
if ("REX_FILE[1]" != "") {
        echo "<br /><strong>Vorschau</strong>:<br />";
    echo "<img src=".$REX['HTDOCS_PATH']."/files/REX_FILE[1]><br />";
}
?>

<br />
<strong>Title des Fotos</strong>:<br />
<input type="text" name="VALUE[2]" value="REX_VALUE[2]" size="80" class="inp100" />
<br /><br />

<strong>Ausrichtung des Artikelfotos</strong>:<br />
<select name="VALUE[9]" class="inp100">
    <option value='l' <?php if ("REX_VALUE[9]" == 'l') echo 'selected'; ?>>links vom Text</option>
</select><br />
<br />
<br />

<?php
rex_a79_help_overview(); 

}
else
{
  echo rex_warning('Dieses Modul benötigt das "textile" Addon!');
}

?>