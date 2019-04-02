LOOP TYPE UPDATE
<?php

  require_once('../local.php');
	require_once('../prod.php');
	require_once('../functions.php');
	
	$result= $mysqli->query("Select ID,VENDOR_CKT_CLN
	from Simple
  where VENDOR_CKT_CLN!='' and NEW_LOOP_TYPE=''
  ");
	if(($result)&&(mysqli_num_rows($result)>0)) {
	  while($row= $result->fetch_assoc()) {
	
	    $id= $row['ID'];
			$lecCkt= $row['VENDOR_CKT_CLN'];
			
			echo $id . '</br>';
			echo $lecCkt . '</br>';
			
			if(strpos($lecCkt,'HCGS')!==false) { $type= "SPA"; }
			else if (strpos($lecCkt, 'HCFD')!==false) { $type= "EEL"; }
			else { ($type= "UNE"); }
			
			echo $type . '</br>';
			
			$result5= $mysqli->query("Update Simple set NEW_LOOP_TYPE='$type'
			where ID='$id'");
		}	
	}
	
	
	nextUrl("dbo-update-bill-sys-acct.php");
	
	
	
?>

