CFA UPDATE 2 </br>
</br>

<?php

  require_once('../local.php');
  require_once('../kpi.php');
	require_once('../prod.php');
	require_once('../functions.php');
	
	$result= $mysqli->query("Select * from Project_Tasks
	where TASK_TYPE in ('REVIEW')
	");
	while($row= $result->fetch_assoc()) {
	
	  $order= $row['ORDER_NUMBER'];
		
		echo '<b>Order:</b> ' . $order . '</br>';
		
		$result2= $mysqli->query("Select * from Simple
		where INTERNAL_ORDER='$order'
		and CIRCUIT_DESIGN_ID!=''
		and CIRCUIT_DESIGN_ID!='X'
		and PROV_SYS='PAE'  
		and STATUS!='CANCELLED'
		");
	  if(($result2)&&(mysqli_num_rows($result2)>0)) {
	    while($row2= $result2->fetch_assoc()) {
	
	      $id= $row2['ID'];
	      $circuitDesignID= $row2['CIRCUIT_DESIGN_ID'];
		    $sys= $row2['PROV_SYS'];
			  $status= $row2['STATUS'];
		  
			  echo 'ID: ' . $id . '</br>';
		    echo 'Circuit Design ID: ' . $circuitDesignID . '</br>';
		    echo 'Sys: ' . $sys . '</br>';
			  echo 'Utopia Status: ' . $status . '</br>';
		
		    include('../system-tables-kpi.php');
		
		    $result3 = oci_parse($kpi,"Select FAC_MIG_OLD_CFA
        from $tableUserData
        where CIRCUIT_DESIGN_ID='$circuitDesignID'
        and rownum<2
        ");
        oci_execute($result3);
        $row3 = oci_fetch_array($result3, OCI_ASSOC+OCI_RETURN_NULLS);
			
		    $vendorCFA= $row3['FAC_MIG_OLD_CFA'];
			
		    if($vendorCFA!='') {
			
			    echo 'Vendor CFA: ' . $vendorCFA . '</br>';
			
			    $result4= $mysqli->query("Update Simple
			    set VENDOR_CFA='$vendorCFA'
			    where ID='$id'");	
				}
		  }
			
			echo '</br>';
			
		//END WHILE	
	  }
		
	//END IF ROWS>0
	}
	
	oci_close($kpi);
	nextUrl("cfa-new-update.php");
	
	
	
?>

