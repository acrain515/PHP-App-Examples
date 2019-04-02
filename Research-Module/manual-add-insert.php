<?php 

  require_once('../connection.php');
	require_once('../cookie.php');
	require_once('../functions.php');
	
	$INTERNAL_CKT= $_POST['INTERNAL_CKT'];
	$RATE_CODE= $_POST['RATE_CODE'];
	$PROV_SYS= $_POST['PROV_SYS'];
	$VENDOR_CKT= $_POST['VENDOR_CKT'];
	$BAN= $_POST['BAN'];
	$VENDOR= $_POST['VENDOR'];
	$MRC= $_POST['MRC'];
	$PLANNER= $_POST['PLANNER'];
	$SUBPROJECT= $_POST['SUBPROJECT'];
	$STATUS= $_POST['STATUS'];
		
	if(($INTERNAL_CKT=='')&&($VENDOR_CKT=='')) {
		
		error("Internal Ckt or Vendor Ckt must be set. <br> Redirecting...");
	  previousPage("4");
	}
	
	else {
		
		$internalCktCln= clean($INTERNAL_CKT);
		$vendorCktCln= clean($VENDOR_CKT);
		
		$resultProject= $mysqli->query("Select PROJECT from Projects where SUBPROJECT='$SUBPROJECT'");
		$rowProject= $resultProject->fetch_assoc();
		$project= $rowProject['PROJECT'];
		
		$dateAdded= date("Y-m-d h:i:s");
		
		//echo $INTERNAL_CKT . '</br>';
		//echo $RATE_CODE . '</br>';
		//echo $PROV_SYS . '</br>';
		//echo $VENDOR_CKT . '</br>';
		//echo $BAN . '</br>';
		//echo $VENDOR . '</br>';
		//echo $MRC . '</br>';
		//echo $PLANNER . '</br>';
		//echo $SUBPROJECT . '</br>';
		//echo $STATUS . '</br>';
		
		$result= $mysqli->query("Insert into Simple 
		(INTERNAL_ORDER,INTERNAL_CKT,INTERNAL_CKT_CLN,RATE_CODE,PROV_SYS,
		VENDOR_CKT,VENDOR_CKT_CLN,VENDOR,BAN,MRC,
		PLANNER,PROJECT,SUBPROJECT,STATUS,
		DATE_ADDED,ON_FORECAST)
		values
		('TBD','$INTERNAL_CKT','$internalCktCln','$RATE_CODE','$PROV_SYS',
		'$VENDOR_CKT','$vendorCktCln','$VENDOR','$BAN','$MRC',
		'$PLANNER','$project','$SUBPROJECT','$STATUS',
		'$dateAdded','y')
		");
		
		
		success("Circuit Added to Tracking. </br> Redirecting...");
		previousPage("2");
		
		
	}
		
?>
		