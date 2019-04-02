DS3 Finds </br></br>
<?php 

  require_once('../prod.php');
	require_once('../functions.php');
	
	$result= $mysqli->query("Select ID,LAST_UPDATE from Simple 
	where STATUS in ('PENDING PROV REVIEW','PROV REVIEW','PENDING VENDOR','PENDING FOC','FOC RECEIVED')
	and RATE_CODE!='DS1'
	and DS3_ORDER=''");
	while($row= $result->fetch_assoc()) {
	
	  $id= $row['ID'];
		$lastUpdate= $row['LAST_UPDATE'];
		
		echo $id . '</br>';
		echo $lastUpdate . '</br>';
		
		$result2= $mysqli->query("Update Simple set
		DS3_ORDER='$lastUpdate'
		where ID='$id'");
	}
	
	nextUrl("past-foc.php");
	
?>