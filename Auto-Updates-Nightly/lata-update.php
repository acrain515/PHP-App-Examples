LATA Update
<?php

  require_once('../local.php');
	require_once('../prod.php');
	require_once('../functions.php');
	
	$result= $mysqli->query("Select ID,NEW_ACTL
	from Simple
  where LATA=''
	and NEW_ACTL!=''
	and STATUS not in ('COMPLETE','CANCELLED')
	and INTERNAL_ORDER != 'TBD'
	and VENDOR_CKT_CLN!=''
  ");
	if(($result)&&(mysqli_num_rows($result)>0)) {
	  while($row= $result->fetch_assoc()) {
	
	    $id= $row['ID'];
			$newActl= $row['NEW_ACTL'];
			$clli= substr($newActl,0,8);
			
			echo $id . '</br>';
			echo $clli . '</br>';
			
		  $result2= $local->query("Select * from Clli_Lata where CLLI='$clli'");
			$row2= $result2->fetch_assoc();
			
			$lata= $row2['LATA'];
			
			echo $lata . '</br>';
			echo '</br>';
			
			if($lata!='') {
			
			  $result5= $mysqli->query("Update Simple set LATA='$lata'
			  where ID='$id'");
			}
			
			else {
			
			  $result5= $mysqli->query("Update Simple set LATA='X'
			  where ID='$id'");
			}
		}	
	}
	
	
	nextUrl("ban-update.php");
	
	
	
?>

