<?php

$cat = OOCategory :: getCategoryById($this->getValue('category_id'));
$cats = $cat->getChildren();

$itemsPerSide = "REX_VALUE[1]";
$wordsPerArticle = "REX_VALUE[2]";

if (is_array($cats))
{
  $i = 0;
  foreach ($cats as $cat)
  {
    $i += 1;
    if ($i <= $itemsPerSide)
    {
      if ($cat->isOnline())
      {

        $catId = $cat->getId();
        $catName = $cat->getName();
        $article = $cat->getArticles();

        if (is_array($article))
        {
          foreach ($article as $var)
          {
            $articleId = $var->getId();
            $articleName = $var->getName();
            $art = new rex_article($articleId);
            $articleContent = $art->getArticle();

            $articleContent = trim($articleContent);
            $articleContent = str_replace('</p>', ' </p>', $articleContent);
            $articleContent = str_replace('<br />', ' <br />', $articleContent);

            $articlePPath = $REX['MEDIAFOLDER'] . 'files/' . $var->getValue('file');

            $output = '';
            $words = explode(' ', $articleContent);
            $wordsCount = count($words);

            if ($wordsCount < $wordsPerArticle)
              $wEnd = $wordsCount;
            else
              $wEnd = $wordsPerArticle;

            for ($w = 0; $w < $wEnd; $w++)
            {
              $output .= $words[$w] . ' ';
            }

            $output = trim($output);

            $isCloseParagraph = substr($output, -4);
            $isCloseDiv = substr($output, -10);
            $link = '<a href="' . rex_getUrl($articleId) . '" class="more"> ...mehr</a>';
            $newString = $link . '</p>';

            if ($isCloseParagraph == '</p>')
            {
              $output = substr_replace($output, $newString, -4);
            }
            elseif ($isCloseDiv == '</p></div>')
            {
              $output = substr_replace($output, $newString.'</div>', -10);
            }
            else
            {
              $output .= $newString;
            }

            // print '<h2>'.$articleName.'</h2>';
            print '<div class="txt-img">' . $output . '</div>';

          }
        }
      }
    }
  }
}
?>