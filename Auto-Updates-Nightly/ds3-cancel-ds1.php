DS3 CANCEL DS1 </br>
cancels DS1 assigned to cancelled DS3s on forecast </br>
</br>

<?php  

  require_once('../prod.php');
	require_once('../functions.php');
	
	$result= $mysqli->query("Select INTERNAL_CKT_CLN,SUBPROJECT from Simple 
	where RATE_CODE='DS3' 
	and STATUS='CANCELLED'
	and INTERNAL_CKT_CLN!=''
	group by INTERNAL_CKT_CLN");
	while($row= $result->fetch_assoc()) {  
	
	  $internalCkt= $row['INTERNAL_CKT_CLN'];
		$subProject= $row['SUBPROJECT'];
		echo $internalCkt . '</br>';
		
		$result2= $mysqli->query("Update Simple set 
		STATUS='CANCELLED' 
		where RATE_CODE='DS1'
		and ASSIGNED_TO='$internalCktCln'
		and SUBPROJECT='$subProject'
		and INTERNAL_ORDER='TBD'");
	}
	
	nextUrl("ds3-pull-subs.php");
	
?>