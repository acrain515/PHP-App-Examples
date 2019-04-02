DBO Update Customer Name 2 </br>
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
	and CUSTOMER_NAME='NOTFOUND'
	");
	while($row= $result->fetch_assoc()) {  
	
	  $id= $row['ID'];
	  $lecCkt= $row['LEC_CKT_CLN'];
		
		echo $id . '</br>';
	  echo $lecCkt . '</br>';

		$customerName= "NOTFOUND";
		
		$result3= oci_parse($kpi,"Select CUST_NAME
		from rco.ab_enterprise_smb_2015
    where LEC_CKT='$lecCkt'
		and CUST_NAME is not null
		and rownum<2");
		oci_execute($result3);
		$row3 = oci_fetch_array($result3, OCI_ASSOC+OCI_RETURN_NULLS);
			
		$customerName= $row3['CUST_NAME'];
			
		if($customerName!='') {
			
			echo 'Customer Name: ' . $customerName . '</br>';
				
			$customerName= mysqli_real_escape_string($mysqli,$customerName);
			
			$result4= $mysqli->query("Update Dbb set CUSTOMER_NAME='$customerName'
			where ID='$id'");
		}
		
		else { 
		
		  $result4= $mysqli->query("Update Dbb set CUSTOMER_NAME=''
			where ID='$id'");
		}
		
		
		echo '</br>';
	}
	
	oci_close($kpi);
	
	nextUrl("dbo-update-address.php");
	
?>

