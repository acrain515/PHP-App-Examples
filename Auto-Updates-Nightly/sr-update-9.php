Sr Update New 9 </br>
Match and Update Order,Internal Ckt where Internal Ckt did not match but LEC Ckt match Found </br></br>

<?php

  $date= date("Y-m-d");
  
  require_once('../local.php');
	require_once('../prod.php');
  require_once('../functions.php');
  
  $result= $local->query("Select * from SRTempD 
	where MATCHED=''
  and LEC_CKT_CLN!=''
	and BAN!=''
	and ORDER_NUMBER!=''
	");
  while($row= $result->fetch_assoc()) {
  
	  $id= $row['ID'];
    $orderNumber= $row['ORDER_NUMBER'];
    $internalCkt= $row['INTERNAL_CKT'];
		$circuitDesignID= $row['CIRCUIT_DESIGN_ID'];
		$sys= $row['SYS'];
		$lecCkt= $row['LEC_CKT_CLN'];
		$internalCktCln= trim(preg_replace('/[^a-zA-Z0-9\']/','',$internalCkt));
	
    echo 'Internal Ckt: ' . $internalCkt . '</br>';
    echo 'LEC Ckt: ' . $lecCkt . '</br>';
		
		$result2= $mysqli->query("Select ID,INTERNAL_CKT_CLN from Simple 
		where VENDOR_CKT_CLN='$lecCkt' 
		and INTERNAL_ORDER='TBD'
		");
		if(($result2)&&(mysqli_num_rows($result2)>0)) { 
		
		  while($row2= $result2->fetch_assoc()) { 
		
		    $id2= $row2['ID'];
			  $internalCktCln2= $row2['INTERNAL_CKT_CLN'];
			  echo 'ID: ' . $id2 . '</br>';
			  echo 'Internal Ckt Cln: ' . $internalCktCln2 . '</br>';
			 
		    echo 'Match Found. </br>';
				
				$result3= $mysqli->query("Update Simple set 
				INTERNAL_CKT='$internalCkt',
				INTERNAL_CKT_CLN='$internalCktCln',
				INTERNAL_ORDER='$orderNumber'
				where ID='$id2'");
				
				$result4= $local->query("Update SRTempD set 
				MATCHED='y',
				DATE_MATCHED='$date'
				where ID='$id'");	
		  }
		}
		
		echo '</br>';
  }
  
  nextUrl("sr-update-10.php");

?>




