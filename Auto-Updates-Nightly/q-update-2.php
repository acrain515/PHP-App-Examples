<?php  

  require_once('../local.php');
	require_once('../kpi.php');
	require_once('../functions.php');
	
	$sys= "NVX";
	
	include('../system-tables-kpi.php');

  $result = oci_parse($kpi, "Select WORK_QUEUE_ID,PARENT_WORK_QUEUE_ID,
	e.EMPLOYEE_NUMBER,initcap(EMPLOYEE_FIRST_NAME)||' '||initcap(EMPLOYEE_LAST_NAME) as OWNER
  from $tableQueues wq
  left join $tableEmployee e
  on wq.EMPLOYEE_NUMBER=e.EMPLOYEE_NUMBER
  where wq.LAST_MODIFIED_DATE>SYSDATE-30
  ");
  oci_execute($result);
  while ($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) {
	
	  $workQ= $row['WORK_QUEUE_ID'];
		$parent= $row['PARENT_WORK_QUEUE_ID'];
		$employeeNumber= $row['EMPLOYEE_NUMBER'];
		$owner= $row['OWNER'];
		
		echo $owner . '</br>';
		
		$result2= $local->query("Insert into Work_Queues 
		(SYS,WORK_QUEUE_ID,PARENT_WORK_QUEUE_ID,EMPLOYEE_NUMBER,OWNER)
		values
		('$sys','$workQ','$parent','$employeeNumber','$owner')
		");
	}
	
	oci_close($kpi);
	
	nextUrl("q-update-3.php");
	
?>