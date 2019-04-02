<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
<?php 

  require_once('../connection.php'); 
	require_once('../cookie.php');
	require_once('../functions.php');
	
	$acceptedFields= array("DISPUTE_ORIGINAL_LEC_ORDER",
"LEC_CKT",
"LEC_CKT_CLN",
"BAN",
"CB_KEY",
"ACNA",
"CLLI",
"VENDOR",
"MRC",
"PROJECT",
"SUBPROJECT",
"DATE_ADDED",
"BILL_SYS",
"BILL_ACCT",
"BILL_ACCT_STATUS",
"CUSTOMER_NAME",
"ADDRESS",
"INTERNAL_CKT",
"INV_CKT_STATUS",
"CIRCUIT_DESIGN_ID",
"RATE_CODE",
"INV_SYS",
"INV_ACCT",
"INV_ACCT_STATUS",
"VENDOR_CFA",
"TERM_EQUIPMENT",
"XCON_ACTIVE",
"XCON_COND_CODE",
"SOFT_DISC_DATE",
"PSR",
"PSR_COMPLETE_DATE",
"PSR_USER",
"TO_SD_DATE",
"RESEARCHER",
"RESEARCH_DATE",
"RESEARCH_STATUS",
"PROCESS_FAILURE",
"DISC_STATUS",
"PON",
"DISC_USER",
"TO_LEC_DATE",
"LEC_ORDER",
"FOC_DATE",
"DISC_COMPLETE_DATE",
"DISC_SR",
"DISC_SR_DATE",
"DISC_SR_USER",
"DISPUTE_USER",
"DISPUTE_START_DATE",
"DISPUTE_COMPLETE_DATE",
"DISPUTE_RECOVERED_AMOUNT",
"DISPUTE_ORIGINAL_PON",
"DISPUTE_ORIGINAL_FOC_DATE",
"BILLING_UPDATED",
"BILL_DIFF",
"NOTES",
"LAST_UPDATE",
"LAST_UPDATE_USER");
	

	$date= date("Y-m-d");

  if (isset($_POST['submit'])) {
	
	  $fileData= $_FILES['filename'];
		//print_r($fileData);
		//echo "</br>";
		$fileName= $fileData['name'];
		//echo "FILENAME: $fileName </br>";
		
		if($fileName=="") { 
		
		  error("No File Submitted. </br> Please close this page and try again.");
		}
		
		else {
		
	    $handle = fopen($_FILES['filename']['tmp_name'], "r");
		
		  $fields= array();
		  $fieldString= "";

		  $rowNumber=0;
	    while (($rowData = fgetcsv($handle, 2000, ",")) !== FALSE) {

	      $rowNumber++;
			
			  //DETERMINE FIELDS FROM FIRST ROW OF DATA
			  if($rowNumber==1) { 
			
				  $keyField1= $rowData[0];
					$keyField2= $rowData[1];
				
				  if(($keyField1!='LEC_CKT')||($keyField2!='BAN')) { 

				    echo 'First two fields must be LEC_CKT and BAN';
					  $keyFieldError= "y";
				  }
				
				  else {
					
						$fieldCount= count($rowData);
				
						foreach($rowData as $field) {
							
							if($field=='EXCHANGE_CARRIER_CIRCUIT_ID') { $field= "INTERNAL_CKT"; }
							else if ($field=='BANDWIDTH') { $field= "RATE_CODE"; }
							else if ($field=='CKT_STATUS_DESC') { $field= "INV_CKT_STATUS"; }
							else if ($field=='Z_CLLI') { $field= "CLLI"; }
				      else if ($field=='SUB_ID') { $field= "BILL_ACCT"; }
							else if ($field=='AMOUNT_PAID') { $field= "MRC"; }
							else if ($field=='VENDOR_GRP') { $field= "VENDOR"; }
							else if ($field=='BILLING_SYS') { $field= "BILL_SYS"; }
							else if ($field=='CFA') { $field= "VENDOR_CFA"; }
							else if ($field=='OVERVIEW_STATUS') { $field= "RESEARCH_STATUS"; }
							else if ($field=='ENT_SMB_FLAG') { $field= "PSR_USER"; }
							
							if(in_array($field,$acceptedFields)) {
				        array_push($fields,$field);
					      $fieldString.= $field . ',';
							}
							
							else { 
							  echo 'Field: ' . $field . ' Not Accepted </br>';
								$incorrectFieldError= "y";
                break;								
							}
					  } 
				  }
					
					
					$fieldString.= "DATE_ADDED,LEC_CKT_CLN,CB_KEY";
					
					//REPLACE PSR_USER WITH ENT_SMB_FLAG AFTER STRUCTURE CHANGE
					if(strpos($fieldString,'PSR_USER')==false) { 
						
						$fieldString.= ",PSR_USER";  
					}
					//echo 'Field String: ' . $fieldString . '</br>';
			  }
			
			  //DETERMINE VALUES AND INSERT INTO TABLE
			  else { 
				
				  if(($keyFieldError=='y')||($incorrectFieldError=='y')) { break; }
					else {
			  
				    $values= array();
				    $valueString= "";
				
				    $lecCkt= $rowData[0];
					  $ban= $rowData[1];
					  $lecCktCln= $lecCkt;
						$cbKey= $lecCkt.''.$ban;
				    //echo "Key Value: $keyValue </br>";
					
					  if($lecCkt=="") { 
					
					    echo "LEC_CKT is blank on Row $rowNumber </br>"; 
					  }
					
					  else if($ban=="") { 
					
					    echo "BAN is blank on Row $rowNumber </br>"; 
					  }
					
					  else {
				
				      for($x=0;$x<$fieldCount;$x++) {
				
				        $fieldNumber= $x;
				        $fieldName= $fields[$fieldNumber];
					      //echo 'FieldName: ' . $fieldName . '</br>';
					
				        $value= $rowData[$x];
					      //echo "Value: $value </br>";
						
                if(($fieldName=='RESEARCH_STATUS')&&($value=='')) { $value= "PENDING REVIEW"; }

				        //DETERMINE IF FIELD IS STANDARD DATE FIELD AND CONVERT TO MATCH TABLE FORMAT
					      if(strpos($fieldName,'DATE')!==false) { 
					
					        //echo "Date Field! </br>";
						      $value= date("Y-m-d",strtotime($value));
						
						      //echo "New Date Value: $value </br>";
					      }
					 

					      array_push($values,$value);
					      $valueString.= "'$value',";
				      }
						
						  $valueString.= "'$date','$lecCktCln','$cbKey'";
						
						  //REPLACE PSR_USER WITH ENT_SMB_FLAG AFTER STRUCTURE CHANGE
						  if(strpos($fieldString,'PSR_USER')==false) { 

						    $valueString.= ",'ENT'"; 
						  }
						
						  //echo 'Value String: ' . $valueString . '</br>';
						
						  $query= "Insert into Dbb ($fieldString) values ($valueString)";
						  //echo 'Query: ' . $query . '</br>';

				      $result= $mysqli->query("Select LEC_CKT,BAN from Dbb
						  where LEC_CKT_CLN='$lecCktCln'
							and BAN='$ban'");
						  if(($result)&&(mysqli_num_rows($result)>0)) { 
							
							  echo 'LEC CKT: ' . $lecCkt . ' and BAN: ' . $ban . ' already exist in database. </br>';
							}
							
							else {
					
					      $result2= $mysqli->query("$query");
					
					      echo "LEC_CKT: $lecCktCln - BAN: $ban <b>  Inserted</b></br>";
								
						  }
							echo '</br>';
						}
					}
			  }
		  }
		
		  echo "You can now close this window.";
	    fclose($handle);
	  }
	}



?>

 