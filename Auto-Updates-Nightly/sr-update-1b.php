<?php 

  require_once('../prod.php');
	require_once('../local.php');
	require_once('../kpi.php');
	require_once('../functions.php');
	
	$sys= "NVX";
	
	include('../system-tables-kpi.php');
	
	$result= $mysqli->query("Select * from Users 
	where NAME not in ('Keith Hester','Anthony Marler')
	and ORG not in ('Master','DBB','Jon Richert')
	");
	while($row= $result->fetch_assoc()) { 
	
	  $name= $row['NAME'];
		
		echo $name . '</br>';
		
		$result2= $local->query("Select * from Work_Queues 
		where OWNER='$name' and SYS='$sys'");
		while($row2= $result2->fetch_assoc()) {
		
		  $workQ= $row2['WORK_QUEUE_ID'];
		  echo 'WorkQ: ' . $workQ . '</br>';
		
		  $result3 = oci_parse($kpi, "Select distinct DOCUMENT_NUMBER from $tableTask
      where LAST_MODIFIED_DATE>(SYSDATE-14)
      and TASK_TYPE in ('APP')
		  and WORK_QUEUE_ID='$workQ'
      ");
      oci_execute($result3);
      while ($row3 = oci_fetch_array($result3, OCI_ASSOC+OCI_RETURN_NULLS)) {
		
		    $documentNumber= $row3['DOCUMENT_NUMBER'];
			  echo 'Document Number: ' . $documentNumber . '</br>';
			
			  $result4= $local->query("Insert into SRTempC 
			  (DOCUMENT_NUMBER,PLANNER,SYS)
			  values
			  ('$documentNumber','$name','$sys')
			  ");
		  }
		}
		
		echo '</br>';
	}
	
	oci_close($kpi);
	nextUrl("sr-update-1c.php");
	
?>



