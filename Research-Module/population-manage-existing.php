<?php  

  require_once('../connection.php');
	require_once('../functions.php');

  $data= $_POST['data'];
	$project= $_POST['project'];
	$subProject= $_POST['subProject'];
	$name= $_POST['name'];
	 
	//echo $data;
	 
	$existings= unserialize($data);
	//print_r($existings);
	
	foreach ($existings as $existing) {  
							
		$cbKey= $existing[0] . '' . $existing[1];
		//echo $cbKey . '</br>';
		
		$result= $mysqli->query("Select * from Population where CB_KEY='$cbKey'");
    $row= $result->fetch_assoc();
		
		$internalCkt= $row['EXCHANGE_CARRIER_CIRCUIT_ID'];
		$internalCktCln= clean($internalCkt);
	  $lecCkt= $row['LEC_CKT'];
		$lecCktCln= clean($lecCkt);
    $ban= $row['BAN'];
	  $vendor= $row['VENDOR_GRP'];
	  $mrc= $row['MRC'];
	  $lata= $row['LATA'];
	  $provSys= $row['ASAP_INSTANCE'];
		$rateCode= $row['RATE_CODE']; 
	  $zClli= $row['UNQ_Z_CLLI'];
	  $circuitDesignID= $row['CIRCUIT_DESIGN_ID'];
	  $date1= date("Y-m-d H:i:s");
    $date2= date("Y-m-d H:i:s");
	  $date3= date("Y-m-d H:i:s");
	  $date4= date("Y-m-d H:i:s");
		
		$result2= $mysqli->query("Insert into Simple 
		(PROJECT,SUBPROJECT,PLANNER,INTERNAL_ORDER,
		INTERNAL_CKT,INTERNAL_CKT_CLN,VENDOR_CKT,VENDOR_CKT_CLN,
		VENDOR,BAN,PROV_SYS,MRC,NEW_MRC,SAVINGS,DATE_ADDED,LAST_UPDATE,
		ON_FORECAST,FIN_FCAST,STATUS,RATE_CODE,CIRCUIT_DESIGN_ID,LATA) 
		values 
		('$project','$subProject','$name','TBD',
		'$internalCkt','$internalCktCln','$lecCkt','$lecCktCln',
		'$vendor','$ban','$provSys','$mrc','0.00','$mrc','$date1','$date2',
		'y','y','IDENTIFIED','$rateCode','$circuitDesignID','$lata')");

    $result3= $mysqli->query("Update Population set ON_FORECAST='y' where CB_KEY='$cbKey'");
				
	}
	
	message("Circuits added successfully. ");
	nextUrl("population.php");
	 
	 
?>

