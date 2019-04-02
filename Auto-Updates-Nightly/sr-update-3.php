SR Update New 3 </br>
Gets Circuits on Order from Inventory Sys, Inserts into Table D

<?php  

	require_once('../local.php');
	require_once('../kpi.php');
	require_once('../functions.php');
	
	$date= date("Y-m-d");
	
	$result= $local->query("Select * from SRTempC 
	where COPIED<90
	and STATUS not in ('COMPLETE','CANCELED')");
	while($row= $result->fetch_assoc()) { 
	
	  $id= $row['ID'];
	  $documentNumber= $row['DOCUMENT_NUMBER'];
		$sys= $row['SYS'];
		$planner= $row['PLANNER'];
		$copied= $row['COPIED'];
		
		$next= $copied+1;
		
		echo 'DocumentNumber: ' . $documentNumber . '</br>';
		
		include('../system-tables-kpi.php');
		
		$result2 = oci_parse($kpi,"Select src.CIRCUIT_DESIGN_ID,src.ORDER_NUMBER,c.EXCHANGE_CARRIER_CIRCUIT_ID,c.RATE_CODE
    from $tableSRC src
    left join $tableCircuit c
    on src.CIRCUIT_DESIGN_ID=c.CIRCUIT_DESIGN_ID
    where src.DOCUMENT_NUMBER='$documentNumber'");
    oci_execute($result2);
    while($row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS)) {
  
      $internalCkt= $row2['EXCHANGE_CARRIER_CIRCUIT_ID'];
			$circuitDesignID= $row2['CIRCUIT_DESIGN_ID'];
			$orderNumber= $row2['ORDER_NUMBER'];
			$rateCode= $row2['RATE_CODE'];

      if(($internalCkt!='')&&($orderNumber!='')) {
	
	      echo 'Circuit on Order: ' . $internalCkt . '</br>';
				echo 'Order: ' . $orderNumber . '</br>';
				
				//CHECK IF CIRCUIT ALREADY IN SRTEMPD 
				
				$result3= $local->query("Select * from SRTempD 
				where INTERNAL_CKT='$internalCkt'
				and ORDER_NUMBER='$orderNumber'");
				if(($result3)&&(mysqli_num_rows($result3)>0)) { }
				
				else {
				
	        $result4= $local->query("Insert into SRTempD
				  (ORDER_NUMBER,DOCUMENT_NUMBER,PLANNER,INTERNAL_CKT,CIRCUIT_DESIGN_ID,RATE_CODE,SYS,DATE_ADDED)
          values 
				  ('$orderNumber','$documentNumber','$planner','$internalCkt','$circuitDesignID','$rateCode','$sys','$date')
				  ");
				}
				
				$result5= $local->query("Update SRTempC set 
				COPIED='$next',DATE_COPIED='$date' 
				where ID='$id'");
      }
    }
		
		echo '</br>';
	}
	
	oci_close($kpi);
	nextUrl("sr-update-4.php");
	
?>
