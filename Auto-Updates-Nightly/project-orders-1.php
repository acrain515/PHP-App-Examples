Project Orders 1 </br>
What: Order Status </br>
From: Internal Systems </br>
For and To: Project_Orders (prod) </br></br>

<?php
  
  require_once('../prod.php');
  require_once('../kpi.php');
	require_once('../functions.php');
  
  
  $result= $mysqli->query("Select * from Project_Orders 
	where STATUS not in ('Complete','Canceled')
	and INVENTORY_SYS!='NF2'");
  while($row= $result->fetch_assoc()) {
  
    $documentNumber= $row['DOCUMENT_NUMBER'];
	  $sys= $row['INVENTORY_SYS'];
	  $sysOrd= $row['SYSORD'];
	
	  echo $documentNumber . '</br>';
	
	  include('../system-tables-kpi.php');

	  $result2 = oci_parse($kpi,"Select TO_CHAR(ORDER_COMPL_DT,'MM/DD/YYYY') as COMPLETE_DATE,
		SUPPLEMENT_TYPE,SUPP_CANCEL_REASON_CD,SERVICE_REQUEST_STATUS
    from $tableSR
	  where DOCUMENT_NUMBER='$documentNumber'");
	  oci_execute($result2);
    $row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);
	
	  $suppType= $row2['SUPPLEMENT_TYPE'];
	  $complete= $row2['COMPLETE_DATE'];
		$supp2= $row2['SUPP_CANCEL_REASON_CD'];
		$srStatus= $row2['SERVICE_REQUEST_STATUS'];
	
	  if($suppType==1) { $status="Canceled"; }
		else if($supp2!='') { $status="Canceled"; }
		//else if($srStatus==1) { $status="Canceled"; }
	  else if($complete!='') { $status="Complete"; }
	  else { $status= "Pending"; }
	
	
	  $result3= $mysqli->query("Update Project_Orders 
	  set STATUS='$status'
	  where SYSORD='$sysOrd'");
	
	  if($result3) { echo 'Success </br></br>'; }
	
  }
  
  oci_close($kpi);
	nextUrl("project-orders-2.php");
	
	
?>

