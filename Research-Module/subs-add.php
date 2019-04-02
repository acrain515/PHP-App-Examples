<?php

  date_default_timezone_set('America/New_York');
  
  require_once('../connection.php');

  $ids= $_GET['ids'];
  
  //echo 'Add: ' . $add . '</br>';
  
  $split= explode("-",$ids);
	
	foreach($split as $id) {
	
	  $result= $mysqli->query("Select * from Simple where ID='$id'");
	  $row= $result->fetch_assoc();
	  
	  $internalCkt= $row['INTERNAL_CKT'];
	  $sys= $row['PROV_SYS'];
		$planner= $row['PLANNER'];
		$internalCktCln= $row['INTERNAL_CKT_CLN'];
		$circuitDesignID= $row['CIRCUIT_DESIGN_ID'];
	  $dateAdded= date("m/d/Y");
	  $project= $row['PROJECT'];
	  $subProject= $row['SUBPROJECT'];
	  
	  //echo 'Date Added: ' . $dateAdded . '</br>';
	  //echo 'Owner: ' . $owner . '</br>';
	  
	  $result3= $mysqli->query("Insert into Pull_Subs (INTERNAL_CKT,SYS,CIRCUIT_DESIGN_ID,DATE_ADDED,OWNER,PROJECT,SUBPROJECT)
	  values ('$internalCkt','$sys','$circuitDesignID','$dateAdded','$planner','$project','$subProject')");
  }
	
	echo '<div style="margin:200 auto;width:400px;text-align:center;font-family:Arial;">';  
  echo '<h3>DS1s assigned will be Added to the Forecast</br>after COB today.</h3>  Redirecting...';
	echo '<meta http-equiv="REFRESH" content="3;url=population.php">';

  
?>
  
  