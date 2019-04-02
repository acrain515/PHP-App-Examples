<?php  

  require_once('../prod.php');
	require_once('../kpi.php');
	
	$today= strtotime(date("Y-m-d H:i:s"));
	$date= date("Y-m-d", strtotime("-2 months", $today));
	
	echo 'After: ' . $date . '</br>';
	
	$result= oci_parse($kpi, "Select max(PERIOD) as MAX_PERIOD
  from RCO.AB_CKT_COMP_STATIC
  ");
	oci_execute($result);
	$row= oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS);
	
	$maxPeriod= $row['MAX_PERIOD'];
	$maxPeriod= date("m/d/Y",strtotime($maxPeriod));
	
	echo 'Max Period: ' . $maxPeriod . '</br>';
	
	$result= $mysqli->query("Select ID,VENDOR_CKT_CLN,BAN,NEW_MRC	from Simple 
	where STATUS not in ('COMPLETE','CANCELLED')
	and VENDOR_CKT_CLN!='' 
	and VENDOR_CKT_CLN!='NOTFOUND'
	and BAN!=''
	and (LAST_UPDATE>'$date'  or DATE_ADDED>'$date')
	");
	while($row= $result->fetch_assoc()) {  
	
	  $id= $row['ID'];
	  $lecCkt= $row['VENDOR_CKT_CLN'];
		$ban= $row['BAN'];
		$newMRC= $row['NEW_MRC'];
		
		$newMRC= str_replace(",","",$newMRC);
		
		echo $lecCkt . '</br>';
		echo 'New MRC: ' . $newMRC . '</br>';
		
		$result2= oci_parse($kpi, "Select MRC
    from RCO.AB_CKT_COMP_STATIC
    where LEC_CKT='$lecCkt'
		and BAN='$ban'
    and PERIOD=TO_DATE('$maxPeriod','MM/DD/YYYY')
    ");
		oci_execute($result2);
		$row2= oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);
		
		$mrc= $row2['MRC'];
		
		echo 'MRC: ' . $mrc . '</br>';
		
		if($mrc=='') { 
		
		  echo 'Check without BAN </br>';
			
			$result2= oci_parse($kpi, "Select MRC
      from RCO.AB_CKT_COMP_STATIC
      where LEC_CKT='$lecCkt'
      and PERIOD=TO_DATE('$maxPeriod','MM/DD/YYYY')
      ");
		  oci_execute($result2);
		  $row2= oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);
		
		  $mrc= $row2['MRC'];
			
			echo 'MRC: ' . $mrc . '</br>';
		}	
			
		
		if($mrc!='') {  
			
			if($newMRC!='') { 
			
			  $savings= $mrc-$newMRC;
				
				if($savings<0) {  
				  $savings= '0.00'; 
					$newMRC= $mrc;
					
					echo 'New MRC: ' . $newMRC . '</br>';
				}
			}
			
			else { $savings= '0.00'; }
			
			echo 'Savings: ' . $savings . '</br>';
			
			$result3= $mysqli->query("Update Simple set 
			MRC='$mrc',NEW_MRC='$newMRC',SAVINGS='$savings'
			where ID='$id'");
		}
		
		echo '</br>';
	}
	
	
?>
	