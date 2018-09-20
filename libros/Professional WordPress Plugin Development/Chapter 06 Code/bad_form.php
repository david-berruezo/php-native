<html>
	<head>
		<title>Bad form example</title>
	</head>
	<body>

		<?php $name = $_POST['fullname']; ?>

		<form action="" method="POST">
		    Full name:
		    <input type="text" name="fullname" value="<?php echo $name; ?>" />
		    <input type="submit" value="Save" />
		</form>

	</body>
</html>