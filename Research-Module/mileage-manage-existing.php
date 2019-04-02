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
		
		$result= $mysqli->query("Select * from Mileage where CB_KEY='$cbKey'");
    $row= $result->fetch_assoc();
		
		$lecCkt= $row['LEC_CKT'];
		$lecCktCln= trim(preg_replace('/[^a-zA-Z0-9\']/','',$lecCkt));
	  $internalCkt= $row['INTERNAL_CKT'];
		$internalCktCln= trim(preg_replace('/[^a-zA-Z0-9\']/','',$internalCkt));
		$circuitDesignID= $row['CIRCUIT_DESIGN_ID'];
    $ban= $row['BAN'];
	  $vendor= $row['VENDOR'];
	  $mrc= $row['MRC'];
	  if(strpos($mrc,'.')==false) { $mrc.= '.00'; }
		$clli= $row['CLLI'];
	  $sys= $row['SYS'];
		if($sys=='PT-MSS') { $sys= "PAE"; }
		if(($sys=='M5')||($sys=='NV-MSS')) { $sys= "NVX"; }
		if($sys=='WS-MSS') { $sys= "WIN"; }
	  $date1= date("Y-m-d H:i:s");
    $date2= date("Y-m-d H:i:s");
	  $date3= date("Y-m-d H:i:s");
	  $date4= date("Y-m-d H:i:s");
		
		$result2= $mysqli->query("Insert into Simple 
		(PROJECT,SUBPROJECT,PLANNER,INTERNAL_ORDER,INTERNAL_CKT,PROV_SYS,CIRCUIT_DESIGN_ID,
		INTERNAL_CKT_CLN,RATE_CODE,VENDOR_CKT,VENDOR_CKT_CLN,VENDOR,BAN,MRC,NEW_ACTL,
		LAST_UPDATE,STATUS_LAST_UPDATE,DATE_ADDED,ORDER_LAST_UPDATE,ON_FORECAST,FIN_FCAST,STATUS) 
		values 
		('$project','$subProject','$name','TBD','$internalCkt','$sys','$circuitDesignID',
		'$internalCktCln','DS1','$lecCkt','$lecCktCln','$vendor','$ban','$mrc','$clli',
		'$date1','$date2','$date3','$date4','y','y','IDENTIFIED')");

    $result3= $mysqli->query("Update Mileage set ON_FORECAST='y' where CB_KEY='$cbKey'");
				
	}
	
	message("Circuits added successfully. ");
	nextUrl("mileage.php");
	 
	 
?>

