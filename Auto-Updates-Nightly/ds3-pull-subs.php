DS3 PULL SUBS </br>
Adds DS1s to forecast for DS3s on forecast not in PENDING CAPITAL BUILD or CANCELLED status </br>
</br>

<style>
* { font-family: Arial; }
</style>
<?php 
		
		require_once('../prod.php');
		require_once('../kpi.php');
		require_once('../functions.php');
		
		$date= date("Y-m-d h:i:s");
    echo 'Date: ' . $date . '</br>';	
		
		$result= $mysqli->query("Select INTERNAL_CKT,INTERNAL_CKT_CLN,CIRCUIT_DESIGN_ID,PROV_SYS,PROJECT,SUBPROJECT,PLANNER
		from Simple
		where RATE_CODE='DS3' 
		and INTERNAL_ORDER='TBD'
		and STATUS not in ('PENDING CAPITAL BUILD','CANCELLED')");
		while($row= $result->fetch_assoc()) {
		
		  $internalCkt= $row['INTERNAL_CKT'];
		  $internalCktCln= $row['INTERNAL_CKT_CLN'];
		  $circuitDesignID= $row['CIRCUIT_DESIGN_ID'];
		  $sys= $row['PROV_SYS'];
		  $project= $row['PROJECT'];
		  $subProject= $row['SUBPROJECT'];
		  $planner= $row['PLANNER'];
		
		  $parts= explode("/",$internalCkt);
		
		  echo 'Ds3 Circuit Design ID: ' . $circuitDesignID . '</br>';
		  echo 'Sys: ' . $sys . '</br>';
		  echo 'Project: ' . $project . '</br>';
		  echo 'SubProject: ' . $subProject . '</br>';
		  echo 'Planner: ' . $planner . '</br>';
		
		  $asap= determineAsap($sys);
		
		  echo 'Asap: ' . $asap . '</br>';
		
		  echo '</br>';
		
		  include('../system-tables-kpi.php');
		
		  //LOOK FOR CIRCUIT DESIGN IDS ASSIGNED TO DS3 IN INVENTORY
	    $result2 = oci_parse($kpi, "Select c.CIRCUIT_DESIGN_ID,c.EXCHANGE_CARRIER_CIRCUIT_ID,cp.CIRCUIT_POSITION_NUMBER 
		  from $tableCircuitPosition cp
		  left join $tableCircuit c
		  on cp.CIRCUIT_DESIGN_ID_3=c.CIRCUIT_DESIGN_ID
	    where cp.CIRCUIT_DESIGN_ID='$circuitDesignID' 
		  and cp.CIRCUIT_DESIGN_ID_3 is not null
		  and c.STATUS!='8'");
      oci_execute($result2);
      while($row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS)) {
		  
	      $ds1DesignID= $row2['CIRCUIT_DESIGN_ID'];
			  $ds1InternalCkt= $row2['EXCHANGE_CARRIER_CIRCUIT_ID'];
			  $ds1InternalCktCln= clean($ds1InternalCkt);
			  $port= $row2['CIRCUIT_POSITION_NUMBER'];
			
			  $internalCFA= trim(preg_replace('/[^a-zA-Z0-9\']/','',$parts[0]));
			  $internalCFA.= '/' . $port . '/';
			  $internalCFA.= trim(preg_replace('/[^a-zA-Z0-9\']/','',$parts[1])) . '/';
			  $internalCFA.= trim(preg_replace('/[^a-zA-Z0-9\']/','',$parts[2])) . '/';
			  $internalCFA.= trim(preg_replace('/[^a-zA-Z0-9\']/','',$parts[3]));
			
		    echo 'Ds1 Design ID: ' . $ds1DesignID . '</br>';
			  echo 'Internal Ckt: ' . $ds1InternalCkt . '</br>';
			  echo 'Internal Ckt Cln: ' . $ds1InternalCktCln . '</br>';
			  echo 'Internal CFA: ' . $internalCFA . '</br>';
			
			  //CHECK IF ALREADY ON FORECAST
			  $resultC= $mysqli->query("Select count(*) as THE_COUNT,ID,ASSIGNED_TO,SUBPROJECT from Simple 
			  where INTERNAL_CKT_CLN='$ds1InternalCktCln'
			  and STATUS not in ('CANCELLED')");
			  $rowC= $resultC->fetch_assoc();
			  $theCount= $rowC['THE_COUNT'];
			  $idFound= $rowC['ID'];
			  $subProjectFound= $rowC['SUBPROJECT'];
			  $assignedToFound= $rowC['ASSIGNED_TO'];
			
			  if($theCount>0) {  
			
			    echo '<b>Already on Forecast</b></br>'; 
				  echo 'SubProject: ' . $subProjectFound . '</br>';
				  echo 'Assigned To: ' . $assignedToFound . '</br>';
				
				  if($assignedToFound=='') { 
				
				    $result3= $mysqli->query("Update Simple set ASSIGNED_TO='$internalCktCln'
					  where ID='$idFound'");
					  echo 'Added DS3 Assigned to for this DS1. </br>';
				  }
				
				  if($subProjectFound!=$subProject) { 
				
				    $result3= $mysqli->query("Update Simple set SUBPROJECT='$subProject'
					  where ID='$idFound'");
					  echo 'Changed Project for this DS1. </br>';
				  }
			  }
			
			  else { 
			
			    if($ds1DesignID!='') {  
				
				    //FOREACH NEW DS1 DESIGN, FIND LEC CKT INFO IN STATIC
			      $result3 = oci_parse($kpi, "Select LEC_CKT,BAN,MRC,VENDOR_GRP
		        from RCO.AB_CKT_COMP_STATIC
            where CIRCUIT_DESIGN_ID='$ds1DesignID'
            and ASAP_INSTANCE='$asap'				
		        order by PERIOD desc");
            oci_execute($result3);
            $row3 = oci_fetch_array($result3, OCI_ASSOC+OCI_RETURN_NULLS);
				
				    $lecCkt= $row3['LEC_CKT'];
				
				    if($lecCkt!='') { 
				      $ban= $row3['BAN'];
				      $mrc= $row3['MRC'];
					    $newMRC= $mrc;
					    $savings= "0.00";
					    $vendor= $row3['VENDOR_GRP'];
				    }
				
				    else { 
				      $ban= "";
					    $mrc= "0.00";
					    $newMRC= "0.00";
					    $savings= "0.00";
					    $vendor= "";
				    }
				
				    $lecCktCln= clean($lecCkt);
				
				    echo 'LecCkt: ' . $lecCkt . '</br>';
				    echo 'BAN: ' . $ban . '</br>';
				    echo 'MRC: ' . $mrc . '</br>';
				    echo 'VENDOR: ' . $vendor . '</br>';
				    echo 'New MRC: ' . $newMRC . '</br>';
				    echo 'Savings: ' . $savings . '</br>';
				
				    echo '<b>Added to Forecast</b></br>';
				
				    $result4= $mysqli->query("Insert into Simple 
				    (INTERNAL_ORDER,INTERNAL_CKT,INTERNAL_CKT_CLN,CIRCUIT_DESIGN_ID,PROV_SYS,
				    INTERNAL_CFA,RATE_CODE,ASSIGNED_TO,
				    VENDOR_CKT,VENDOR_CKT_CLN,BAN,VENDOR,MRC,NEW_MRC,SAVINGS,
				    PLANNER,PROJECT,SUBPROJECT,DATE_ADDED,STATUS,ON_FORECAST,FIN_FCAST)
				    values
				    ('TBD','$ds1InternalCkt','$ds1InternalCktCln','$ds1DesignID','$sys',
				    '$internalCFA','DS1','$internalCktCln',
				    '$lecCkt','$lecCktCln','$ban','$vendor','$mrc','$newMRC','$savings',
				    '$planner','$project','$subProject','$date','IDENTIFIED','n','n')
				    ");	
			    }
			  }
				
			  echo '</br>';  
			
		  }
	  }
	
	oci_close($kpi);
	
	nextUrl("savings.php");
	
?>