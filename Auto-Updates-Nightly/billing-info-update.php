Billing Info Update </br>
</br>

<?php

  require_once('../kpi.php');
	require_once('../prod.php');
	require_once('../functions.php');
	
	$result= $mysqli->query("Select ID,VENDOR_CKT,VENDOR_CKT_CLN,NC,NCI,SEC_NCI,VENDOR_CFA,
	CUSTOMER_NAME,BCOS,CCEA
	from Simple
  where STATUS not in ('COMPLETE','CANCELLED','FOC RECEIVED')
	and INTERNAL_ORDER != 'TBD'
	and VENDOR_CKT_CLN!=''
	and VENDOR_CKT_CLN!='NOTFOUND'
	and RATE_CODE='DS1'
	and VENDOR_CKT_CLN!=''
	and CUSTOMER_ADDRESS=''
  ");
	while($row= $result->fetch_assoc()) {
 
	    $id= $row['ID'];
			$lecCkt= $row['VENDOR_CKT_CLN'];
			echo 'ID: ' . $id . '</br>';
			echo 'Lec Ckt: ' . $lecCkt . '</br>';
			
			$nc= $row['NC'];
			$nci= $row['NCI'];
			$secNCI= $row['SEC_NCI'];
			$vendorCFA= $row['VENDOR_CFA'];
			$customerName= $row['CUSTOMER_NAME'];
			$bcos= $row['BCOS'];
			$vendorCkt= $row['VENDOR_CKT'];
			$ccea= $row['CCEA'];
			$customerAddress= "";
			$fid="";
			
		  $result3 = oci_parse($kpi,"Select distinct FID,FID_VALUE,CIRCUIT_LOCATION,CONDENSED_EC_CIRCUIT,USOC
      from CAT.INVOICE_CABS_CSR_FID_DATA@catprd
      where INVOICE_ID>1270000
			and FID in ('CKL','SN','SA','NC','NCI','CFA','CCEA','COSIND','CLS')
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
					  if(($fid=='SA')||($fid=='CKL')) { $customerAddress= $row3['FID_VALUE']; }
					  if($fid=='NCI') { $secNCI= $row3['FID_VALUE']; }
			    }
				
			    if($circuitLocation==2) { 
				
				    if($fid=='SN') { $customerName= $row3['FID_VALUE']; }
					  if(($fid=='SA')||($fid=='CKL')) { $customerAddress= $row3['FID_VALUE']; }
					  if($fid=='NCI') { $secNCI= $row3['FID_VALUE']; }
			    }
				
				  if($circuitLocation==3) {
				
				    if($fid=='SN') { $customerName= $row3['FID_VALUE']; }
					  if(($fid=='SA')||($fid=='CKL')) { $customerAddress= $row3['FID_VALUE']; }
					  if($fid=='NCI') { $secNCI= $row3['FID_VALUE']; }
				  }
				
				  if($circuitLocation==4) {
				
				    if($fid=='SN') { $customerName= $row3['FID_VALUE']; }
					  if(($fid=='SA')||($fid=='CKL')) { $customerAddress= $row3['FID_VALUE']; }
					  if($fid=='NCI') { $secNCI= $row3['FID_VALUE']; }
				  }
				
				  if($fid=='CFA') { $vendorCFA= $row3['FID_VALUE']; }
					if($fid=='CCEA') { $ccea= $row3['CCEA']; }
				  if($fid=='NC') { $nc= $row3['FID_VALUE']; }
				  if(($fid=='NCI')&&(($circuitLocation==1)||($circuitLocation==''))) { $nci= $row3['FID_VALUE']; }
				  if($fid=='COSIND') { $bcos= $row3['USOC']; }
				  if($fid=='CLS') { $vendorCkt= $row3['FID_VALUE']; } 
				}
			}
			
			if($fid!='') {
			
			  //echo 'Customer Name: ' . $customerName . '</br>';
			  //echo 'Customer Address: ' . $customerAddress . '</br>';
			  //echo 'CFA: ' . $vendorCFA . '</br>';
			  //echo 'NC: ' . $nc . '</br>';
			  //echo 'NCI: ' . $nci . '</br>';
		    //echo 'SecNCI: ' . $secNCI . '</br>';
			  //echo 'BCS: ' . $bcos . '</br>';
			  //echo 'Vendor Ckt: ' . $vendorCkt . '</br>';
				
				$customerName= mysqli_real_escape_string($mysqli,$customerName);
				$customerAddress= mysqli_real_escape_string($mysqli,$customerAddress);
				
				
				$result4= $mysqli->query("Update Simple set
				VENDOR_CKT='$vendorCkt',
				VENDOR_CFA='$vendorCFA',
				CCEA='$ccea',
				CUSTOMER_NAME='$customerName',
				CUSTOMER_ADDRESS='$customerAddress',
				NC='$nc',
				NCI='$nci',
				SEC_NCI='$secNCI',
				BCOS='$bcos'
				where ID='$id'");
				
				if($customerAddress=='') {
				  $result4= $mysqli->query("Update Simple set CUSTOMER_ADDRESS='X'
				  where ID='$id'");
				}
				
			}
			
			else { 
			  $result4= $mysqli->query("Update Simple set CUSTOMER_ADDRESS='X'
				where ID='$id'");
			}
			
				
			echo '</br>';
			
		//END WHILE	
	  }
		
	oci_close($kpi);
	
	nextUrl("cfa-update.php");
	
	
	
?>




