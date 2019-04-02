<?php  

  require_once('../dev.php');
	require_once('../kpi.php');
	require_once('../functions.php');
	
	$sys= "WIN";
	
	require_once('../system-tables-kpi.php');

  $result= oci_parse($kpi,"Select sr.DOCUMENT_NUMBER,sr.ORDER_NUMBER,c.EXCHANGE_CARRIER_CIRCUIT_ID
  from $tableSR sr
  left join $tableSRC src
  on sr.DOCUMENT_NUMBER=src.DOCUMENT_NUMBER
  left join $tableCircuit c
  on src.CIRCUIT_DESIGN_ID=c.CIRCUIT_DESIGN_ID
  where ACTIVITY_IND='N'
  and c.RATE_CODE='DS3'
  and SR.SUPPLEMENT_TYPE not in ('4')
  and SR.SUPP_CANCEL_REASON_CD is null
  and (sr.GMT_DT_TM_RECEIVED>SYSDATE-30 or sr.LAST_MODIFIED_DATE>SYSDATE-30)
	");
	oci_execute($result);
	while($row= oci_fetch_array($result)) {  
	
	  $documentNumber= $row['DOCUMENT_NUMBER'];
		echo 'Document Number: ' . $documentNumber . '</br>';
	
	  $result2= $dev->query("Insert into DS3_Install_Orders 
		(DOCUMENT_NUMBER,SYS,ORDER_NUMBER,EC_ID) 
		values 
		('$row[DOCUMENT_NUMBER]','$sys','$row[ORDER_NUMBER]','$row[EXCHANGE_CARRIER_CIRCUIT_ID]')
		");
	}
	
	//nextUrl("ds3-install-orders-4.php");
	
?>
	


