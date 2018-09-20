<html>

	<head>
		<title>Locked form -- now secure</title>
	</head>
	
	<body>

	<pre>
	
	<?php

	if( $_POST ) {

	    $clean = array();
	    
	    // Gender: 2 possible values, default to 'male'
	    $clean['gender'] = ( $_POST['gender'] == 'female' ? 'female' : 'male' );
	    
	    // Food: arbitrary number of possible values, no default
	    $foods = array( 'spinach', 'anchovy', 'liver' );
	    if( in_array( $_POST['food'], $foods ) )
	        $clean['food'] = $_POST['food'];
	    
	    // Country: arbitrary number of possible values, default to 'other'
	    switch( $_POST['country'] ) {
	        case 'canada':
	        case 'uk':
	        case 'usa':
	            $clean['country'] = $_POST['country'];
	            break;
	        default:
	            $clean['country'] = 'other';
	    }
	    
	    $post = print_r( $clean, true );
	    error_log( $post, 3, dirname( __FILE__ ).'/post.log' );

	}

	?>

	<form action="" method="post">

	    Gender:
	    <input type="radio" name="gender" value="male" />male
	    <input type="radio" name="gender" value="female" />female
	    
	    Food dislikes:
	    <input type="checkbox" name="food[]" value="spinach"/>spinach
	    <input type="checkbox" name="food[]" value="anchovy"/>anchovy
	    <input type="checkbox" name="food[]" value="liver"/>liver
	    
	    Country of residence:
	    <select name="country">
	        <option value="usa">USA</option>
	        <option value="canada">Canada</option>
	        <option value="uk">United Kingdom</option>
	        <option value="other">Other</option>
		</select>
	    
	    <input type="submit" />
	    
	</form>
	
	</pre>
	
	</body>

</html>