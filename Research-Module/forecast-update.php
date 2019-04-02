<?php 

  require_once('../connection.php');
	require_once('../functions.php');
	require_once('../cookie.php');
	
	$date= date("Y-m-d h:i:s");
	
  if(isset($_POST['check'])) {   
	
	  $fields= array("STATUS","PLANNER","INITIAL_FOC","ACTUAL_FOC","INSTALL PON","DISC PON","PROVISIONER");
		
		foreach($fields as $field) {  
		
		  ${$field}= $_POST[$field];
			$value= ${$field};
			
			if(${$field}!=='') {  
			  	
		    foreach($_POST['check'] as $id) {
			
			    //echo 'ID: ' . $id . '</br>';
			    //echo 'Field: ' . $field . '</br>';
			    //echo 'Value: ' . ${$field} . '</br>';
					
					$result= $mysqli->query("Update Simple set $field='$value',
					LAST_UPDATE='$date',
					LAST_UPDATED_USER='$name' 
					where ID='$id'");
				
				  //echo '</br>';
				}
			}
		} 
	}
	
	success("Redirecting..");
	previousPage("3");
	
?>
	
	