Project Orders 4 </br> 
What: RATE_CODE </br> 
From: Internal Systems </br> 
For: DOCUMENT_NUMBER (Project_Orders table) </br> 
To: Project_Orders </br> 
</br>

<?php
  
  require_once('../prod.php');
  require_once('../kpi.php');
	require_once('../functions.php');
  
  $result= $mysqli->query("Select SYSORD,INVENTORY_SYS,DOCUMENT_NUMBER
  from Project_Orders
  where RATE_CODE='' 
	and STATUS='Pending'
	and SYSORD not like 'NF%'
  ");
  while($row= $result->fetch_assoc()) {
  
	  $sys= $row['INVENTORY_SYS'];
	  $documentNumber= $row['DOCUMENT_NUMBER'];
	  $sysOrd= $row['SYSORD'];
	
	  echo $documentNumber . '</br>';
	  echo $sys . '</br>';
	  echo $sysOrd . '</br>';
	
	  include('../system-tables-kpi.php');
	
	  $result2 = oci_parse($kpi, "Select RATE_CODE
    from $tableSRC a
	  left join $tableCircuit b 
    on a.CIRCUIT_DESIGN_ID=b.CIRCUIT_DESIGN_ID	
    where a.DOCUMENT_NUMBER='$documentNumber'
		and RATE_CODE not in ('DS0')
	  and rownum<2
    ");
    oci_execute($result2);
    $row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);
	
	  $rateCode= $row2['RATE_CODE'];
	  echo $rateCode . '</br>';
	
	  $result3= $mysqli->query("Update Project_Orders 
		set RATE_CODE='$rateCode' 
	  where SYSORD='$sysOrd'");

	  echo '</br>';
	
  }
	
	oci_close($kpi);
	nextUrl("project-orders-5.php");
  
?>



