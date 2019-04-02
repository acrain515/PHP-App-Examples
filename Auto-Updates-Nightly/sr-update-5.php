Sr Update New 5 </br>
Match Circuit and Order in SRTempD to TBD Orders in Simple </br>

<?php

  $date= date("Y-m-d");
  
  require_once('../prod.php');
  require_once('../local.php');
  require_once('../functions.php');
  
  $result= $local->query("Select * from SRTempD 
	where MATCHED='' 
	and ORDER_NUMBER!=''");
  while($row= $result->fetch_assoc()) {
  
	  $id= $row['ID'];
    $orderNumber= $row['ORDER_NUMBER'];
    $internalCkt= $row['INTERNAL_CKT'];
		$circuitDesignID= $row['CIRCUIT_DESIGN_ID'];
	
    echo $order . '</br>';
    //echo $internalCkt . '</br>';
	
	  $internalCktCln= clean($internalCkt);
	
    echo $internalCktCln . '</br>';
		
		if($internalCktCln!='') {
		
		  $result2= $mysqli->query("Select ID from Simple 
			where INTERNAL_CKT_CLN='$internalCktCln' 
			and INTERNAL_ORDER='TBD' limit 3");
			if(($result2)&&(mysqli_num_rows($result2)>0)) { 
 
			  while($row2= $result2->fetch_assoc()) {  
			
			    $trackingID= $row2['ID'];
			
			    echo 'Match Found </br>';

		      $result3= $mysqli->query("Update Simple set 
		      INTERNAL_ORDER='$orderNumber',CIRCUIT_DESIGN_ID='$circuitDesignID',ON_FORECAST='y' 
		      where ID='$trackingID'");
				}
			
			  $result4= $local->query("Update SRTempD set 
			  MATCHED='y',DATE_MATCHED='$date'
			  where ID='$id'");
				
				if($result4) { echo 'MATCH! </br>'; }

			}
    }  
  }
  
  nextUrl("sr-update-5b.php");

?>





