<!DOCTYPE HTML>
<!--[if lt IE 8]>     <html class="no-js lt-ie8" lang="en"><![endif]-->
<!--[if IE 9]>        <html class="no-js    ie9" lang="en"><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js"        lang="en"><!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title>Bootstrap REDAXO-Grunt.</title>

    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="all">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php
require_once(dirname(__FILE__).'/../../static/php/dcf.html.class.php');
DCF_HTML::setPathPrefix('../');
DCF_HTML::setLiveReload( TRUE );
// DCF_HTML::setCssFiles(array( 'site1.css', 'site2.css'));
echo DCF_HTML::composeHead();
?>

    <!--[if lt IE 9]>
    <script src="static/js/src/vendor/html5shiv.js"></script>
    <script src="static/js/src/vendor/respond.min.js"></script>
    <![endif]-->
</head>
<body>
