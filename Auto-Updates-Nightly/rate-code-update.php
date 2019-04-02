RATE CODE UPDATE </br>
Determines Rate Code from Internal Circuit parts where RATE_CODE is blank in tracking </br>
</br>

<?php

	require_once('../prod.php');
	require_once('../functions.php');
	
	$result= $mysqli->query("Select ID,INTERNAL_CKT_CLN,VENDOR_CKT_CLN
	from Simple
  where RATE_CODE=''");
	while($row= $result->fetch_assoc()) {
	
	  $id= $row['ID'];
	  $internalCkt= $row['INTERNAL_CKT_CLN'];
		$lecCkt= $row['VENDOR_CKT_CLN'];
		$rateCode="";
		
		echo 'ID: ' . $id . '</br>';
		echo 'InternalCkt: ' . $internalCkt . '</br>';
		echo 'LEC Ckt: ' . $lecCkt . '</br>';
		
		
		
		if(
		(stripos($internalCkt,'T3')!==false)
		||(stripos($lecCkt,'T3')!==false)
		||(stripos($lecCkt,'DS3')!==false)
		||((stripos($lecCkt,'FRO')!==false)&&(stripos($lecCkt,'CL3')!==false))
		||(stripos($lecCkt,'T3')!==false)
		||(stripos($lecCkt,'HFGS')!==false)
		) {
		
		  $rateCode= "DS3";
		}
		
		else if(
		(stripos($internalCkt,'T1')!==false)
		||(stripos($internalCkt,'HC')!==false)
		||(stripos($lecCkt,'DS1')!==false)
		||(stripos($lecCkt,'HC')!==false)
		) {
		
		  $rateCode= "DS1";
		}
		
		if($rateCode!='') { 
		
		  echo 'RateCode: ' . $rateCode . '</br>';
			
			$result2= $mysqli->query("Update Simple set RATE_CODE='$rateCode'
			where ID='$id'");
		}
		
		echo '</br>';
	}
	
	nextUrl("rate-code-update-2.php");

	
?>

