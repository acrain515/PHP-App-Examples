 </br>
Gets ASSIGNED TO for DS1 Circuits for CLEAR DS3 Not Yet Matched</br></br> 

<?php

  $date= date("Y-m-d");
  
  require_once('../local.php');
  require_once('../functions.php');
	require_once('../kpi.php');
  
  $result= $local->query("Select * from SRTempD 
	where MATCHED=''
	and DOCUMENT_NUMBER!=''
	and ORDER_FOR='CLEAR DS3'
	and ASSIGNED_TO=''
	");
  while($row= $result->fetch_assoc()) {
  
		$id= $row['ID'];
    $orderNumber= $row['ORDER_NUMBER'];
    $internalCkt= $row['INTERNAL_CKT'];
		$circuitDesignID= $row['CIRCUIT_DESIGN_ID'];
		$sys= $row['SYS'];
		$internalCktCln= clean($internalCkt);
		$assignedTo= "";
		
		echo 'Circuit Design ID: ' . $circuitDesignID . '</br>';
		echo 'Sys: ' . $sys . '</br>';
		
		include('../system-tables-kpi.php');
		
		$result2 = oci_parse($kpi,"Select c.CIRCUIT_DESIGN_ID,c.EXCHANGE_CARRIER_CIRCUIT_ID
		from $tableCircuitPosition cp
		left join $tableCircuit c 
		on cp.CIRCUIT_DESIGN_ID=c.CIRCUIT_DESIGN_ID
		where cp.CIRCUIT_DESIGN_ID_3='$circuitDesignID'
		and rownum<5
		order by c.CIRCUIT_DESIGN_ID desc
    ");
    oci_execute($result2);
    $row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);
		
		$ecID= $row2['EXCHANGE_CARRIER_CIRCUIT_ID'];
		$assignedTo= clean($ecID);
			
		if($assignedTo!='') {  
		
			echo 'Assigned To: ' . $assignedTo . '</br>';
			
			$result3= $local->query("Update SRTempD set 
			ASSIGNED_TO='$assignedTo' 
			where ID='$id'");
		}
		
		
		echo '</br>';
  }
  
  nextUrl("sr-update-15.php");

?>




