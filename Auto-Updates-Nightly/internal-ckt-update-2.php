Internal Circuit Update 2 </br>
Copies INTERNAL_CKT_CLN to INTERNAL_CKT where INTERNAL_CKT is blank </br>
</br>

<?php

  //COPIES INTERNAL_CKT_CLN to INTERNAL_CKT where INTERNAL_CKT is blank

	require_once('../prod.php');
	require_once('../functions.php');
	
	$result= $mysqli->query("Select ID,INTERNAL_CKT
	from Simple
  where INTERNAL_CKT not like '%/%'
	and INTERNAL_CKT not like '%.%'
	and INTERNAL_CKT not like '%-%'
	and INTERNAL_CKT not like 'NOTFOUND%'
	and INTERNAL_CKT like '% %'
	and RATE_CODE in ('DS1','DS3')
  ");
	while($row= $result->fetch_assoc()) {
	
	  $id= $row['ID'];
	  $internalCkt= $row['INTERNAL_CKT'];
		
		echo 'Internal Ckt: ' . $internalCkt . '</br>';
		$internalCkt= clean($internalCkt);
		
		$result2= $mysqli->query("Update Simple set INTERNAL_CKT='$internalCkt' where ID='$id'");
		
		echo '</br>';
	}
	
	nextUrl("internal-ckt-update-3.php");

	
?>

