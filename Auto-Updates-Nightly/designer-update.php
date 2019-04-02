Designer Update </br>
finds designer by DESIGN task in MSS for Internal Order assigned in Tracking table </br>
</br>

<?php

  require_once('../prod.php');
  require_once('../local.php');
  require_once('../kpi.php');
	require_once('../functions.php');
	
	$today= strtotime(date("Y-m-d H:i:s"));
	$date= date("Y-m-d H:i:s", strtotime("-3 months", $today));

	echo 'After: ' . $date . '</br>';
	
	$result= $mysqli->query("Select INTERNAL_ORDER,PROV_SYS from Simple
	where DESIGNER='' 
	and (PROV_SYS='NVX' or PROV_SYS='PAE')
	and STATUS not in ('COMPLETE','CANCELLED')
	and INTERNAL_ORDER!='TBD'
	and (DATE_ADDED>'$date' or LAST_UPDATE>'$date')
	group by INTERNAL_ORDER
	");
	while($row= $result->fetch_assoc()) {
	
	  $internalOrder= $row['INTERNAL_ORDER'];
		$sys= $row['PROV_SYS'];
		
		echo 'Internal Order: ' . $internalOrder . '</br>';
		echo 'Sys: ' . $sys . '</br>';
		
		include('../system-tables-kpi.php');
  
    $result2 = oci_parse($kpi, "Select distinct a.WORK_QUEUE_ID
    from $tableTask a
    left join $tableSR b
    on a.DOCUMENT_NUMBER=b.DOCUMENT_NUMBER
    where WORK_QUEUE_ID is not null
    and WORK_QUEUE_ID not in ('SVGSPRV','SVGSDES')		
		and TASK_TYPE in ('DESIGN','FORECST')
		and b.ORDER_NUMBER='$internalOrder'
		and rownum<2
    ");
    oci_execute($result2);
    $row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);

    $workQ= $row2['WORK_QUEUE_ID'];
    if($workQ!='') {
			
			echo 'Work Q: ' . $workQ . '</br>';
				
			$result3= $local->query("Select * from Work_Queues
			where WORK_QUEUE_ID='$workQ'");
			$row3= $result3->fetch_assoc();
				
			$owner= $row3['OWNER'];
			echo 'Owner: ' . $owner . '</br>';
					
			$result4= $mysqli->query("Update Simple set 
			DESIGNER='$owner'
			where INTERNAL_ORDER='$internalOrder'");
	  }
		
		echo '</br>';
	}
	

  oci_close($kpi);
	
	nextUrl("prov-update.php");
  
  
?>



