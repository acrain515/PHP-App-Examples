BAN UPDATE 2 </br>
</br>


<?php

	require_once('../prod.php');
	require_once('../functions.php');
	require_once('../kpi.php');
	
	$result= $mysqli->query("Select ID,VENDOR_CKT_CLN
	from Simple
  where VENDOR_CKT_CLN!=''
	and VENDOR_CKT_CLN!='NOTFOUND'
	and BAN='X'
	and STATUS not in ('COMPLETE','CANCELLED')
	and INTERNAL_ORDER!='TBD'
  ");
	if(($result)&&(mysqli_num_rows($result)>0)) {
	  while($row= $result->fetch_assoc()) {
	
	    $id= $row['ID'];
			$lecCkt= $row['VENDOR_CKT_CLN'];
			
			echo $id . '</br>';
			echo $lecCkt . '</br>';
			
			$result2 = oci_parse($kpi,"
			Select BAN from (
        Select MAX(INVOICE_DETAIL_ID) as INVOICE_DETAIL_ID
        from CAT.CIRCUIT_DETAIL@catprd
        where CONDENSED_EC_CIRCUIT='$lecCkt'
        ) a
        left join Cat.INVOICE_DETAIL@catprd b
        on a.INVOICE_DETAIL_ID=b.INVOICE_DETAIL_ID
        left join CAT.INVOICE@catprd c
        on b.INVOICE_ID=c.INVOICE_ID
        left join CAT.BILLING_ACCOUNT@catprd d
        on c.BILLING_ACCOUNT_ID=d.BILLING_ACCOUNT_ID
      ");
      oci_execute($result2);
      $row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);
			
			$ban= $row2['BAN'];
			
			
			if($ban!='') {
			
			  echo 'BAN: ' . $ban . '</br>';
			
			  $result5= $mysqli->query("Update Simple set BAN='$ban'
			  where ID='$id'");
			}
			
			echo '</br>';
			
		}	
	}
	
  oci_close($kpi);
	nextUrl("acna-update.php");
	
	
	
?>





