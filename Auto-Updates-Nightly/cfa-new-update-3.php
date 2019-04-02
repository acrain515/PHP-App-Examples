CFA UPDATE NEW 3 </br>
Get NEW VENDOR CFA for Circuits added from SRTEMPD </br>
</br>

<?php

  require_once('../local.php');
  require_once('../kpi.php');
	require_once('../prod.php');
	require_once('../functions.php');
	
	$today= strtotime(date("Y-m-d H:i:s"));
	$date= date("Y-m-d", strtotime("-4 days", $today));
	
	$result= $mysqli->query("Select * from Simple
	where DATE_ADDED>'$date'
	and INTERNAL_ORDER!='TBD'
	and NEW_VENDOR_CFA=''
	");
	while($row= $result->fetch_assoc()) {
	
	  $id= $row['ID'];
	  $internalOrder= $row['INTERNAL_ORDER'];
		$circuitDesignID= $row['CIRCUIT_DESIGN_ID'];
		$sys= $row['PROV_SYS'];
		$readyTask= "";
		
		
		echo '<b>Internal Order:</b> ' . $internalOrder . '</br>';
		echo 'Sys: ' . $sys . '</br>';
		echo 'CircuitDesignID: ' . $circuitDesignID . '</br>';
		
		$result2= $mysqli->query("Select * from Project_Tasks
		where ORDER_NUMBER='$internalOrder'
		and TASK_TYPE not in ('APP','FORECST')
		");
	  $row2= $result2->fetch_assoc();
	  $readyTask= $row2['TASK_TYPE'];
			
	  if($readyTask!='') {
			
			echo 'Ready Task: ' . $readyTask . '</br>';
		  include('../system-tables-kpi.php');
		
		  $result3 = oci_parse($kpi,"Select FAC_MIG_NEW_CFA
      from $tableUserData
      where CIRCUIT_DESIGN_ID='$circuitDesignID'
      and rownum<2
      ");
      oci_execute($result3);
      $row3 = oci_fetch_array($result3, OCI_ASSOC+OCI_RETURN_NULLS);
			
		  $newVendorCFA= $row3['FAC_MIG_NEW_CFA'];
			
		  if($newVendorCFA!='') {
			
			  echo 'New Vendor CFA: ' . $newVendorCFA . '</br>';
			
			  $result4= $mysqli->query("Update Simple
			  set NEW_VENDOR_CFA='$newVendorCFA'
			  where ID='$id'");	
		  }
		}
			
	  echo '</br>';
			
  //END WHILE	
	}
		
	oci_close($kpi);
	nextUrl("actl-update-1.php");
	
	
	
?>

