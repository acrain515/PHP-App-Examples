<?php

  date_default_timezone_set('America/New_York');
  
  require_once('../connection.php');
  
  if(!isset($_COOKIE['oatmeal'])) { echo '<meta http-equiv="REFRESH" content="0;url=../login.php">'; }
 
  if(isset($_POST['cbKey'])) {
	
	  $cbKey= $_POST['cbKey'];
		$researcher= $_POST['researcher'];
		
		//echo 'CBKEY: ' . $cbKey . '</br>';
		//echo 'Researcher: ' . $researcher . '</br>';
	    
	  $i=0;
		
    foreach($_POST['cbKey'] as $cbKey) {
		
		  $i++;
		
		  $result= $mysqli->query("Update Dbb set RESEARCHER='$researcher'
			where CB_KEY='$cbKey'");
		}
		
		echo '<div style="margin:200 auto;width:400px;text-align:center;font-family:Arial;">';  
    echo '<h3>' . $i . ' ';
			
		if($i==1){ echo 'Circuit was '; } else { echo 'Circuits were '; }
		echo 'Assigned Succesfully.</h3>  Redirecting...';
	  echo '<meta http-equiv="REFRESH" content="2;url=assign.php">';	
	}
	 
	else {
	
	  echo '<div style="margin:200 auto;width:400px;text-align:center;font-family:Arial;">';  
    echo '<h3>Circuit was not selected.</h3>  Redirecting...';
	  echo '<meta http-equiv="REFRESH" content="2;url=' . $_SERVER['HTTP_REFERER'] . '">';
  }
			
?>

