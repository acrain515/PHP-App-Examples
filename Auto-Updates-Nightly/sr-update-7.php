Sr Update 7 </br>
Finds LEC Ckts for Circuits not matched and LEC CKT not found in Datamart </br></br>
<?php

  $date= date("Y-m-d");
  
  require_once('../local.php');
	require_once('../kpi.php');
  require_once('../functions.php');
  
  $result= $local->query("Select * from SRTempD 
	where MATCHED=''
  and LEC_CKT_CLN in ('','NOTFOUND')
	and PLANNER!=''
	and ORDER_NUMBER!=''
	");
  while($row= $result->fetch_assoc()) {
  
	  $id= $row['ID'];
    $orderNumber= $row['ORDER_NUMBER'];
    $internalCkt= $row['INTERNAL_CKT'];
		$circuitDesignID= $row['CIRCUIT_DESIGN_ID'];
		$sys= $row['SYS'];
		$rateCode= $row['RATE_CODE'];
	
    echo $internalCkt . '</br>';
    echo 'Circuit Design ID: ' . $circuitDesignID . '</br>';
		
		include('../system-tables-kpi.php');
		
		$x=0;
		
		$result2 = oci_parse($kpi,"Select CIRCUIT_XREF_ECCKT
		from $tableCircuitXref
		where CIRCUIT_DESIGN_ID='$circuitDesignID'
		and CIRCUIT_XREF_ECCKT not like '%CFA%'
		
	  ");
    oci_execute($result2);
    while($row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS)) {
		
			$xref= $row2['CIRCUIT_XREF_ECCKT'];
					//echo 'Xref: ' . $xref  . '</br>';
					
				if($rateCode=='DS1') {  
					
					if(strpos($xref,'HC')!==false) { $lecCktFound= $xref; }
					$x++;
				}
					
				if($rateCode=='DS3') {  
					
					if(strpos($xref,'T3')!==false) { $lecCktFound= $xref; }
					$x++;
				}	
	  
    }  
		
		echo $x . '</br>';
		
		if($x==1) {
		
		  $lecCktCln= clean($xref);
			echo 'LEC Ckt Cln: ' . $lecCktCln . '</br>';
			
			$result3= $local->query("Update SRTempD set 
			LEC_CKT_CLN='$lecCktCln'
			where ID='$id'");
		}
		
		else { 
		
		  $result3= $local->query("Update SRTempD set 
			LEC_CKT_CLN='NOTFOUND2'
			where ID='$id'");
		}
		
		echo '</br>';
  }
  
  nextUrl("sr-update-8.php");

?>






