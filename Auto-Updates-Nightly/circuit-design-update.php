Circuit Design Update </br>
</br>

<?php

  require_once('../kpi.php');
	require_once('../prod.php');
	require_once('../functions.php');
	
	$result= $mysqli->query("Select ID,INTERNAL_CKT,VENDOR_CKT_CLN,RATE_CODE
	from Simple
  where STATUS not in ('COMPLETE','CANCELLED')
  and (CIRCUIT_DESIGN_ID='' or CIRCUIT_DESIGN_ID='0')
	and INTERNAL_CKT not like 'NOTFOUND%'");
	while($row= $result->fetch_assoc()) {
	
	  $id= $row['ID'];
	  $internalCkt= $row['INTERNAL_CKT'];
		$lecCkt= $row['VENDOR_CKT_CLN'];
		$rateCode= $row['RATE_CODE'];
		
		echo 'ID: ' . $id . '</br>';
		echo 'LEC CKT: ' . $lecCkt . '</br>';
		echo 'Internal Ckt: ' . $internalCkt . '</br>';
		echo 'RateCode: ' . $rateCode . '</br>';
		
		$internalCktCln= clean($internalCkt);
		echo 'Internal Ckt Cln: ' . $internalCktCln . '</br>';
		
		$result2 = oci_parse($kpi,"Select CIRCUIT_DESIGN_ID,ASAP_INSTANCE,RATE_CODE
		from RCO.AB_CKT_COMP_STATIC
		where LEC_CKT ='$lecCkt'
	  and CIRCUIT_DESIGN_ID is not null
    and rownum<2
    ");
    oci_execute($result2);
    $row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);
			
	  $circuitDesignID= $row2['CIRCUIT_DESIGN_ID'];
			
		if($circuitDesignID!='') {
		
			echo 'Found In Static! </br>';
			echo 'Circuit Design ID: ' . $circuitDesignID . '</br>';
			
			$staticRateCode= $row2['RATE_CODE'];
			$asapInstance= $row2['ASAP_INSTANCE'];
			$sys= determineSys($asapInstance);
			
			echo 'Static Rate Code: ' . $staticRateCode . '</br>';
			echo 'Static Sys: ' . $sys . '</br>';
			
			include('../system-tables-kpi.php');
			
			$result3= oci_parse($kpi,"Select EXCHANGE_CARRIER_CIRCUIT_ID 
			from $tableCircuit 
			where CIRCUIT_DESIGN_ID='$circuitDesignID'
			");
			oci_execute($result3);
			$row3= oci_fetch_array($result3);
			
			$ecID= $row3['EXCHANGE_CARRIER_CIRCUIT_ID'];
			$ecIDCln= clean($ecID);
			echo 'ECID: ' . $ecID . '</br>';
			echo 'EcID Clean: ' . $ecIDCln . '</br>';
			
			if(($internalCktCln==$ecIDCln)&&($rateCode==$staticRateCode)) {  
			
			  echo 'Match! </br>';
				
			  $result4= $mysqli->query("Update Simple 
			  set CIRCUIT_DESIGN_ID='$circuitDesignID',
				PROV_SYS='$sys'
			  where ID='$id'");
			}
			
			else { 
			
			  $search= search($internalCkt);
		    //echo $search . '</br>';
		
		    $data= findInInventory($search,$kpi);
				
	      $circuitDesignID= $data[0];
			  $provSys= $data[2];
			
		    if($circuitDesignID!='') {
				
				  echo 'Found in Inventory! </br>';
					echo 'Circuit Design ID: ' . $circuitDesignID . '</br>';
					echo 'Prov Sys: ' . $provSys . '</br>';
					
					$result4= $mysqli->query("Update Simple 
			    set CIRCUIT_DESIGN_ID='$circuitDesignID',
				  PROV_SYS='$provSys'
			    where ID='$id'");
					
				}
			}
		}
		
		else {
		
		  $search= search($internalCkt);
		  //echo $search . '</br>';
		
		  $data= findInInventory($search,$kpi);
				
	    $circuitDesignID= $data[0];
			$provSys= $data[2];
			
		  if($circuitDesignID!='') {
				
				echo 'Found in Inventory! </br>';
		
			  echo 'Circuit Design ID: ' . $circuitDesignID . '</br>';
			  	
			  $result4= $mysqli->query("Update Simple set 
			  CIRCUIT_DESIGN_ID='$circuitDesignID',
				PROV_SYS='$provSys'
			  where ID='$id'");
			}
			
			else { 
			
			  // $result4= $mysqli->query("Update Simple set CIRCUIT_DESIGN_ID='X'
				// where ID='$id'");
			}
		}
		
		echo '</br>';
  }
	
	oci_close($kpi);
	
	nextUrl("circuit-design-update-2.php");

	
?>





