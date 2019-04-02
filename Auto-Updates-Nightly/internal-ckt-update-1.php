Internal Circuit Update </br>
COPIES INTERNAL_CKT_CLN to INTERNAL_CKT where INTERNAL_CKT is blank </br>
</br>

<?php

	require_once('../prod.php');
	require_once('../functions.php');
	
	$result= $mysqli->query("Select ID,INTERNAL_CKT_CLN
	from Simple
  where INTERNAL_CKT =''
	and INTERNAL_CKT_CLN!=''
  ");
	while($row= $result->fetch_assoc()) {
	
	  $id= $row['ID'];
	  $internalCktCln= $row['INTERNAL_CKT_CLN'];
		
		$result2= $mysqli->query("Update Simple set INTERNAL_CKT='$internalCktCln' where ID='$id'");
		
		echo '</br>';
	}
	
	nextUrl("internal-ckt-update-2.php");

	
?>

