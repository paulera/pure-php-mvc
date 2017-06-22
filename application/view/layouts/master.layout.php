<html>

<head>

<title><?php
if (isset($title)) {
    echo $title . " - paulodev.com";
} else {
    echo "paulodev.com";
}
?></title>

<!-- CSS ---------------------------------------------------------- -->

<!--  FONT AWESOME -->

<link
	href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
	rel="stylesheet"
	integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
	crossorigin="anonymous">

<!--  FONTS: 
      font-family: 'Inconsolata', monospace;
      font-family: 'Open Sans', sans-serif;
      font-family: 'Raleway', sans-serif;
-->

<link
	href="https://fonts.googleapis.com/css?family=Inconsolata|Open+Sans|Raleway"
	rel="stylesheet">

<!--  BOOTSTRAP -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
	integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
	crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
	integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp"
	crossorigin="anonymous">

<!-- Prism -->
<link href="css/prism.css?20170622" rel="stylesheet" />

<!-- Main -->
<link href="css/main.css?20170622" rel="stylesheet" />

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
	<script src="js/prism.js?20170622"></script>
	
	<!--  Main -->
	<script src="js/main.js?20170622"></script>



</body>

</html>