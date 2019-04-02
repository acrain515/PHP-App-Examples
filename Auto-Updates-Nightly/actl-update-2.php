ACTL NEW UPDATE </br>
</br>

<?php

  require_once('../local.php');
	require_once('../prod.php');
	require_once('../functions.php');
	
	$result= $mysqli->query("Select ID,NEW_VENDOR_CFA
	from Simple
  where NEW_VENDOR_CFA!=''
	and NEW_ACTL=''
	and STATUS not in ('COMPLETE','CANCELLED')
	and INTERNAL_ORDER != 'TBD'
	and VENDOR_CKT_CLN!=''
  ");
	if(($result)&&(mysqli_num_rows($result)>0)) {
	  while($row= $result->fetch_assoc()) {
	
	    $id= $row['ID'];
			$vendorCFA= $row['NEW_VENDOR_CFA'];
			
			echo $id . '</br>';
			echo $vendorCFA . '</br>';
			
			$vendorCFA= trim($vendorCFA);
			$vendorCFA= str_replace("/  ","/",$vendorCFA);
			$vendorCFA= str_replace("/ ","/",$vendorCFA);
			$vendorCFA= str_replace("   ","/",$vendorCFA);
			$vendorCFA= str_replace("  ","/",$vendorCFA);
			$vendorCFA= str_replace(" ","/",$vendorCFA);
		
		  if(strpos($vendorCFA,'/')!==false) {
  		  $splitCFA= explode("/",$vendorCFA); 
				
			  $count= count($splitCFA);
			  $last= $count-1;
			  $before= $count-2;
			  $aClli= $splitCFA[$before];
		    $zClli= $splitCFA[$last];
			}
			
			else {
			
			  $length= strlen($vendorCFA);
				//echo 'Length: ' . $length . '</br>';
				$start= $length-22;
				$next= $length-11;
				
				$aClli= substr($vendorCFA,$start,11);
				$zClli= substr($vendorCFA,$next,11);
			}
		
		  //echo 'ID: ' . $id . '</br>';
		  //echo 'A Clli: ' . $aClli . '</br>';
		  //echo 'Z Clli: ' . $zClli . '</br>';
		  $nineA= substr($aClli,8,1);
		  $nineZ= substr($zClli,8,1);
		
		  //echo 'NineA : ' . $nineA . '</br>';
		  //echo 'NineZ: ' . $nineZ . '</br>';
		
		  if(($nineA=='H')||($nineA=='W')) { $actl= $aClli; }
		  else if (($nineZ=='H')||($nineZ=='W')) { $actl= $zClli; }
		  else { $actl= substr($zClli,0,8); }
			
			echo $actl . '</br></br>';
			
			$result5= $mysqli->query("Update Simple set NEW_ACTL='$actl'
			where ID='$id'");
		}	
	}
	
	
	nextUrl("lata-update.php");
	
	
	
?>

