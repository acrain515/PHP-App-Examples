DBO Update Internal Ckt </br>
</br>

<?php  

  require_once('../functions.php');
  require_once('../prod.php');
	require_once('../kpi.php');
	
	$today= strtotime(date("Y-m-d H:i:s"));
	$date= date("Y-m-d", strtotime("-4 days", $today));

	echo 'After: ' . $date . '</br>';
	
	$result= $mysqli->query("Select ID,LEC_CKT_CLN
	from Dbb 
	where DATE_ADDED>'$date'
	and INTERNAL_CKT=''
	");
	while($row= $result->fetch_assoc()) {  
	
	  $id= $row['ID'];
	  $lecCkt= $row['LEC_CKT_CLN'];
		
		echo $id . '</br>';
	  echo $lecCkt . '</br>';
		
		
		$result2 = oci_parse($kpi,"Select EXCHANGE_CARRIER_CIRCUIT_ID,ASAP_INSTANCE,CIRCUIT_DESIGN_ID,CKT_STATUS_DESC
		from RCO.AB_CKT_COMP_STATIC
		where LEC_CKT='$lecCkt'
		order by PERIOD desc
    ");
    oci_execute($result2);
    $row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);
		  
    $internalCkt= $row2['EXCHANGE_CARRIER_CIRCUIT_ID'];	
			
		if($internalCkt!='') {
		
		  $asap= $row2['ASAP_INSTANCE'];
      $invSys= determineSys($asap);
		  $invCktStatus= $row2['CKT_STATUS_DESC'];
		  $circuitDesignID= $row2['CIRCUIT_DESIGN_ID'];
		
		  echo 'NewInternalCkt: ' . $internalCkt . '</br>';
		  echo 'NewInvSys: ' . $asap . '</br>';
		  echo 'NewInvCktStatus: ' . $invCktStatus . '</br>';
		  echo 'NewCircuitDesignID: ' . $circuitDesignID . '</br>';
		    

			$result3= $mysqli->query("Update Dbb set
			INTERNAL_CKT='$internalCkt',
			INV_SYS='$invSys',
			INV_CKT_STATUS='$invCktStatus',
			CIRCUIT_DESIGN_ID='$circuitDesignID'
			where ID='$id'");
		}
		
		else {  
		
		  echo 'NotFound.</br>';
		  $result3= $mysqli->query("Update Dbb set
			INTERNAL_CKT='NOTFOUND'
			where ID='$id'");
		}
		
		
		echo '</br>';
	}
	
	oci_close($kpi);
	
	nextUrl("dbo-update-bill-status.php");
	
?>

