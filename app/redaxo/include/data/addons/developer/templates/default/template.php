<?php


// ------ DESCRIPTION/KEYWORDS
$OOStartArticle = OOArticle::getArticleById($REX['START_ARTICLE_ID'], $REX['CUR_CLANG']);
$meta_beschreibung = $OOStartArticle->getValue("art_description");
$meta_suchbegriffe = $OOStartArticle->getValue("art_keywords");

if($this->getValue("art_description") != "")
    $meta_beschreibung = $this->getValue("art_description");
    
if($this->getValue("art_keywords") != "")
    $meta_suchbegriffe = $this->getValue("art_keywords");


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php print $REX['SERVERNAME'].' | '.$this->getValue("name"); ?></title>
    <meta name="keywords" content="<?php print htmlspecialchars($meta_suchbegriffe); ?>" />
    <meta name="description" content="<?php print htmlspecialchars($meta_beschreibung); ?>" />

<?php
/*
    <link rel="stylesheet" type="text/css" href="<?php echo $REX['HTDOCS_PATH'] ?>files/main.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo $REX['HTDOCS_PATH'] ?>files/navigation.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo $REX['HTDOCS_PATH'] ?>files/content.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo $REX['HTDOCS_PATH'] ?>files/default.css" media="screen" />
*/
?>

<?php
require_once($REX['FRONTEND_PATH'].'/static/php/dcf.html.class.php');
DCF_HTML::setPathPrefix('../');
echo DCF_HTML::composeHead();
?>
</head>


<body class="mainPage <?php if (DCF_HTML::isDebug()) echo 'DEBUG' ?>">
    <div>
        <a name="top" id="top"></a>
    </div>

    <div id="site-content">
        <div id="column">
            
            <div id="header">
                <div id="logo">
                    <a href="<?php echo $REX['HTDOCS_PATH'] ?>index.php" title="Zur&uuml;ck zur Startseite">REDAXO Demo</a>
                </div>
            </div>
            
            <div id="content">

                <div id="main-content">

                    <div id="nav">
                        REX_TEMPLATE[2]
                        <p class="copy">&copy; by <a href="http://www.redaxo.org">REDAXO</a></p>
                    </div>

                    <div id="main">
                        <div id="main-block">
                            <div id="main-teaser">
                                Slogan: Einfach, flexibel, sinnvoll
                            </div>

                            <div id="main-content-block">
                                REX_TEMPLATE[3]
                                REX_ARTICLE[]
                            </div>
                        </div>
                    </div>
                    <br class="clear" />

                </div>

            </div>

            <div id="footer">
                <p class="floatRight"><a href="http://www.redaxo.org">REDAXO CMS</a> - SIMPLE DEMO | XHTML 1.0 Strict | pictures by <a href="http://www.photocase.com">photocase.com</a></p>
                <br class="clear" />
            </div>

        </div>
    </div>
<div style="display:none;">Eigene Templates sind besser - REDAXO</div>

<?php echo DCF_HTML::composeBody(); ?>

</body>
</html>
