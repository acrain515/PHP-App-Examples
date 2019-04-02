Internal Circuit Update 3 </br>
</br>

<?php

  require_once('../kpi.php');
	require_once('../prod.php');
	require_once('../functions.php');
	
	$result= $mysqli->query("Select ID,INTERNAL_CKT,PROV_SYS,VENDOR_CKT_CLN,RATE_CODE
	from Simple
  where INTERNAL_CKT not like '%/%'
	and INTERNAL_CKT not like '%.%'
	and INTERNAL_CKT not like '%-%'
	and INTERNAL_CKT not like 'NOTFOUND%'
	and RATE_CODE in ('DS1','DS3')
	order by ID desc
  ");
	while($row= $result->fetch_assoc()) {
	
	  $id= $row['ID'];
	  $internalCkt= $row['INTERNAL_CKT'];
		$sys= $row['PROV_SYS'];
		$rateCode= $row['RATE_CODE'];
		$ecID="";
		
		echo 'ID: ' . $id . '</br>';
		echo 'InternalCkt: ' . $internalCkt . '</br>';
		echo 'Sys: ' . $sys . '</br>';
		
		$search="";
		if($rateCode=='DS3') { $search= searchFromCleanDS3($internalCkt); }
		else if($rateCode=='DS1') { $search= searchFromCleanDS1($internalCkt); }
		
		if($search!='') { 
		
		  echo 'Search: ' . $search . '</br>'; 
		  if($sys!='') {  
			
			  include('../system-tables-kpi.php');
				
				$result2= oci_parse($kpi,"Select EXCHANGE_CARRIER_CIRCUIT_ID,CIRCUIT_DESIGN_ID
				from $tableCircuit
				where EXCHANGE_CARRIER_CIRCUIT_ID like '$search'
				order by CIRCUIT_DESIGN_ID desc");
	      oci_execute($result2);
	      $row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);

        $ecID= $row2['EXCHANGE_CARRIER_CIRCUIT_ID'];
        $circuitDesignID= $row2['CIRCUIT_DESIGN_ID'];
				
				if($ecID!='') { 
				
				  echo $ecID . '</br>';				
				  echo $circuitDesignID . '</br>';
					
				  $result3= $mysqli->query("Update Simple set 
				  INTERNAL_CKT='$ecID',
				  CIRCUIT_DESIGN_ID='$circuitDesignID'
				  where ID='$id'");
				}
				
				else { 
				
				  foreach($systems as $sys) { 
		
		        include('system-tables-kpi.php');
			
			      $result2 = oci_parse($kpi,"Select CIRCUIT_DESIGN_ID,EXCHANGE_CARRIER_CIRCUIT_ID
            from $tableCircuit
		        where EXCHANGE_CARRIER_CIRCUIT_ID like '$search'
			      order by CIRCUIT_DESIGN_ID desc");
            oci_execute($result2);
            $row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);
			
			      $circuitDesignID= $row2['CIRCUIT_DESIGN_ID'];
			
			      if($circuitDesignID!='') { 
			
			        $ecID= $row2['EXCHANGE_CARRIER_CIRCUIT_ID'];
				      $provSys= $sys;
			        echo 'Circuit Design ID: ' . $circuitDesignID . '</br>';
				      echo 'EC ID: ' . $ecID . '</br>';
				      echo 'Prov Sys: ' . $provSys . '</br>';
				
				      $result3= $mysqli->query("Update Simple set 
			        INTERNAL_CKT='$ecID',
			        CIRCUIT_DESIGN_ID='$circuitDesignID',
			        PROV_SYS='$provSys'
			        where ID='$id'");
				
				      break;
			      }
		      }
			  }
			}	
		}
		
		echo '</br>';
	}
	
	nextUrl("circuit-design-update.php");

	
?>

