&Uuml;berschrift:<br />
<input type="text" size="50" name="VALUE[1]" value="REX_VALUE[1]" />
<select name="VALUE[2]" >
<?php
foreach (array("h1","h2","h3","h4","h5","h6") as $value) {
    echo '<option value="'.$value.'" ';
    
    if ( "REX_VALUE[2]"=="$value" ) {
        echo 'selected="selected" ';
    }
    echo '>'.$value.'</option>';
}
?>
</select>