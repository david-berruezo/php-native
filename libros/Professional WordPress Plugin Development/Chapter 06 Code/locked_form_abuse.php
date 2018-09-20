<html>

	<head>
		<title>Locked form abuse</title>
	</head>
	
	<body>

	<pre>
	
	<form action="locked_form.php" method="post">
	<input name="gender" value="hello" />
	<input name="food[]" value="<script>alert('hello');</script>" />
	<input name="country" value="1337" />
    <input type="submit" />
	</form>
	
	</pre>
	
	</body>

</html>