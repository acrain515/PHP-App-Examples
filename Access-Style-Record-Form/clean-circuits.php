<?php  

  require_once('../connection.php');
	
	$result= $mysqli->query("Select ID,LEC_CKT,LEC_CKT_CLN,BAN 
	from Dbb 
	where ID<100000
	");
	while($row= $result->fetch_assoc()) {  
	
	  $id= $row['ID'];
		$lecCkt= $row['LEC_CKT'];
		
		$lecCktCln= trim(preg_replace('/[^a-zA-Z0-9\']/','',$lecCkt));
		$ban= $row['BAN'];
		
		$cbKey= $lecCktCln.''.$ban;
		
	  //echo 'ID: ' . $id . '</br>';
		//echo 'Lec Ckt: ' . $lecCkt . '</br>';
		//echo 'BAN: ' . $ban . '</br>';
		//echo 'Lec Ckt Clean: ' . $lecCktCln  . '</br>';
		//echo 'CB KEY : ' . $cbKey . '</br>';
		
		$result2= $mysqli->query("Update Dbb set 
		CB_KEY='$cbKey',
		LEC_CKT_CLN='$lecCktCln'
		where ID='$id'");
	}
	
?>
		