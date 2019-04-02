Project Tasks 1 </br> 
What: ORDER_NUMBER,DOCUMENT_NUMBER,SYS,RATE_CODE,ACTIVITY_IND  </br> 
From: Project_Orders   </br> 
What: TASK_TYPE->TASK,WORK_QUEUE_ID->OWNER (Work_Queues local)->TASK_OWNER,DAYS_READY (calculated by release date),
SEQUENCE  </br> 
From: Internal Systems  </br> 
To: Project_Tasks </br> 
</br>

<?php

  require_once('../prod.php');
  require_once('../kpi.php');
	require_once('../functions.php');
	require_once('../local.php');
	
	$datas= array();

  $result= $mysqli->query("Select * from Project_Orders 
  where STATUS='Pending'");
  while ($row= $result->fetch_assoc()) {
  
    $order= $row['ORDER_NUMBER'];
	  $documentNumber= $row['DOCUMENT_NUMBER'];
	  $sysOrd= $row['SYSORD'];
	  $sys= $row['INVENTORY_SYS'];
	  $rateCode= $row['RATE_CODE'];
	  $activityInd= $row['ACTIVITY_IND'];
	
	  //echo $order . '</br>';
	  //echo $documentNumber . '</br>';
	  //echo $sys . '</br>';
	  
	  include('../system-tables-kpi.php');
	  
	  $result2 = oci_parse($kpi,"Select
    WORK_QUEUE_ID,TASK_TYPE,SEQUENCE,
	  TO_CHAR(ACTUAL_RELEASE_DATE,'MM/DD/YYYY') as ACTUAL_RELEASE_DATE
    from $tableTask
	  where DOCUMENT_NUMBER='$documentNumber'
	  and TASK_STATUS='Ready' and rownum<2");
	  oci_execute($result2);
    $row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);
	  
	  $workQ= $row2['WORK_QUEUE_ID'];
	  $task= $row2['TASK_TYPE'];
	  $sequence= $row2['SEQUENCE'];
	  $release= $row2['ACTUAL_RELEASE_DATE'];
	  
	  //echo $queue . '</br>';
	  //echo $task . '</br>';
	  //echo $sequence . '</br>';
	  //echo $release . '</br>';
		
		if($task!='') {
		
	    $releaseStr= strtotime($release);
	    $nowStr= strtotime("now");
	    $aging= $nowStr-$releaseStr;
	    $aging= round($aging/86400);
	    $daysReady= $aging-1;
	  
	    //echo 'Days Ready: ' . $daysReady . '</br>';
			
			
			$result3= $local->query("Select * from Work_Queues where WORK_QUEUE_ID='$workQ'");
		  $row3= $result3->fetch_assoc();
			
			$owner= $row3['OWNER'];
			
			array_push($datas,array($sys,$order,$task,$owner,$sequence,$release,$daysReady,$rateCode,$activityInd,$workQ));
			
	  }
  }
	
	oci_close($kpi);
	
	//print_r($datas);
	
	$result4= $mysqli->query("Delete from Project_Tasks");
	
	foreach($datas as $data) {
	
	  $sys= $data[0];
		$order= $data[1];
		$task= $data[2];
		$owner= $data[3];
		$sequence= $data[4];
		$release= $data[5];
		$daysReady= $data[6];
		$rateCode= $data[7];
		$activityInd= $data[8];
		$workQ= $data[9];
		
		echo 'SYS: ' . $sys . '</br>';
		echo 'Order: ' . $order . '</br>';
		echo 'Task: ' . $task . '</br>';
		echo 'Owner: ' . $owner . '</br>';
		echo 'Sequence: ' . $sequence . '</br>';
		echo 'Release: ' . $release . '</br>';
		echo 'Days Ready: ' . $daysReady . '</br>';
		echo 'Rate Code: ' . $rateCode . '</br>';
		echo 'Activit Ind: ' . $activityInd . '</br>';
	
	  $result5= $mysqli->query("Insert into Project_Tasks 
	  (SYSORD,ORDER_NUMBER,TASK_TYPE,WORK_QUEUE_ID,TASK_OWNER,SEQUENCE,RELEASE_DATE,DAYS_READY,RATE_CODE,ACTIVITY_IND)
	  values
	  ('$sys','$order','$task','$workQ','$owner','$sequence','$release','$daysReady','$rateCode','$activityInd')
	  ");
	}
	
	
	nextUrl("project-tasks-2.php");

?>


