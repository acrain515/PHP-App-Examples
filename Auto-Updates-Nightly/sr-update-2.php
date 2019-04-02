SR UPDATE NEW 2 </br>
Gets Order Status from inventory System </br>
<?php  

	require_once('../local.php');
	require_once('../kpi.php');
	require_once('../functions.php');
	
	$date= date("Y-m-d");
	
	$result= $local->query("Select * from SRTempC where STATUS in ('','PENDING')");
	while($row= $result->fetch_assoc()) { 
	
	  $id= $row['ID'];
	  $documentNumber= $row['DOCUMENT_NUMBER'];
		$sys= $row['SYS'];
		
		echo 'DocumentNumber: ' . $documentNumber . '</br>';
		
		include('../system-tables-kpi.php');
		
		$result2 = oci_parse($kpi,"Select SUPPLEMENT_TYPE,SERVICE_REQUEST_STATUS,
		SUPP_CANCEL_REASON_CD,ORDER_COMPL_DT,ACTIVITY_IND
    from $tableSR
    where DOCUMENT_NUMBER='$documentNumber'");
    oci_execute($result2);
    while($row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS)) {
  
      $suppType= $row2['SUPPLEMENT_TYPE'];
			$status= $row2['SERVICE_REQUEST_STATUS'];
			$cancelReason= $row2['SUPP_CANCEL_REASON_CD'];
			$completeDate= $row2['ORDER_COMPL_DT'];
			$activityInd= $row2['ACTIVITY_IND'];
			
			echo 'Status: ' . $status . '</br>';
			
			if($status!='') {
			  if($completeDate!='') { $orderStatus= "COMPLETE"; }
			  else if(($suppType==1)||($cancelReason!='')) { $orderStatus= "CANCELED"; }
			  else { $orderStatus= "PENDING"; }
			}
			else { $orderStatus= "PENDING"; }
			
			$result3= $local->query("Update SRTempC set 
			STATUS='$orderStatus' 
			where ID='$id'");
			
			if($activityInd=='N') { 
			
			  $result4= $local->query("Delete from SRTempC where ID='$id'");
      }					
    }
		
		echo '</br>';
	}
	
	oci_close($kpi);
	nextUrl("sr-update-3.php");
	
	
?>
