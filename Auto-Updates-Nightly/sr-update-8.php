Sr Update New 8 </br>
Finds Billing Info for LEC Ckts that did not pull from Datamart but found in ASAP from sr-update-7 </br></br>
<?php

  $date= date("Y-m-d");
  
  require_once('../local.php');
	require_once('../kpi.php');
  require_once('../functions.php');
  
  $result= $local->query("Select * from SRTempD 
	where MATCHED=''
  and LEC_CKT_CLN not in ('','NOTFOUND2')
	and BAN=''
	and PLANNER!=''
	and ORDER_NUMBER!=''
	");
  while($row= $result->fetch_assoc()) {
  
	  $id= $row['ID'];
    $orderNumber= $row['ORDER_NUMBER'];
    $internalCkt= $row['INTERNAL_CKT'];
		$circuitDesignID= $row['CIRCUIT_DESIGN_ID'];
		$sys= $row['SYS'];
		$lecCkt= $row['LEC_CKT_CLN'];
	
    echo $internalCkt . '</br>';
    echo 'LEC Ckt: ' . $lecCkt . '</br>';
		
		include('../system-tables-kpi.php');
		
		$result2= oci_parse($kpi,"Select max(DATE_OF_ENTRY) as DATE_OF_ENTRY
	  from CAT.CIRCUIT_DETAIL@catprd 
	  where CONDENSED_EC_CIRCUIT='$lecCkt'");
	  oci_execute($result2);
    $row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);
	
	  $dateOfEntry= $row2['DATE_OF_ENTRY'];
		
		if($dateofEntry!='') {
	    echo 'Date of Entry: ' . $dateOfEntry . '</br>';
	
	    $dateStr= strtotime($dateOfEntry);
	    $date= date("m/d/Y",$dateStr);
	
	    echo 'Date: ' . $date . '</br>';
	
	    $mrc=0;
		
	    $result3= oci_parse($kpi,"Select a.INVOICE_DETAIL_ID,b.DETAIL_CHARGE,b.INVOICE_ID
	    from CAT.CIRCUIT_DETAIL@catprd a 
	    left join CAT.INVOICE_DETAIL@catprd b 
	    on a.INVOICE_DETAIL_ID=b.INVOICE_DETAIL_ID
	    where CONDENSED_EC_CIRCUIT='$lecCkt'
	    and a.DATE_OF_ENTRY=TO_DATE('$date','mm/dd/YYYY')");
	    oci_execute($result3);
      while($row3 = oci_fetch_array($result3, OCI_ASSOC+OCI_RETURN_NULLS)) { 
	
	      $invoiceDetailID= $row3['INVOICE_DETAIL_ID'];
		    echo 'InvoiceDetailID: ' . $invoiceDetailID . '</br>';
		
		    $detailCharge= $row3['DETAIL_CHARGE'];
		    echo 'Detail Charge: ' . $detailCharge . '</br>';
			
			  $mrc+= $detailCharge;
		
		    $invoiceID= $row3['INVOICE_ID'];
	    }
		
		  echo 'MRC: ' . $mrc . '</br>';
	
	    $result4= oci_parse($kpi,"Select b.BAN,c.VENDOR_NAME
	    from CAT.INVOICE@catprd a 
	    left join CAT.BILLING_ACCOUNT@catprd b
	    on a.BILLING_ACCOUNT_ID=b.BILLING_ACCOUNT_ID
	    left join CAT.VENDOR@catprd c 
	    on a.VENDOR_ID=b.VENDOR_ID
	    where INVOICE_ID='$invoiceID'");
	    oci_execute($result4);
      $row4 = oci_fetch_array($result4, OCI_ASSOC+OCI_RETURN_NULLS);
	
	    $ban= $row4['BAN'];
	    $vendor= $row4['VENDOR_NAME'];
	
	    echo 'BAN: ' . $ban . '</br>';
	    echo 'Vendor: ' . $vendor . '</br>';
		
		  echo '</br>';
		
		  $result5= $local->query("Update SRTempD set 
		  BAN='$ban',MRC='$mrc',VENDOR='$vendor'
      where ID='$id'");				
		}	
  }
	
	oci_close($kpi);
  
  nextUrl("sr-update-9.php");

?>





