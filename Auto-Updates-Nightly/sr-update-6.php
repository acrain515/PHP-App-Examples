Sr Update 6 </br>
Adds LEC_CKT to SRTempD for Circuits not found Tracking Table
<?php

  $date= date("Y-m-d");
  
  require_once('../local.php');
	require_once('../kpi.php');
  require_once('../functions.php');
  
  $result= $local->query("Select * from SRTempD 
	where MATCHED=''
	and LEC_CKT_CLN=''
	and PLANNER!=''
	and ORDER_NUMBER!=''
	");
  while($row= $result->fetch_assoc()) {
  
	  $id= $row['ID'];
    $orderNumber= $row['ORDER_NUMBER'];
    $internalCkt= $row['INTERNAL_CKT'];
		$circuitDesignID= $row['CIRCUIT_DESIGN_ID'];
		$sys= $row['SYS'];
		$planner= $row['PLANNER'];
		
		if($sys=='PAE') { $asapInstance= "PT-MSS"; }
		else if ($sys=='NVX') { $asapInstance= "NV-MSS"; }
		else if($sys=='WIN') { $asapInstance= "WS-MSS"; }
		else if($sys=='TSG') { $asapInstance= "TSG"; }
		
		$internalCktCln= clean($internalCkt);
	
    echo 'INTERNALCKT: ' . $internalCkt . '</br>';
    echo 'Circuit Design ID: ' . $circuitDesignID . '</br>';
	
		$circuits= array();
		$result2 = oci_parse($kpi,"Select LEC_CKT,BAN,AMOUNT_PAID,VENDOR_GRP
		from RCO.AB_CKT_COMP_UNIQUE
		where CIRCUIT_DESIGN_ID='$circuitDesignID'
		and ASAP_INSTANCE='$asapInstance'
	  ");
    oci_execute($result2);
    $row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);
		
		$lecCkt= $row2['LEC_CKT'];
	  $ban= $row2['BAN'];
		$mrc= $row2['AMOUNT_PAID'];
		$vendor= $row2['VENDOR_GRP'];
			
		echo 'LEC Ckt: ' . $lecCkt . '</br>';
		echo 'BAN: ' . $ban . '</br>';
		echo 'MRC: ' . $mrc . '</br>';
		echo 'Vendor: ' . $vendor . '</br>';
	
    if($lecCkt!='') {
		
		  $result3= $local->query("Update SRTempD set 
			LEC_CKT_CLN='$lecCkt',BAN='$ban',MRC='$mrc',VENDOR='$vendor'
			where ID='$id'");
		}
		
		else {  
		
		  $result3= $local->query("Update SRTempD set 
			LEC_CKT_CLN='NOTFOUND'
			where ID='$id'");
		}
		
		
		
		echo '</br>';
  }
  
  nextUrl("sr-update-7.php");

?>




