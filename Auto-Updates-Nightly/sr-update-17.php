FINDS IF CIRCUIT WAS CANCELED OFF ORDER AND DELETES FROM DATABASE  // NOT CURRENTLY USING
<?php  
	
	require_once('../local.php');
  require_once('../functions.php');
	require_once('../kpi.php');
  
  $result= $local->query("Select * from SRTempD 
	where MATCHED=''
	and DOCUMENT_NUMBER='6500304'
	limit 10
	");
  while($row= $result->fetch_assoc()) {
	
	  $id= $row['ID'];
    $documentNumber= $row['DOCUMENT_NUMBER'];
		$circuitDesignID= $row['CIRCUIT_DESIGN_ID'];
		$internalCkt= $row['INTERNAL_CKT'];
		$sys= $row['SYS'];
		$orderNumber= $row['ORDER_NUMBER'];
		
		echo 'Document Number: ' . $documentNumber . '</br>';
		echo 'Circuit Design ID: ' . $circuitDesignID . '</br>';
		
		include('../system-tables-kpi.php');
		
		$result2 = oci_parse($kpi,"Select count(*) as THE_COUNT
    from $tableSRC src
    left join $tableCircuit c
    on src.CIRCUIT_DESIGN_ID=c.CIRCUIT_DESIGN_ID
    where src.DOCUMENT_NUMBER='$documentNumber'
		and src.CIRCUIT_DESIGN_ID='$circuitDesignID'
		and rownum<2");
    oci_execute($result2);
    $row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);
		
		$theCount= $row2['THE_COUNT'];
		echo 'Count: ' . $theCount . '</br>';
		
		echo '</br>';
		
		
	}
	
?>