<style>
* { font-family: Arial; }
table { border-collapse: collapse; }
th { font-size: 14px; }
td { padding:2px 4px; font-size: 12px; border: 1px solid #ccc; }
input[type="submit"] { width:80px;height:22px;margin:0;padding:2px 6px;border:0; background:#14aaff;color:#fff;font-size:12px;font-weight:bold;border-radius:2px; }
input[type="submit"]:hover { background:#0097ea;cursor:pointer; }
</style>

<?php

  date_default_timezone_set('America/New_York');
  
  require_once('../connection.php');
	require_once('../functions.php');
  require_once('../cookie.php');
	
  if(isset($_POST['toForecast'])) {
    if((!isset($_POST['cbKey']))||($_POST['project']=='')) {
		
      error("Circuit or Project was not selected. </br> Redirecting...");  
	    previousPage("4");
    }
		
		else {
	    if(substr($_POST['project'],0,2)=="::") { 
		
		    //echo 'Sub Project Only' . '</br>';
		    $project= "";
		    $subProject= str_replace("::","",$_POST['project']); 
	    }
	  
	    else {
	      $projectSplit= explode("::",$_POST['project']);
        $project= $projectSplit[0];
        $subProject= $projectSplit[1];
      }	
		
		  //print 'Project: ' . $project . '</br>';
	    //print 'SubProject: ' . $subProject . '</br>';
		
	    $i=0;
			
			$existings= array();
		
      foreach($_POST['cbKey'] as $cbKey) {
		
		    //print $cbKey . '</br>';
	  
        $result= $mysqli->query("Select * from Mileage where CB_KEY='$cbKey'");
        $row= $result->fetch_assoc();
		
		    if($row['ON_FORECAST']=='y') { 
		      echo '<div style="margin:200px auto;width:900px;text-align:center;font-family:Arial;">'; 
		      echo '<h3>Error:</br>  CBKEY <i>' . $cbKey . '</i></br> is already on the Forecast</h3>';
		      break;
		    }
		
		    else if($row['OPTIMAL']=='y') {
		      echo '<div style="margin:200px auto;width:900px;text-align:center;font-family:Arial;">'; 
		      echo '<h3>Error:</br>  CBKEY <i>' . $cbKey . '</i></br>  is marked as Optimal (not groomable)</h3>';
		      break;
		    }
		
		    else {
		
		      $lecCkt= $row['LEC_CKT'];
		      $lecCktCln= trim(preg_replace('/[^a-zA-Z0-9\']/','',$lecCkt));
					$internalCkt= $row['INTERNAL_CKT'];
		      $internalCktCln= trim(preg_replace('/[^a-zA-Z0-9\']/','',$internalCkt));
		      $circuitDesignID= $row['CIRCUIT_DESIGN_ID'];
          $ban= $row['BAN'];
	        $vendor= $row['VENDOR'];
	        $mrc= $row['MRC'];
					if(strpos($mrc,'.')==false) { $mrc.= '.00'; }
		      $clli= $row['CLLI'];
					$sys= $row['SYS'];
					if($sys=='PT-MSS') { $sys= "PAE"; }
			    if(($sys=='M5')||($sys=='NV-MSS')) { $sys= "NVX"; }
			    if($sys=='WS-MSS') { $sys= "WIN"; }
	        $date1= date("Y-m-d H:i:s");
          $date2= date("Y-m-d H:i:s");
	        $date3= date("Y-m-d H:i:s");
	        $date4= date("Y-m-d H:i:s");
				
				  //CHECK TO SEE IF ALREADY IN TRACKING
				  $resultCheck= $mysqli->query("Select INTERNAL_ORDER,INTERNAL_CKT_CLN,VENDOR_CKT_CLN,BAN,
					DATE_ADDED,STATUS,PLANNER,SUBPROJECT,INITIAL_FOC
					from Simple 
					where VENDOR_CKT_CLN='$lecCktCln' or INTERNAL_CKT_CLN='$internalCktCln'
					");
					if(($resultCheck)&&(mysqli_num_rows($resultCheck)>0)) { 
					
					  while($rowCheck= $resultCheck->fetch_assoc()) {
						
						  $foundLecCkt= $rowCheck['VENDOR_CKT_CLN'];
						  $foundInternalCkt= $rowCheck['INTERNAL_CKT_CLN'];
						  $foundBAN= $rowCheck['BAN'];
						  $foundDateAdded= $rowCheck['DATE_ADDED'];
						  $foundInternalOrder= $rowCheck['INTERNAL_ORDER'];
						  $foundStatus= $rowCheck['STATUS'];
						  $foundPlanner= $rowCheck['PLANNER'];
						  $foundSubProject= $rowCheck['SUBPROJECT'];
						  $foundFOC= $rowCheck['INITIAL_FOC'];
						
					    array_push($existings,array($lecCktCln,$ban,$internalCktCln,$foundLecCkt,$foundBAN,$foundInternalCkt,
						  $foundInternalOrder,$foundSubProject,$foundStatus,$foundFOC));
						}
					}
					
					else {
		
		
            $result2= $mysqli->query("Insert into Simple 
				    (PROJECT,SUBPROJECT,PLANNER,INTERNAL_ORDER,INTERNAL_CKT,PROV_SYS,CIRCUIT_DESIGN_ID,
		        INTERNAL_CKT_CLN,RATE_CODE,VENDOR_CKT,VENDOR_CKT_CLN,VENDOR,BAN,MRC,NEW_ACTL,
		        LAST_UPDATE,STATUS_LAST_UPDATE,DATE_ADDED,ORDER_LAST_UPDATE,ON_FORECAST,FIN_FCAST,STATUS) 
		        values 
				    ('$project','$subProject','$name','TBD','$internalCkt','$sys','$circuitDesignID',
		        '$internalCktCln','DS1','$lecCkt','$lecCktCln','$vendor','$ban','$mrc','$clli',
		        '$date1','$date2','$date3','$date4','y','y','IDENTIFIED')");

            $result3= $mysqli->query("Update Mileage set ON_FORECAST='y' where CB_KEY='$cbKey'");
		
		        $i++;
					}
	      }
      }  // END FOR EACH CB_KEY
	  
		
		  if($i>0) { 
			
	      echo '<div style="margin:200 auto;width:400px;text-align:center;font-family:Arial;">';  
        echo '<h3>' . $i . ' ';
			
		    if($i==1){ echo 'Circuit was '; } else { echo 'Circuits were '; }
		    echo 'Added Succesfully.</h3>';
				echo '</div>';
			}
			
			
			$countExisting= count($existings);
			
		  if($countExisting>0) { 
			
			  echo '<div style="width:1000px;margin:20px auto;text-align:center;">';
				
				$data= serialize($existings);
				$data= htmlentities($data);
				
			
			  echo '<b>' . $countExisting . ' circuits were found to be already exisiting in the forecast. </br>';
				echo 'Are you sure you want to add these circuits to the forecast? </b></br></br>';
				echo '<form method="post" action="mileage-manage-existing.php">';
				echo '<input type="hidden" name="data" value="'.$data.'">';
				echo '<input type="hidden" name="project" value="'.$project.'">';
				echo '<input type="hidden" name="subProject" value="'.$subProject.'">';
				echo '<input type="hidden" name="name" value="'.$name.'">';
				echo '<input type="submit" value="YES">';
				echo '</form>';
				echo '</br></br>';
				
				echo '<table style="width:1000px;">';
				echo '<tr>';
				echo '<th></th>';
				echo '<th>LEC Ckt</th>';
				echo '<th>BAN</th>';
				echo '<th>Internal Ckt</th>';
				
				echo '<th>Internal Order</th>';
				echo '<th>Project</th>';
				echo '<th>Status</th>';
				echo '<th>Intial FOC</th>';
				echo '</tr>';
				
				foreach ($existings as $existing) {  
				
				  echo '<tr>';
					echo '<td><b>Adding:</b></td>';
					echo '<td>' . $existing[0] . '</td>';
					echo '<td>' . $existing[1] . '</td>';
					echo '<td>' . $existing[2] . '</td>';
					echo '</tr>';
				
				  echo '<tr>';
					echo '<td><b>On Forecast:</b></td>';
					echo '<td>' . $existing[3] . '</td>'; 
          echo '<td>' . $existing[4] . '</td>';
          echo '<td>' . $existing[5] . '</td>';	
					
					echo '<td>' . $existing[6] . '</td>';
					echo '<td>' . $existing[7] . '</td>';
					echo '<td>' . $existing[8] . '</td>';
					echo '<td>' . $existing[9] . '</td>';
					echo '</tr>';
		    }
				
				echo '</div>';
			}
			
			else { 
			
			  nextUrl("mileage.php");
			}
 
    } // END ELSE SET CB KEY AND PROJECT

  } //END IF SET POST TO FORECAST
  
  //FLAG FOR OPTIMAL WAS POSTED
  else if(isset($_POST['flag'])) {
    //CBKEY WAS POSTED
    if(isset($_POST['cbKey'])) {
	
	    $date= date("m/d/Y");
	  
	    //FOREACH CBKEY
	    foreach($_POST['cbKey'] as $cbKey) {
	  
	      echo $cbKey . '</br>';
		
	      $result= $mysqli->query("Select * from Mileage where CB_KEY='$cbKey'");
        $row= $result->fetch_assoc();
		
		    $lecCkt= $row['LEC_CKT'];
		    $ban= $row['BAN'];
		    $internalCkt= $row['INTERNAL_CKT'];
		  
		    //print 'LEC CKT: ' . $lecCkt . '</br>';
		    //print 'BAN: ' . $ban . '</br>';
		  
		    //SET OPTIMAL CURRENTLY SET TO NO
		    if(($row['OPTIMAL']=='n')||($row['OPTIMAL']=='')) { 
		
		      //echo 'Optimal currently set to No </br>';
		
		      //print 'INTERNAL CKT: ' . $internalCkt . '</br>';
		  
          $result2= $mysqli->query("Update Mileage set OPTIMAL='y' where CB_KEY='$cbKey'");
		      $result3= $mysqli->query("Insert into Optimal (CB_KEY,LEC_CKT,INTERNAL_CKT,BAN,NAME,DATE_ADDED) 
		      values ('$cbKey','$lecCkt','$internalCkt','$ban','$name','$date')");    
		    }
		    //END SET OPTIMAL CURRENTLY SET TO NO
		
		    //UNSET OPTIMAL CURRENTLY SET TO YES
		    else { 
		
          $result2= $mysqli->query("Update Mileage set OPTIMAL='n' where CB_KEY='$cbKey'");
		      $result3= $mysqli->query("Delete from Optimal where CB_KEY='$cbKey')");
		    }
		    //END UNSET OPTIMAL CURRENTLY SET TO YES
				
      }
	    //END FOREACH CBKEY

      if(isset($_POST['mileageClli'])) {	 
	      $clli= $_POST['mileageClli'];
	      echo '<div style="margin:200 auto;width:400px;text-align:center;font-family:Arial;">';  
        echo '<h3>Circuits were Flagged Successfully.</h3>  Redirecting...';
	      echo '<meta http-equiv="REFRESH" content="2;url=mileage-clli-loading.php?clli='.$clli.'">';
	    }
	  
	    else {
	      echo '<div style="margin:200 auto;width:400px;text-align:center;font-family:Arial;">';  
        echo '<h3>Circuits were Flagged Successfully.</h3>  Redirecting...';
	      echo '<meta http-equiv="REFRESH" content="2;url=' . $_SERVER['HTTP_REFERER'] . '">';
	    } 
	  }
	  //END CBKEY WAS POSTED
	
	  else {
	
      echo '<div style="margin:200 auto;width:400px;text-align:center;font-family:Arial;">';  
      echo '<h3>No Circuits were Selected.</h3>  Redirecting...';
	    echo '<meta http-equiv="REFRESH" content="2;url=' . $_SERVER['HTTP_REFERER'] . '">';
	  }	
  }
  //END FLAG FOR OPTIMAL WAS POSTED
  
  
  //ACTION WAS NOT POSTED
  else {         
	  echo '<div style="margin:200 auto;width:400px;text-align:center;font-family:Arial;">';  
    echo '<h3>You must select an action.</h3>  Redirecting...';
	  echo '<meta http-equiv="REFRESH" content="2;url=' . $_SERVER['HTTP_REFERER'] . '">';
  }
			
?>

