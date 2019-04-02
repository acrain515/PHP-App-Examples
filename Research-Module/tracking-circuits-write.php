<?php

  date_default_timezone_set('America/New_York');
  
  sleep(2);
  
  require_once('../connection.php');

  if(!isset($_COOKIE['oatmeal'])) { echo '<meta http-equiv="REFRESH" content="0;url=../login.php">'; }
  
  $raisin= $_COOKIE['oatmeal'];
  //$raisin= "qm7he7fs7t";

  $chocolate= $mysqli->query("Select * from Users where RAISIN='$raisin'");
    
  $macadamia= $chocolate->fetch_assoc(); 
  $name= $macadamia['NAME'];
  $nameNoSpace= str_replace(" ","",$name);
  
  $filename = '../research/temp/'.$nameNoSpace.'.txt';
  
    $myfile = fopen($filename, "w") or die("Unable to open file!");
    fwrite($myfile, "{\n");
    fwrite($myfile,"  \"data\": [\n");
	
	$result= $mysqli->query("Select * from Simple where (NCS_OWNER='$name' or PROV_OWNER='$name') and STATUS not in ('COMPLETE','CLEARED','CANCELED') and INTERNAL_ORDER='TBD' order by STATUS_LAST_UPDATE");
    $count= mysqli_num_rows($result);
    $i=0;
    while ($row= $result->fetch_assoc()) {
  
      $i++;
  
      $id= $row['ID'];
      $internalCkt= $row['INTERNAL_CKT'];
	  $internalCktCln= str_replace("/","",$internalCkt);
	  $internalCktCln= str_replace("-","",$internalCktCln);
      $internalCktCln= str_replace(".","",$internalCktCln);
      $internalCktCln= str_replace(" ","",$internalCktCln);
	  $vendorCkt= $row['VENDOR_CKT'];
	  $ban= $row['BAN'];
	  $newACTL= $row['NEW_ACTL'];
	  $newLoopType= $row['NEW_LOOP_TYPE'];
	  $bcs= $row['BCOS'];
      $order= $row['INTERNAL_ORDER'];
	  $project= $row['SUBPROJECT'];
	  $status= $row['STATUS'];
	  $statusLastUpdate= $row['STATUS_LAST_UPDATE'];
	  $strLastUpdate= strtotime($statusLastUpdate);
	  $strNow= strtotime("now");
	  $statusDays= ($strNow-$strLastUpdate)/(60*60*24);
	  $statusDays= round($statusDays);
	
	  fwrite($myfile,"    [\n");
	  fwrite($myfile,"      \"<input class=\\\"checkbox1\\\" type=\\\"checkbox\\\" name=\\\"id[]\\\" value=\\\"$id\\\">\",\n");
	  fwrite($myfile,"      \"$internalCkt\",\n");
	  fwrite($myfile,"      \"$vendorCkt\",\n");
	  fwrite($myfile,"      \"$ban\",\n");
	  fwrite($myfile,"      \"$newACTL\",\n");
	  fwrite($myfile,"      \"$newLoopType\",\n");
	  fwrite($myfile,"      \"$bcs\",\n");
	  fwrite($myfile,"      \"<a href=\\\"../tbd.php?id=$id\\\" target=\\\"blank\\\">$order</a>\",\n");
	  fwrite($myfile,"      \"$project\",\n");
	  fwrite($myfile,"      \"$status\",\n");
	  fwrite($myfile,"      \"$statusDays\"\n");
	
	  if($i<$count) { fwrite($myfile,"    ],\n"); }
	
	  else { fwrite($myfile,"    ]\n"); }
   }

    fwrite($myfile,"  ]\n");
    fwrite($myfile, "}\n");
    fclose($myfile); 

 
 ?>
 