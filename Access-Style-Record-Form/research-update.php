<?php 

  require_once('../connection.php');
	require_once('../functions.php');
	require_once('../cookie.php');
	
	$date= date("Y-m-d h:i:s");
	
  if(isset($_POST['check'])) {   
	
	  $fields= array("RESEARCH_STATUS","RESEARCHER");
		
		foreach($fields as $field) {  
		
		  ${$field}= $_POST[$field];
			$value= ${$field};
			
			if(${$field}!=='') {  
			  	
		    foreach($_POST['check'] as $id) {
			
			    //echo 'ID: ' . $id . '</br>';
			    //echo 'Field: ' . $field . '</br>';
			    //echo 'Value: ' . ${$field} . '</br>';
					
					$result= $mysqli->query("Update Dbb set $field='$value',
					LAST_UPDATE='$date',
					LAST_UPDATE_USER='$name'
					where ID='$id'");
				
				  //echo '</br>';
				}
			}
		} 
	}
	
	success("Redirecting..");
	previousPage("3");
	
?>
	
	