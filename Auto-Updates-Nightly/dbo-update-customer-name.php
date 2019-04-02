DBO Update Customer Name </br>
</br>

<?php  

  require_once('../functions.php');
  require_once('../prod.php');
	require_once('../kpi.php');
	
	$today= strtotime(date("Y-m-d H:i:s"));
	$date= date("Y-m-d", strtotime("-4 days", $today));

	echo 'After: ' . $date . '</br>';
	
	$result= $mysqli->query("Select ID,LEC_CKT_CLN
	from Dbb 
	where DATE_ADDED>'$date'
	and CUSTOMER_NAME=''
	");
	while($row= $result->fetch_assoc()) {  
	
	  $id= $row['ID'];
	  $lecCkt= $row['LEC_CKT_CLN'];
		
		echo $id . '</br>';
	  echo $lecCkt . '</br>';

		$customerName= "";
		
		$result3 = oci_parse($kpi,"Select distinct FID,FID_VALUE,CIRCUIT_LOCATION,CONDENSED_EC_CIRCUIT,USOC
    from CAT.INVOICE_CABS_CSR_FID_DATA@catprd
    where INVOICE_ID>1270000
	  and FID in ('SN')
		and CONDENSED_EC_CIRCUIT='$lecCkt'
		order by CIRCUIT_LOCATION
    ");
    oci_execute($result3);
    while($row3 = oci_fetch_array($result3, OCI_ASSOC+OCI_RETURN_NULLS)) {
			
			$fid= $row3['FID'];
				
			if($fid!='') {
			
				$circuitLocation= $row3['CIRCUIT_LOCATION'];

				if($circuitLocation==1) { 
				
				  if($fid=='SN') { $customerName= $row3['FID_VALUE']; }
			  }
				
			  if($circuitLocation==2) { 
				
				  if($fid=='SN') { $customerName= $row3['FID_VALUE']; }
			  }
				
				if($circuitLocation==3) {
				
				  if($fid=='SN') { $customerName= $row3['FID_VALUE']; }
				}
			}
		}
			
		if($customerName!='') {
			
			echo 'Customer Name: ' . $customerName . '</br>';
				
			$customerName= mysqli_real_escape_string($mysqli,$customerName);
			
			$result4= $mysqli->query("Update Dbb set CUSTOMER_NAME='$customerName'
			where ID='$id'");
		}
		
		else { 
		
		  $result4= $mysqli->query("Update Dbb set CUSTOMER_NAME='NOTFOUND'
			where ID='$id'");
		}
		
		
		echo '</br>';
	}
	
	oci_close($kpi);
	
	nextUrl("dbo-update-customer-name-2.php");
	
?>

