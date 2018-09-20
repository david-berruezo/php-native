<?php
//Server DB
if($post_query[0] != 'error' && $_SESSION['loggedin']) {

	include('./connect.php');
	
	if(!$connect) {
		
		echo ' Could not select database';

	} else {
		if(!mysqli_select_db( $connect,'api_rest')) {
		
			echo 'Could not select database';
		
		} else {
			//The post service creates a new field
			if($query->allows_services === 'post') {
				
				foreach($post_query as $pq) {

					$consult = mysqli_query($connect,'INSERT INTO `simple_api_rest`(`ID`) VALUES (\'' . mysqli_real_escape_string($connect,$pq) . '\')');
					
					if(mysqli_affected_rows($connect) > 0) {

						$output_data[$pq] = $pq . ': Created successfully';
					
					} else {

						$output_data[$pq] = $pq . ': already exists';
						
					}
				
				}
			//The delete service deletes a field and its values
			} else if($query->allows_services === 'delete') {
				
				foreach($post_query as $pq) {

					$consult = mysqli_query($connect,'DELETE FROM simple_api_rest WHERE ID = "' . mysqli_real_escape_string($connect,$pq) . '"');

					if(mysql_affected_rows($connect) > 0) {

						$output_data[$pq] = $pq . ': Was successfully eliminated';
					
					} else {

						$output_data[$pq] = $pq . ': Not found in the database';
						
					}
				
				}
			//The get service displays a field and its values
			} else if($query->allows_services === 'get') {

				foreach($post_query as $pq) {

					$consult = mysqli_query($connect,'SELECT `name`, `value` FROM simple_api_rest WHERE ID = \'' . mysqli_real_escape_string($connect,$pq) . '\'');
					
					$rows = mysqli_fetch_row($consult);
					
					if($rows > 0) {

						foreach($rows as $key => $value) {
							
							if($key === 0) {
								
								$k = 'name';
								
							} else if($key === 1) {
								
								$k = 'value';
							
							}
								
							$output_data[$pq][$k] = $value;
							
						}
					
					} else {

						$output_data[$pq] = $pq . ': Not found in the database';
						
					}
				
				}
			//The put service updates the values ​​of a field
			} else if($query->allows_services === 'put') {

				foreach($post_query as $key => $pq) {
					
					foreach($pq as $data) {
						
						$name_value = explode(':', $data);
						$string_query = 'UPDATE `simple_api_rest` SET `' . trim(mysqli_real_escape_string($connect,$name_value[0])) . '`=\'' . trim(mysqli_real_escape_string($connect,$name_value[1])) . '\' WHERE `ID`=\'' . trim(mysqli_real_escape_string($connect,$key)) . '\'';
						$consult = mysqli_query( $connect,$string_query);
						if(mysqli_affected_rows($connect) > 0) {
							
							$output_data[$key][] = $data . ' was successfully updated';
						
						} else {

							$output_data[$key][$data] = $data . ' Failed to update, view sent values or the value is not changed because it is the same';
							
						}
		
					}
									
				}
			
			}
			
			mysqli_close($connect);
			header('Content-type: application/json');
			//Display query in json format
			echo json_encode($output_data);				
			
		}
		
	}
	
} else {
	
	echo $post_query[1];
	
}
?>