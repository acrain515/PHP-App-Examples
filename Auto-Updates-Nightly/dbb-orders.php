DBB Orders </br>
Updates Internal Order in Tracking for Dbb Circuits </br>
</br>

<?php  

  require_once('../prod.php');
	require_once('../functions.php');
	
	$result= $mysqli->query("Select ID,VENDOR_CKT_CLN,BAN
	from Simple 
	where PROJECT='Dbb'
	and INTERNAL_ORDER='TBD'
	");
	while($row= $result->fetch_assoc()) {  
	
	  $id= $row['ID'];
    $lecCkt= $row['VENDOR_CKT_CLN'];
		$ban= $row['BAN'];

		echo 'ID: ' . $id . '</br>';
		echo 'LEC CKT: ' . $lecCkt . '</br>';
		echo 'BAN: ' . $ban . '</br>';
		
	  $result2= $mysqli->query("Select LEC_ORDER from Dbb where LEC_CKT='$lecCkt' and BAN='$ban'");
		$row2= $result2->fetch_assoc();
		
		$internalOrder= $row2['LEC_ORDER'];
		
		echo 'Internal Order: ' . $internalOrder . '</br>';
		
		if($internalOrder!='') {  
		
		  $result3= $mysqli->query("Update Simple set 
			INTERNAL_ORDER='$internalOrder' 
			where ID='$id'");
		}
	
		echo '</br>';
	}
	
	nextUrl("http://utopia.dev.windstream.com:8080/dbb-copy.php");
	
	
?>



