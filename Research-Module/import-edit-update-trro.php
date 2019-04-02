<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
<?php 

  require_once('../connection.php'); 
	require_once('../cookie.php');
	require_once('../functions.php');
	

	$date= date("Y-m-d h:i:s");

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
			
				  $keyField= $rowData[0];
				
				  if($keyField!='VENDOR_CKT_CLN') { 

				    echo 'First field must be VENDOR_CKT_CLN';
					  $keyFieldError= "y";
						break;
				 }
				
				  else {
				
				    $fieldCount= count($rowData);
				    //echo 'Field Count: ' . $fieldCount . '</br>';	
				
				    for($x=1;$x<$fieldCount;$x++) {
				
				      $field= $rowData[$x];
				
				      array_push($fields,$field);
					    $fieldString.= $field . ',';
					  }
					
					  //echo 'Field String: ' . $fieldString . '</br>';
				  }
			  }
			
			  //DETERMINE VALUES AND UPDATE TABLE
			  else { 
			  
				  $values= array();
				  $updateString= "";
				
				  $keyValue= $rowData[0];
				  //echo "Key Value: $keyValue </br>";
					
					if($keyValue=="") { 
					
					  echo "Key Value is blank on Row $rowNumber </br>"; 
					}
					
					else {
				
				    for($x=1;$x<$fieldCount;$x++) {
				
				      $fieldNumber= $x-1;
				      $fieldName= $fields[$fieldNumber];
					    //echo 'FieldName: ' . $fieldName . '</br>';
					
				      $value= $rowData[$x];
					    //echo "Value: $value </br>";
						
						  if($value!='') {

				        //DETERMINE IF FIELD IS STANDARD DATE FIELD AND CONVERT TO MATCH TABLE FORMAT
					      if(in_array($fieldName,array("FORECAST_FOC","INITIAL_FOC","REVISED_FOC","ACTUAL_FOC"))) { 
					
					        //echo "Date Field! </br>";
						      $value= date("m/d/Y",strtotime($value));
						
						      //echo "New Date Value: $value </br>";
					      }
					
				        //DETERMINE IF FIELD IS A DATETIME FIELD AND CONVERT TO MATCH TABLE FORMAT 
					      else if(strpos($field,'DATE')!==false) {
					
					        //echo "DATETIME Field! </br>";
						      $value= date("Y-m-d h:i:s");
						
						      //echo "New Date Value: $value </br>";
					      } 
					
					      array_push($values,$value);
					      $updateString.= "$fieldName='$value',";
					    }
				    }
						
						$result= $mysqli->query("Select ID from Simple where VENDOR_CKT_CLN='$keyValue' and INTERNAL_ORDER='TRRO'");
						if(($result)&&(mysqli_num_rows($result)>0)) { 
						
						  $row= $result->fetch_assoc();
							$id= $row['ID'];

				
				      //echo "Update String: $updateString </br>";
				
				      $query= "Update Simple set ";
				      $query.= $updateString;
				      $query.= "LAST_UPDATE='$date',";
				      $query.= "LAST_UPDATED_USER='$name'";
				      $query.= " where ID='$id'";
				
				      //echo "QUERY: $query </br>";
					
					    $result2= $mysqli->query("$query");
					
					    echo "$keyValue <b>  Updated</b>";
						}
						
					  else { echo '<b>  Not Updated</b>'; }
					  echo '</br>';
					}
			  }
		  }
		
		  echo "You can now close this window.";
	    fclose($handle);
	  }
	}



?>

