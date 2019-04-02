<?php

  require_once('../functions.php');
	require_once('../cookie.php');
	
	$lecCkt= $_POST['lecCkt'];

  if(!isset($_POST['subProject'])) { 
	
	  error("Project must be selected. </br> Redirecting...");
		nextUrl("http://utopia.dev.windstream.com:8080/research/manual-add-ds1-mileage.php?lecCkt=$lecCkt");
	}
	
	else {
	
	  require_once('../connection.php');
				
		$ban= $_POST['ban'];
		$mrc= $_POST['mrc'];
		$internalCkt= $_POST['internalCkt'];
		$subProject= $_POST['subProject'];
		$asap= $_POST['asap'];
		$sys= determineSys($asap);
		
		$ecID= $_POST['ecID'];
		
		if($ecID==$internalCkt) {  $circuitDesignID= $_POST['circuitDesignID']; }	
		else { $circuitDesignID= ""; }
		
		echo 'Planner: ' . $name . '</br>';
		echo 'Project: ' . $subProject . '</br>';
		echo 'Sys: ' . $sys . '</br>';
		echo 'InternalCkt: ' . $internalCkt . '</br>';
		
		if(strpos($subProject,'Longhaul')!==false) { $project= "Longhaul"; }
		else { $project= "Metro"; }
		
		$result= $mysqli->query("Insert into Simple
		(INTERNAL_ORDER,INTERNAL_CKT,INTERNAL_CKT_CLN,CIRCUIT_DESIGN_ID,PROV_SYS,
	}
	
?>
		
		
