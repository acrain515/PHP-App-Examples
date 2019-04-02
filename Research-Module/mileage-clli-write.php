<?php

  date_default_timezone_set('America/New_York');
  
  sleep(2);

  $clli= $_GET['clli'];
  
  require_once('../connection.php');
  $date= date("mdY");
  
  $filename = 'temp/'.$clli.'.txt';

    $myfile = fopen("temp/$clli.txt", "w") or die("Unable to open file!");
    fwrite($myfile, "{\n");
    fwrite($myfile,"  \"data\": [\n");
	
	$result2= $mysqli->query("Select * from Simple where RATE_CODE='DS3' and NEW_ACTL like '$clli%' and STATUS!='COMPLETE'");
	if(($result2)&&(mysqli_num_rows($result2)>0)) {
	  $count= mysqli_num_rows($result2);
      $i=0;
	  while($row2= $result2->fetch_assoc()) {
	  
	    $i++;
		
	    $lecCkt= $row2['VENDOR_CKT'];
	    $internalCkt= $row2['INTERNAL_CKT'];
	    $sys= $row2['SYS'];
	    $mrc= $row2['MRC'];
	    $ban= $row2['BAN'];
	    $vendor= $row2['VENDOR'];
	  
	  	fwrite($myfile,"    [\n");
	    fwrite($myfile,"      \"\",\n");
	    fwrite($myfile,"      \"$lecCkt\",\n");
	    fwrite($myfile,"      \"$internalCkt\",\n");
	    fwrite($myfile,"      \"\",\n");
	    fwrite($myfile,"      \"$sys\",\n");
	    fwrite($myfile,"      \"\",\n");
	    fwrite($myfile,"      \"$$mrc\",\n");
	    fwrite($myfile,"      \"\",\n");
	    fwrite($myfile,"      \"$ban\",\n");
	    fwrite($myfile,"      \"$vendor\",\n");
	    fwrite($myfile,"      \"\",\n");
	    fwrite($myfile,"      \"\",\n");
        fwrite($myfile,"      \"<img src=\\\"../images/flag-blue.png\\\" height=\\\"21px\\\">\"\n");		
	    fwrite($myfile,"    ],\n");
	    
	  }
	}
	  
  
    $result= $mysqli->query("Select * from Mileage where CLLI='$clli'");
    $count= mysqli_num_rows($result);
    $i=0;
    while ($row= $result->fetch_assoc()) {
  
      $i++;
  
      $lecCkt= $row['LEC_CKT'];
	  $internalCkt= $row['INTERNAL_CKT'];
	  $legacyCkt= $row['LEGACY_ID'];
	  $invAloc= $row['INV_ALOC'];
	  $sys= $row['SYS'];
	  $qty= $row['QTY'];
	  $charge= $row['CHARGE'];
	  $ban= $row['BAN'];
	  $vendor= $row['VENDOR'];
	  $soru= $row['SORU'];
	  $cbKey= $row['CB_KEY'];
	  $optimal= $row['OPTIMAL'];
	  $onForecast= $row['ON_FORECAST'];
	
	  fwrite($myfile,"    [\n");
	  fwrite($myfile,"      \"<input class=\\\"checkbox1\\\" type=\\\"checkbox\\\" name=\\\"cbKey[]\\\" value=\\\"$cbKey\\\">\",\n");
	  fwrite($myfile,"      \"$lecCkt\",\n");
	  fwrite($myfile,"      \"$internalCkt\",\n");
	  fwrite($myfile,"      \"$legacyCkt\",\n");
	  fwrite($myfile,"      \"$sys\",\n");
	  fwrite($myfile,"      \"$qty\",\n");
	  fwrite($myfile,"      \"$$charge\",\n");
	  fwrite($myfile,"      \"$invAloc\",\n");
	  fwrite($myfile,"      \"$ban\",\n");
	  fwrite($myfile,"      \"$vendor\",\n");
	  fwrite($myfile,"      \"$soru\",\n");
	  if($optimal=='y') { 
	    fwrite($myfile,"      \"<img src=\\\"../images/flag-blue.png\\\" height=\\\"21px\\\">\",\n");
	  }
	  else {
	    fwrite($myfile,"      \"<img src=\\\"../images/flag-off.png\\\" height=\\\"21px\\\">\",\n");
	  }
	  if($onForecast=='y') { 
	    fwrite($myfile,"      \"<img src=\\\"../images/flag-blue.png\\\" height=\\\"21px\\\">\"\n");
	  }
	  else {
	    fwrite($myfile,"      \"<img src=\\\"../images/flag-off.png\\\" height=\\\"21px\\\">\"\n");
	  }
	
	  if($i<$count) { fwrite($myfile,"    ],\n"); }
	
	  else { fwrite($myfile,"    ]\n"); }
   }

    fwrite($myfile,"  ]\n");
    fwrite($myfile, "}\n");
    fclose($myfile); 
 
 ?>
 