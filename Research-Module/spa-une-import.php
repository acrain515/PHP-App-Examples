<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
<?php 

  require_once('../connection.php'); 
	require_once('../connection2.php');
	include('../cookie.php');
  date_default_timezone_set('America/New_York');
	
?>

  <style>
    body { 
		  margin:0;padding:0;background-image:url('../images/grad2.jpg');background-repeat:no-repeat;
		  font-family:Arial;color:#222;font-size:11px;font-weight:bold;
		}
    a { text-decoration: none;color: #333; }
    #header { width:100%;height:40px;margin:0;padding:0;background:#fff;color#777;box-shadow:0 1px 4px rgba(0, 0, 0, 0.5); }
    #navbar { width:980px;margin:0 auto;padding:5px;background:#fff; }
    #logo { float:left; }
    #logo td { border: 0;padding:0;text-align:left;width:100px; }
    #menu { float:right; }
    #menu td { padding: 6px 16px; }
    #menu a { color: #222; text-decoration: none;font-size: 16px; }
    #menu a:hover { color: #ff0073; }
    #navbar table { border-collapse:collapse; }
    #main { width:1000px;background:#fff;margin:40px auto;padding:20px 20px 40px 20px;
    box-shadow:0 1px 4px rgba(0, 0, 0, 0.5), 0 0 40px rgba(0, 0, 0, 0.1) inset;
    min-height:600px; }
		
		h2 { font-size:26px; }
		
	</style>
	
	
</head>
<body>
<body>
  <div id="header">
    <div id="navbar">
      <div id="logo">
        <table>
          <tr><td><a href="index.php"><img src="../images/ulogo.png" height="28" border="0"></a></td></tr>
        </table>
      </div>
      
    </div>
  </div>
<div id="main">
<h2> Import Circuits </h2>
<div id="form">

<?php

  date_default_timezone_set('America/New_York');
	$date= date("Y-m-d");

  require_once('../connection.php');

  if (isset($_POST['submit'])) {
	
	  $project= "Other";
		$subProject= "Other SPA UNE";
		$uploadedBy= $name;

	  //Import uploaded file to Database
	  $handle = fopen($_FILES['filename']['tmp_name'], "r");

		$x=0;
		$inserted
	  while (($data = fgetcsv($handle, 2000, ",")) !== FALSE) {

		  $x++;
			
	    $count= count($data);
			
			if($x==1) {  
			
			  $dateSubmitted= $data[1];
				$submittedBy= $data[3];
				
				echo 'Date Submitted: ' . $dateSubmitted . '</br>';
				echo 'Submitted By: ' . $submittedBy . '</br>';
			}
			
			else if ($x>3) { 
			  
				$acna= $data[0];
				$ban= $data[1];
				$billDate= $data[2];
				$customerName= $data[3];
				$customerAddress= $data[4];
				$lata= $data[5];
				$state= $data[6];
				$vendorCFA= $data[7];
				$lecCkt= $data[8];
				$internalCkt= $data[9];
				$nc= $data[10];
				$serviceEstDate= $data[11];
				$newLecCkt= $data[12];
				$focDate= $data[13];
				
				
				echo 'FAC_ACNA: ' . $acna . '</br>';
				echo 'FAC_BAN: ' . $ban . '</br>';	
				echo 'FAC_BILL_DATE: ' . $billDate . '</br>';	
				echo 'CKL2_SN: ' . $customerName . '</br>';	
				echo 'CKL2_DESC: ' . $customerAddress . '</br>';	
				echo 'CKL2_LATA: ' . $lata . '</br>';	
				echo 'CKL2_STATE: ' . $state . '</br>';	
				echo 'FAC_CFA: ' . $vendorCFA . '</br>';	
				echo 'FAC_FAC_ID: ' . $lecCkt . '</br>';	
				echo 'FAC_CKR: ' . $internalCkt . '</br>';
				echo 'FAC_NC: ' . $nc . '</br>';	
				echo 'FAC_SVC_EST_DATE: ' . $serviceEstDate . '</br>';	
				echo 'New Ckt:  ' . $newLecCkt . '</br>';
				echo 'Conversion FOC: ' . $focDate . '</br>';
				
				$billDate= date("m/d/Y",strtotime($billDate));
				$serviceEstDate= date("m/d/Y",strtotime($serviceEstDate));
				if($focDate!='') { $focDate= date("m/d/Y",strtotime($focDate)); }
				$customerName= mysqli_real_escape_string($mysqli,$customerName);
				
				
				$result= $mysqli->query("Insert into Simple 
				(INTERNAL_ORDER,INTERNAL_CKT,INTERNAL_CKT_CLN,VENDOR_CKT,VENDOR_CKT_CLN,BAN,
				RATE_CODE,VENDOR_CFA,ACNA,NC,LATA,CUSTOMER_NAME,CUSTOMER_ADDRESS,
				PLANNER,DATE_ADDED,PROJECT,SUBPROJECT,STATUS,INITIAL_FOC,ON_FORECAST,FIN_FCAST)
        values 
				('SPA/UNE','$internalCkt','$internalCkt','$lecCkt','$lecCkt','$ban',
				'DS1','$vendorCFA','$acna','$nc','$lata','$customerName','$customerAddress',
				'$submittedBy','$date','$project','$subProject','IDENTIFIED','$focDate','n','n')
				");
				
				$result2= $mysqli->query("Select ID from Simple where
				INTERNAL_ORDER='SPA/UNE'
				and INTERNAL_CKT='$internalCkt'
				and VENDOR_CKT='$vendorCkt'
				and BAN='$ban'
				");
				$row2= $result2->fetch_assoc();
				$id= $row2['ID'];
				
				$result3= $dev->query("Insert into SPA_UNE 
				(ID,FAC_BILL_DATE,CKL2_STATE,FAC_SVC_EST_DATE,NEW_CKT)
				values
				('$id','$billDate','$state','$serviceEstDate','$newCkt')
				");		
			}

				
		
		  echo '</br>';
			
		}
		
	  fclose($handle);
	}

  else {

	  print "<form enctype='multipart/form-data' action='spa-une-import.php' method='post'>";
	  print "<input size='100' type='file' name='filename'><br />\n";
	  print "<input type='submit' name='submit' value='Upload'>";
	  print "</form>";

  }

?>

</div>
</div>
</body>
</html>
