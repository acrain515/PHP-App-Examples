<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
<?php 

  require_once('../connection.php'); 
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

	  //Import uploaded file to Database
	  $handle = fopen($_FILES['filename']['tmp_name'], "r");

		$x=0;
	  while (($data = fgetcsv($handle, 2000, ",")) !== FALSE) {

		  $x++;
			
			if($x==1) {
	      $count= count($data);
				
		    if($count!=6) { break; echo 'Incorrect Number of Columns for Uploaded file.'; }
				//else { echo 'Correct Number of Columns.'; }
      }	

      else {			
		
		    $lecCkt= $data[0];
				$ban= $data[1];
				$project= $data[2];
				$subProject= $data[3];
				$researcher= $data[4];
				$mrc= $data[5];
				
				echo 'LecCkt: ' . $lecCkt . '</br>';
				echo 'BAN: ' . $ban . '</br>';
				
				
				if(($lecCkt=='')||($ban=='')||($project=='')) { break; echo 'Lec Ckt, BAN, and Project must be entered.'; }
				
				else {
				
				  //echo 'Lec Ckt: ' . $lecCkt . '</br>';
				  //echo 'Ban: ' . $ban . '</br>';
				  //echo 'Project: ' . $project . '</br>';
				  //echo 'SubProject: ' . $subProject . '</br>';
				  //echo 'Researcher: ' . $researcher . '</br>';
					
					
					if(strpos($mrc,'.')!==false) { } 
					else { $mrc.= ".00"; }
					//echo 'MRC: ' . $mrc . '</br>';
				
				
				  if(strpos($mrc,'.')!==false) { } 
					else { $mrc.= ".00"; }
				
				  $lecCktCln= trim(preg_replace('/[^a-zA-Z0-9\']/','',$lecCkt));
				
				  $cbKey= $lecCktCln . '' . $ban;
				  //echo 'CbKey: ' . $cbKey . '</br>';
				
		 
		      if($count==6) {
		    
		        $result= $mysqli->query("Insert into Dbb 
			      (CB_KEY,LEC_CKT,LEC_CKT_CLN,BAN,MRC,PROJECT,SUBPROJECT,DATE_ADDED,RESEARCHER,RESEARCH_STATUS)
			      values 
			      ('$cbKey','$lecCkt','$lecCktCln','$ban','$mrc','$project','$subProject','$date','$researcher','Pending Review')
			      ");
						
						if($result) { echo 'Import Successful! </br>'; }
						echo '</br>';
					}
        }					
			}
		    
				//echo '</br>';
		}
		
		
		
	  fclose($handle);
	}

  else {

	  print "<form enctype='multipart/form-data' action='import.php' method='post'>";
	  print "<input size='50' type='file' name='filename'><br />\n";
	  print "<input type='submit' name='submit' value='Upload'>";
	  print "</form>";

  }

?>

</div>
</div>
</body>
</html>
