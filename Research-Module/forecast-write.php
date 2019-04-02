
<?php

  date_default_timezone_set('America/New_York');
  
  sleep(2);
  
  require_once('../connection.php');
  
  $filename = 'temp/forecast-source.txt';

  $myfile = fopen("temp/forecast-source.txt", "w") or die("Unable to open file!");
  fwrite($myfile, "{\n");
  fwrite($myfile,"  \"data\": [\n");

  $result= $mysqli->query("Select * from Simple where ON_FORECAST='y'");
  $count= mysqli_num_rows($result);
  $i=0;
  while ($row= $result->fetch_assoc()) {
	
	$i++;

    $vendorCkt= str_replace(' ','',$row['VENDOR_CKT']);
	$internalCkt= str_replace(' ','',$row['INTERNAL_CKT']);
	$savings= $row['SAVINGS'];
	$rateCode= str_replace(' ','',$row['RATE_CODE']);
	$ncsOwner= $row['NCS_OWNER'];
	$provOwner= $row['PROV_OWNER'];
	$project= $row['PROJECT'];
	$subProject= $row['SUBPROJECT'];
	$status= $row['STATUS'];
	$initialFOC= $row['INITIAL_FOC'];
	$internalOrder= str_replace(' ','',$row['INTERNAL_ORDER']);
	$sys= str_replace(' ','',$row['PROV_SYS']);
	$newActl= str_replace(' ','',$row['NEW_ACTL']);
	
	fwrite($myfile,"    [\n");
	fwrite($myfile,"      \"$vendorCkt\",\n");
	fwrite($myfile,"      \"$internalCkt\",\n");
	fwrite($myfile,"      \"$savings\",\n");
	fwrite($myfile,"      \"$rateCode\",\n");
	fwrite($myfile,"      \"$ncsOwner\",\n");
	fwrite($myfile,"      \"$provOwner\",\n");
	fwrite($myfile,"      \"$project\",\n");
	fwrite($myfile,"      \"$subProject\",\n");
	fwrite($myfile,"      \"$status\",\n");
	fwrite($myfile,"      \"$initialFOC\",\n");
	fwrite($myfile,"      \"$internalOrder\",\n");
	fwrite($myfile,"      \"$sys\",\n");
	fwrite($myfile,"      \"$newActl\"\n");

	
	if($i<$count) { fwrite($myfile,"    ],\n"); }
	else { fwrite($myfile,"    ]\n"); }
   }

    fwrite($myfile,"  ]\n");
    fwrite($myfile, "}\n");
    fclose($myfile); 
	  
 ?>