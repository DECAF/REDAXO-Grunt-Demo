<?php

if($REX['REDAXO']!=1 && 'REX_ARTICLE_ID' != 'REX_LINK_ID[1]')
{
  if ( 'REX_LINK_ID[1]' != 0) 
  {
   rex_redirect('REX_LINK_ID[1]', $REX['CUR_CLANG']);
  }
}else
{
  echo "Weiterleitung zu <a href='index.php?page=content&article_id=REX_LINK_ID[1]&mode=edit'>Artikel           REX_LINK[1]</a>";
}

?>