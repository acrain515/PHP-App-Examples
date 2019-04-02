Circuit Design Update 2 </br>
</br>

<?php

  require_once('../kpi.php');
	require_once('../prod.php');
	require_once('../functions.php');
	
	$result= $mysqli->query("Select ID,INTERNAL_CKT_CLN,RATE_CODE
	from Simple
  where STATUS not in ('COMPLETE','CANCELLED')
  and CIRCUIT_DESIGN_ID='X'
	and INTERNAL_CKT_CLN!=''
	and INTERNAL_CKT_CLN not like 'NOTFOUND'
	and RATE_CODE!=''
	limit 500");
	while($row= $result->fetch_assoc()) {
	
	  $id= $row['ID'];
	  $internalCktCln= $row['INTERNAL_CKT_CLN'];
		$rateCode= $row['RATE_CODE'];
	
	  echo 'ID: ' . $id . '</br>';
		echo 'Internal Ckt Cln: ' . $internalCktCln . '</br>';
		$search="";
		$circuitDesignID="";
		
		if($rateCode=='DS1') {  
		
		  $search= searchFromCleanDS1($internalCktCln);
		}
		
		else if ($rateCode=='DS3') { 
		
		  $search= searchfromCleanDS3($internalCktCln);
		}
		
		echo 'Search: ' . $search . '</br>';
		
		if($search!='') {
		  $data= findInInventory($search,$kpi);
		
		  $circuitDesignID= $data[0];
		  $provSys= $data[2];
		
		  if($circuitDesignID!='') {
		
			  echo 'Circuit Design ID: ' . $circuitDesignID . '</br>';
			  	
			  $result4= $mysqli->query("Update Simple set 
		    CIRCUIT_DESIGN_ID='$circuitDesignID',
			  PROV_SYS='$provSys'
			  where ID='$id'");
		  }
			
		  else { 
			
			  $result4= $mysqli->query("Update Simple set CIRCUIT_DESIGN_ID='NF'
			  where ID='$id'");
		  }
		}
		
    else { 
			
			$result4= $mysqli->query("Update Simple set CIRCUIT_DESIGN_ID='NF'
			where ID='$id'");
		}
		
		echo '</br>';
	}
	
	oci_close($kpi);
	
	nextUrl("billing-info-update.php");

	
?>

