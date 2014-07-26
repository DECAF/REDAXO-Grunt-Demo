<?php

$cat = OOCategory::getCategoryById($this->getValue("category_id"));
$article = $cat->getArticles();

if (is_array($article)) 
{
  foreach ($article as $var) 
  {
    $articleId = $var->getId();
    $articleName = $var->getName();
    $articleDescription = $var->getDescription();
    if (!$var->isStartpage()) 
    {
      echo '<a href="'.rex_getUrl($articleId).'" class="faq">'.$articleName.'</a><br />';
    }
  }
}

?>