RATE CODE UPDATE 2 </br>
Finds Rate Code from Static where missing in Tracking </br>
</br>

<?php

  //DETERMINES RATE CODE WHERE MISSING

	require_once('../prod.php');
	require_once('../kpi.php');
	require_once('../functions.php');
	
	$result= $mysqli->query("Select ID,VENDOR_CKT_CLN
	from Simple
  where RATE_CODE=''
	and VENDOR_CKT_CLN!=''
	and VENDOR_CKT_CLN not like 'NOTFOUND%'");
	while($row= $result->fetch_assoc()) {
	
	  $id= $row['ID'];
		$lecCkt= $row['VENDOR_CKT_CLN'];
		$rateCode="";
		
		//echo 'ID: ' . $id . '</br>';
		//echo 'InternalCkt: ' . $internalCkt . '</br>';
		//echo 'LEC Ckt: ' . $lecCkt . '</br>';
		
		$result2= oci_parse($kpi,"Select RATE_CODE,BANDWIDTH
		from RCO.AB_CKT_COMP_STATIC
		where LEC_CKT='$lecCkt'
		and rownum<10
		order by PERIOD desc");
		oci_execute($result2);
		$row2= oci_fetch_array($result2);
		
		$rateCode= $row2['RATE_CODE'];
		if($rateCode=='') {  $rateCode= $row2['BANDWIDTH']; }
		
		if($rateCode!='') { 
		
		  echo 'RateCode: ' . $rateCode . '</br>';
			
			$result2= $mysqli->query("Update Simple set RATE_CODE='$rateCode'
			where ID='$id'");
		}
		
		echo '</br>';
	}
	
	nextUrl("internal-ckt-update-1.php");

	
?>

