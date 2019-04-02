
<h2>Flex Import</h2>
For Circuits with Savings Only</br>
*Required Fields:  VENDOR_CKT + BAN,VENDOR,MRC,NEW_MRC,INTERNAL CKT,RATE_CODE,PROV_SYS,PROJECT,PLANNER,STATUS
</br>
<div id="form">

<?php

  date_default_timezone_set('America/New_York');
	$date= date("Y-m-d");

  require_once('../connection.php');
	require_once('../functions.php');
	
	$fields="";

  if (isset($_POST['submit'])) {

	  //Import uploaded file to Database
	  $handle = fopen($_FILES['filename']['tmp_name'], "r");

		$x=0;
		$fieldArray= array();
		$queryFields= "";
		$queryValues= "";
	  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		
		  //print_r($data);
		  $x++;
			
			
			if($x==1) {
			
			  foreach($data as $field) { 
				
				  array_push($fieldArray,$field);
				}
			
			  //COUNT THE COLUMNS
	      $count= count($data);
				
				//NAME THE FIELDS 
				for($c=0;$c<$count;$c++) {  
				
				  $field{$c}= $data[$c];
				  $fields.= $data[$c] . ',';
				} 
				
				$fields= rtrim($fields,",");
				echo 'Fields: ' . $fields . '</br>';
      }	

      else {		

			
				$query= "Insert into Simple (";
				
				for($c=1;$c<$count;$c++) { 
				
				
				  $queryFields= $fieldArray[$c].',';
					$queryValues=
				}
				$query= rtrim($query,",");
				$query.= ") values (";
				  
				// 
				
				  //$value{$c}= mysqli_real_escape_string($mysqli,$data[$c]);
					//$query.= $field{$c}."='".$value{$c}."',";
				//}
				
				//$query= rtrim($query,",");
				//$query.= " where CB_KEY='".$data[0]."'";
				echo $query . '</br>';
				
				//$result= $mysqli->query($query);
				
			}
				

			echo '</br>';
		}
		

	  fclose($handle);
		
		if($result) { echo 'Import Successful.'; }
		else { echo 'Error. Import not Successful.'; }
		
		
		echo 'Field Array: ' . print_r($fieldArray);
	}

  else {

	  print "<form enctype='multipart/form-data' action='flex-import.php' method='post'>";
	  print "<input size='50' type='file' name='filename'><br />\n";
	  print "<input type='submit' name='submit' value='Upload'>";
	  print "</form>";

  }

?>

</div>
</div>
</body>
</html>



