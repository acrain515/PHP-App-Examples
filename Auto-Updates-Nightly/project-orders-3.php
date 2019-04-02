Project Orders 3 </br>
What: RESPONSIBLE_PARTY->CREATOR,DOCUMENT_NUMBER,DESIRED_DUE_DATE,LAST_MODIFIED_DATE->LMD,LAST_MODIFIED_USER_ID->LMU,
ACTIVITY_IND </br>
From: Internal Systems </br>
For: ORDER_NUMBER (Project_Orders on Prod) </br>
To: Project_Orders (prod) </br>

</br>
<?php

  //PULLS INFO FOR ORDERS IN PROJECT ORDERS TABLE FROM INTERNAL SYSTEMS AND UPDATES PROJECT ORDERS TABLE
  require_once('../prod.php');
  require_once('../kpi.php');
	require_once('../functions.php');
  
  $result= $mysqli->query("Select SYSORD,ORDER_NUMBER,INVENTORY_SYS
  from Project_Orders
  where CREATOR=''
	and INVENTORY_SYS!='NF2'
  ");
  while($row= $result->fetch_assoc()) {
  
    $order= $row['ORDER_NUMBER'];
	  $sys= $row['INVENTORY_SYS'];
	  $sysOrd= $row['SYSORD'];
	
	  echo $order . '</br>';
	  echo $sys . '</br>';
	
	  include('../system-tables-kpi.php');
	
	  $result2 = oci_parse($kpi, "Select ORDER_NUMBER,RESPONSIBLE_PARTY,DOCUMENT_NUMBER,
	  TO_CHAR(LAST_MODIFIED_DATE,'MM/DD/YYYY') as LAST_MODIFIED_DATE,
	  TO_CHAR(DESIRED_DUE_DATE,'MM/DD/YYYY') as DESIRED_DUE_DATE,LAST_MODIFIED_USERID,ACTIVITY_IND
    from $tableSR
    where ORDER_NUMBER='$order'
	  and rownum<2
    ");
    oci_execute($result2);
    $row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);
	
	  $creator= $row2['RESPONSIBLE_PARTY'];
	  $documentNumber= $row2['DOCUMENT_NUMBER'];
	  $desiredDueDate= $row2['DESIRED_DUE_DATE'];
	  $lmd= $row2['LAST_MODIFIED_DATE'];
	  $lmu= $row2['LAST_MODIFIED_USERID'];
	  $activityInd= $row2['ACTIVITY_IND'];

	  echo $creator . '</br>';
	  echo $documentNumber . '</br>';
	  echo $desiredDueDate . '</br>';
	  echo $lmd . '</br>';
	  echo $lmu . '</br>';
	  echo $activityInd . '</br>';
	
	  $result3= $mysqli->query("Update Project_Orders set 
		CREATOR='$creator',DOCUMENT_NUMBER='$documentNumber',ORD_LMD='$lmd',ORD_LMU='$lmu',
	  DESIRED_DUE_DATE='$desiredDueDate',ACTIVITY_IND='$activityInd'
	  where SYSORD='$sysOrd'");
	
	  echo '</br>';
		
  }
	
	oci_close($kpi);
	nextUrl("project-orders-4.php");
  
?>

