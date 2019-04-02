<?php

  require_once('../connection.php');
  
  $result= $mysqli->query("Select * from Mileage");
  while($row= $result->fetch_assoc()) {
  
    $cbKey= $row['LEC_CKT'] . '' . $row['BAN'];
	
	echo $cbKey . '</br>';
	
	$result2= $mysqli->query("Update Mileage set CB_KEY='$cbKey' where LEC_CKT='$row[LEC_CKT]' and BAN='$row[BAN]'");
  }
  
?>