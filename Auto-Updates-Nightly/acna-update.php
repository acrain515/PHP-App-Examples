ACNA UPDATE </br>
</br>

<?php

	require_once('../prod.php');
	require_once('../functions.php');
	require_once('../kpi.php');
	
	$result= $mysqli->query("Select ID,VENDOR_CKT_CLN,BAN
	from Simple
  where VENDOR_CKT_CLN!=''
  and VENDOR_CKT_CLN!='NOTFOUND'
	and BAN!='' 
	and BAN!='X' 
	and ACNA=''
  ");
	if(($result)&&(mysqli_num_rows($result)>0)) {
	  while($row= $result->fetch_assoc()) {
	
	    $id= $row['ID'];
			$lecCkt= $row['VENDOR_CKT_CLN'];
			$ban= $row['BAN'];
			
			echo $id . '</br>';
			echo $lecCkt . '</br>';
			echo $ban . '</br>';
			
			$result2 = oci_parse($kpi,"Select ACNA 
			from Cat.BILLING_ACCOUNT@catprd a
      left join CAT.ACNA@catprd b
      on a.ACNA_ID=b.ACNA_ID
			where a.BAN='$ban'
			and rownum<2
      ");
      oci_execute($result2);
      $row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);
			
			$acna= $row2['ACNA'];
			
			if($acna!='') {
			
			  echo 'ACNA: ' . $acna . '</br>';
			
			  $result5= $mysqli->query("Update Simple set ACNA='$acna'
			  where ID='$id'");
			}
			
			else { 
			
			  $result5= $mysqli->query("Update Simple set ACNA='X'
				where ID='$id'");
			}
			
			echo '</br>';
		}	
	}
	
	oci_close($kpi);
	nextUrl("loop-type-update.php");
	
?>

