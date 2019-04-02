Sr Update New 10 </br>
Check if LEC_CKT in Mileage or Population table, Set as ON_FORECAST in Appropriate Table </br></br>
</br>
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
		$internalCktCln= trim(clean($internalCkt));
		$ban= $row['BAN'];
	
    echo 'Internal Ckt: ' . $internalCkt . '</br>';
    echo 'LEC Ckt: ' . $lecCkt . '</br>';
		echo 'OrderNumber: ' . $orderNumber . '</br>';
		
		$result2= $mysqli->query("Select CB_KEY from Mileage 
		where LEC_CKT='$lecCkt' 
		and BAN='$ban' limit 1
		");
		if(($result2)&&(mysqli_num_rows($result2)>0)) { 
		
      echo 'Mileage Match Found! </br>';
			
			$result3= $local->query("Update SRTempD set MILE_POP='M' 
			where ID='$id'");	
		}
		
		else {
		
		  $result2= $mysqli->query("Select CB_KEY from Population 
		  where LEC_CKT='$lecCkt' 
		  and BAN='$ban' limit 1
		  ");
		  if(($result2)&&(mysqli_num_rows($result2)>0)) { 
		
        echo 'Population Match Found! </br>';
			
			  $result3= $local->query("Update SRTempD set MILE_POP='P' 
			  where ID='$id'");
		  }
		}
		
		echo '</br>';
  }
  
  nextUrl("sr-update-11.php");

?>




