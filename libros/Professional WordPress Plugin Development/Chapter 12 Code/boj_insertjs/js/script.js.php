<?php
// Send proper header for the browser
header('Content-type: application/javascript');

// Get context to display appropriate notice
$page = isset( $_GET['where'] ) ? $_GET['where'] : '' ;

switch( $page ) {
	// admin pages:
	case 'admin':
		$context = "all admin pages";
		break;
	
	case 'settings':
		$context = "plugin settings page";
		break;
	
	case 'users':
		$context = "plugin users page";
		break;
	
	case 'comments':
		$context = "comments page";
		break;

	// public pages:
	case 'single':
		$context = "blog single pages";
		break;
	
	case 'about':
		$context = "About page";
		break;
	
	case 'blog':
		$context = "all blog pages";
		break;
}

?>

// Now javascript part, here a simple alert
alert( 'This script should only load in: <?php echo $context; ?>' );



