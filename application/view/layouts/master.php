<?php 
defined('IS_APP') || die();
?>
<html>

<head>

<title><?php
$cacheRef = '20170622'; // change this to force css and js update in clients

if (isset($title)) {
    echo $title . " - paulodev.com";
} else {
    echo "paulodev.com";
}
?></title>

<!-- CSS ---------------------------------------------------------- -->

<!--  FONT AWESOME -->

<link
	href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
	rel="stylesheet"
	integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
	crossorigin="anonymous">

<!--  FONTS: 
      font-family: 'Inconsolata', monospace;
      font-family: 'Open Sans', sans-serif;
      font-family: 'Raleway', sans-serif;
-->

<link
	href="//fonts.googleapis.com/css?family=Inconsolata|Open+Sans|Raleway"
	rel="stylesheet">

<!--  BOOTSTRAP -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet"
	href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
	integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
	crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet"
	href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
	integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp"
	crossorigin="anonymous">

<!-- Prism (render source code) -->
<link
	href="<?php echo Env::web(); ?>/css/prism.css?<?php echo $cacheRef; ?>"
	rel="stylesheet" />

<!-- Main -->
<link
	href="<?php echo Env::web(); ?>/css/main.css?<?php echo $cacheRef; ?>"
	rel="stylesheet" />

</head>

<style>
body {
	font-family: 'Open Sans', sans-serif;
}
</style>

<body>

	<!-- SITE CONTENTS ---------------------------------------------------- -->

	<div id="header">
		<?php View::render("header.php"); ?>
		<h2>header is here</h2>
		<hr>
	</div>

	<div id="torso">
		<?php echo $contents; ?>
	</div>

	<div id="footer">
		<?php View::render("footer.php"); ?>
	</div>

	<!-- SCRIPTS ---------------------------------------------------------- -->

	<!-- JQUERY -->

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
		integrity="sha256-k2WSCIexGzOj3Euiig+TlR8gA0EmPjuc79OEeY5L45g="
		crossorigin="anonymous"></script>

	<!-- Bootstrap -->
	<script
		src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
		integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
		crossorigin="anonymous"></script>

	<!--  Prism -->
	<script
		src="<?php echo Env::web(); ?>/js/prism.js?<?php echo $cacheRef; ?>"></script>

	<!--  Main -->
	<script
		src="<?php echo Env::web(); ?>/js/main.js?<?php echo $cacheRef; ?>"></script>

</body>

</html>