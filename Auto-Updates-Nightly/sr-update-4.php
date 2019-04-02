SR Update New 4 </br>
Checks if Circuit and Order in SRTempD is Already Matched in Tracking Table </br>
<?php

  $date= date("Y-m-d");
  
  require_once('../prod.php');
  require_once('../local.php');
  require_once('../functions.php');
  
  $result= $local->query("Select * from SRTempD where MATCHED=''");
  while($row= $result->fetch_assoc()) {
  
	  $id= $row['ID'];
    $order= $row['ORDER_NUMBER'];
    $internalCkt= $row['INTERNAL_CKT'];
		$circuitDesignID= $row['CIRCUIT_DESIGN_ID'];
	
    echo $order . '</br>';
    //echo $internalCkt . '</br>';
	
	  $internalCktCln= trim(preg_replace('/[^a-zA-Z0-9\']/','',$internalCkt));
	
    echo $internalCktCln . '</br>';
		
		if($internalCktCln!='') {
		
		  $result2= $mysqli->query("Select * from Simple 
			where INTERNAL_CKT_CLN='$internalCktCln' 
			and INTERNAL_ORDER='$order'
			");
			if(($result2)&&(mysqli_num_rows($result2)>0)) {
			 
			  $result4= $local->query("Update SRTempD set 
			  MATCHED='y',DATE_MATCHED='$date'
			  where ID='$id'");
			}
    }  
  }
  
  nextUrl("sr-update-5.php");

?>

