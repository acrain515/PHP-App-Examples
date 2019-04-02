DBO Update Bill Acct Status </br>
</br>

<?php  

  require_once('../functions.php');
  require_once('../prod.php');
	require_once('../sandbox.php');
	
	$today= strtotime(date("Y-m-d H:i:s"));
	$date= date("Y-m-d", strtotime("-4 days", $today));
	echo 'Date: ' . $date . '</br>';

	$result= $mysqli->query("Select * from Dbb
	where BILL_ACCT!='0' and BILL_ACCT!='999999999'
	and BILL_SYS in ('RC8','RC7')
	and (BILL_ACCT_STATUS='' or BILL_ACCT_STATUS='X')
	and DATE_ADDED>'$date'
	");
	while($row= $result->fetch_assoc()) { 
	
	  $id= $row['ID'];
	  $billAcct= $row['BILL_ACCT'];
	  $billSys= $row['BILL_SYS'];
		$customerName= $row['CUSTOMER_NAME'];
		$dateAdded= $row['DATE_ADDED'];
		
		echo 'ID: ' . $id . '</br>';
		echo 'DateAdded: ' . $dateAdded . '</br>';
		echo $billAcct . '</br>';
		echo $billSys . '</br>';
		echo 'CustomerName: ' . $customerName . '</br>';
		
		if($billSys=='RC8') { 
		
		  $result2= oci_parse($sandbox,"Select STAT,SUB_NM
		  from WASABI.V_SUB@bp01
      where SUB_ID='$billAcct'");
		  oci_execute($result2);
		  $row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);
			
			$status= $row2['STAT'];
			if($status!='') {  
			
			  if($status=='I') { $billStatus= "Disconnected"; }
				else { $billStatus= "In Service"; }
				
				if(($customerName=='')||($customerName=='NOT FOUND')) { 
				  $customerName= $row2['SUB_NM'];
				}
				
				echo 'Bill Acct Status: ' . $billStatus . '</br>';
				echo 'Customer Name: ' . $customerName . '</br>';
				
				$customerName= mysqli_real_escape_string($mysqli,$customerName);
				
				$result3= $mysqli->query("Update Dbb set 
		    BILL_ACCT_STATUS='$billStatus',CUSTOMER_NAME='$customerName'
		    where ID='$id'");
			}
			
			else {
			  $result3= $mysqli->query("Update Dbb set 
		    BILL_ACCT_STATUS='NF'
		    where ID='$id'");
			}
		}
		
		else if($billSys=='RC7') { 
		
		  $result2= oci_parse($sandbox,"Select STAT,SUB_NM
		  from WASABI.V_SUB@billprod
      where SUB_ID='$billAcct'");
		  oci_execute($result2);
		  $row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);
			
			$status= $row2['STAT'];
			if($status!='') {  
			
			  if($status=='I') { $billStatus= "Disconnected"; }
				else { $billStatus= "In Service"; }
				
				if(($customerName=='')||($customerName=='NOT FOUND')) { 
				  $customerName= $row2['SUB_NM'];
				}
				
				echo 'Bill Acct Status: ' . $billStatus . '</br>';
				echo 'Customer Name: ' . $customerName . '</br>';
				
				$customerName= mysqli_real_escape_string($mysqli,$customerName);
				
				$result3= $mysqli->query("Update Dbb set 
		    BILL_ACCT_STATUS='$billStatus',CUSTOMER_NAME='$customerName'
		    where ID='$id'");
			}
			
			else {
			  $result3= $mysqli->query("Update Dbb set 
		    BILL_ACCT_STATUS='NF'
		    where ID='$id'");
			}
		}
		
		
			
		echo '</br>';	
	}
	
	nextUrl("dbo-update-customer-name.php");
	
	//refreshPage();
	
	
?>

