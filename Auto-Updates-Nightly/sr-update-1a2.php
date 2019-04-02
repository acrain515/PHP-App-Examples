<?php 

  require_once('../prod.php');
	require_once('../local.php');
	require_once('../kpi.php');
	require_once('../functions.php');
	
	$sys= "PAE";
	
	include('../system-tables-kpi.php');
		
	$result = oci_parse($kpi, "Select distinct DOCUMENT_NUMBER from $tableTask
  where LAST_MODIFIED_DATE>(SYSDATE-14)
  and TASK_TYPE in ('APP','FORECST')
	and WORK_QUEUE_ID='SVGSPLN'
  ");
  oci_execute($result);
  while ($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) {
		
		$documentNumber= $row['DOCUMENT_NUMBER'];
	  echo 'Document Number: ' . $documentNumber . '</br>';
			
		$result2= $local->query("Insert into SRTempC 
		(DOCUMENT_NUMBER,SYS,PLANNER)
		values
		('$documentNumber','$sys','Keith Hester')
		");
		
		echo '</br>';
	}
	
	oci_close($kpi);
	nextUrl("sr-update-1b.php");
	
?>



