<!DOCTYPE html>
<html lang="en-US">
	<head>
		<title>Sample1</title>
	</head>
	<body>
		<h1>Simple MVC</h1>
		<hr />
		<a href="/simple_mvc/">Home</a> | 
		<a href="/simple_mvc/index.php/portfolio">Portfolio</a> | 
		<a href="/simple_mvc/index.php/downloads">Downloads</a> | 
		<a href="/simple_mvc/index.php/contacts">Contacts</a>
		<hr />
		<?php output(); ?>
		<p>
		<?php output('content'); ?>
		</p>
	</body>
</html>