<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>REDAXO-Grunt-Demo | Home</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />

<?php
require_once(dirname(__FILE__).'/../../static/php/dcf.html.class.php');
DCF_HTML::setPathPrefix('../');
DCF_HTML::setLiveReload( TRUE );
echo DCF_HTML::composeHead();
?>

<body class="mainPage <?php if (DCF_HTML::isDebug()) echo 'DEBUG' ?>">

	<div>
		<a name="top" id="top"></a>
	</div>

	<div id="site-content">
		<div id="column">

			<div id="header">
				<div id="logo">
					<a href="./index.php" title="Zur&uuml;ck zur Startseite">REDAXO Demo</a>
				</div>
			</div>

			<div id="content">

				<div id="main-content">

					<div id="nav">

<?php include('_include/navi.inc.php'); ?>

						<p class="copy">&copy; by <a href="http://www.redaxo.org">REDAXO</a></p>
					</div>

					<div id="main">
						<div id="main-block">
							<div id="main-teaser">
								Slogan: Einfach, flexibel, sinnvoll
							</div>

							<div id="main-content-block">

<?php include('_include/breadcrumb.inc.php'); ?>

