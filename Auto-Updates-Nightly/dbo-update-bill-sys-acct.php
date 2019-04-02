DBB Update Bill Sys + ACCT </br>
Fills Bill SYS and ACCOUNT from STATIC </br>
</br>

<?php  

  require_once('../functions.php');
  require_once('../prod.php');
	require_once('../kpi.php');
	
	$today= strtotime(date("Y-m-d H:i:s"));
	$date= date("Y-m-d", strtotime("-4 days", $today));

	echo 'After: ' . $date . '</br>';
	
	$result= $mysqli->query("Select ID,LEC_CKT_CLN from Dbb 
	where DATE_ADDED>'$date'
	and (BILL_SYS='' or BILL_ACCT='0')
	");
	while($row= $result->fetch_assoc()) {  
	
	  $id= $row['ID'];
	  $lecCkt= $row['LEC_CKT_CLN'];
		
		$billSys="";
		$billAcct="";
		
		echo $id . '</br>';
	  echo $lecCkt . '</br>';
		
		$result2 = oci_parse($kpi,"Select BILLING_SYS,SUB_ID
		from RCO.AB_CKT_COMP_STATIC
		where LEC_CKT='$lecCkt'
		order by PERIOD desc
    ");
    oci_execute($result2);
    $row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);
		  
    $billSys= $row2['BILLING_SYS'];	
    $billAcct= $row2['SUB_ID'];		
			
		if($billSys!='') {
		    
			echo 'BillSys: ' . $billSys . '</br>';
			echo 'BillAcct: ' . $billAcct . '</br>';

			$result3= $mysqli->query("Update Dbb set
			BILL_SYS='$billSys',BILL_ACCT='$billAcct'
			where ID='$id'");
		}
		
		else { 
		
		  $result3= $mysqli->query("Update Dbb set
			BILL_SYS='NF',BILL_ACCT='999999999'
			where ID='$id'");
		}
		
		echo '</br>';
	}
	
	oci_close($kpi);
	
	nextUrl("dbo-update-internal-ckt.php");
	
?>

