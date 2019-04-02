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
		
		  //IF LONGHAUL POSTED ADD TO LONGHAUL FORECAST
		  if(isset($_POST['longhaul'])) {
			
			  $projectID= $_POST['project'];
				
				foreach($_POST['cbKey'] as $cbKey) {
				
				  $result= $mysqli->query("Select * from Population where CB_KEY='$cbKey'");
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
		
	          if($row['EXCHANGE_CARRIER_CIRCUIT_ID']!='') { 
	            $internalCkt= $row['EXCHANGE_CARRIER_CIRCUIT_ID'];
			        $internalCktCln= trim(preg_replace('/[^a-zA-Z0-9\']/','',$internalCkt));
	          }
	  
	          else if($row['PARENT_CKT']!='') { 
	            $internalCkt= $row['PARENT_CKT'];
			        $internalCktCln= trim(preg_replace('/[^a-zA-Z0-9\']/','',$internalCkt));
	          }
		
		        if($internalCktCln=='') { 
		
	            echo '<div style="margin:200 auto;width:400px;text-align:center;font-family:Arial;">';  
              echo '<h3>Internal Ckt ID could not be found. </br>Circuit will need to be added manually.</h3>  Redirecting...';
	            echo '<meta http-equiv="REFRESH" content="2;url=' . $_SERVER['HTTP_REFERER'] . '">';
		          break;
		        }
		
	          $lecCkt= $row['LEC_CKT'];
		        $lecCktCln= trim(preg_replace('/[^a-zA-Z0-9\']/','',$lecCkt));
						$parentCkt= $row['PARENT_CKT'];
            $ban= $row['BAN'];
						$vendorNm= $row['VENDOR_NM'];
	          $vendorGrp= $row['VENDOR_GRP'];
	          $mrc= $row['MRC'];
	          $provSys= $row['ASAP_INSTANCE'];
		        $rateCode= $row['RATE_CODE'];
						$aClli= $row['UNQ_A_CLLI'];
			      $zClli= $row['UNQ_Z_CLLI'];
						$company= $row['MILEAGE'];
						$revexGrp= $row['REVEX_GRP'];
						$finGrp= $row['FIN_GRP'];
						$term= $row['TERM'];
						$termEnd= $row['TERM_END'];
	          $dateAdded= date("m/d/Y");
						
						if($company=='P') { $company= "Paetec"; }
						else if ($company=='W') { $company= "Windstream"; }
						else if ($company=='N') { $company= "Nuvox"; }
						else if ($company=='H') { $company= "Hosted Solutions"; }
						else if ($company=='B') { $company= "BOB"; }
						else if ($company=='I') { $company= "Iowa"; }
						else if ($company=='K') { $company= "KDL/Norlight"; }
				
				    $result2= $mysqli->query("Select * from Longhaul_Projects where ID='$projectID'");
				    $row2= $result2->fetch_assoc();
				
				    $project= $row2['PROJECT'];
				
				    $result3= $mysqli->query("Insert into Longhaul 
						(PROJECT_ID,PROJECT,VENDOR_CKT,INTERNAL_CKT,PARENT_CKT,A_CLLI,Z_CLLI,
						BAN,COMPANY,
						RATE_CODE,SRC,VENDOR_NM,VENDOR_GRP,MRC,REVEX_GRP,FIN_GRP,
	          TERM,TERM_END,
						DATE_ADDED,STATUS,FIN_FORECAST,MON_RPT) 
		        values ('$projectID','$project','$lecCkt','$internalCkt','$parentCkt','$aClli','$zClli',
						'$ban','$company',
						'$rateCode','$provSys','$vendorNm','$vendorGrp','$mrc','$revexGrp','$finGrp',
						'$term','$termEnd',
						'$dateAdded','pending','N','Y')");

            $result4= $mysqli->query("Update Population set ON_FORECAST='y' where CB_KEY='$cbKey'");
			    }
			  }
				
				echo '<div style="margin:200px auto;width:900px;text-align:center;font-family:Arial;">'; 
				echo 'Added Succesfully.</h3>  Redirecting...';
				previousPage("2");
			}
		  
			
		  //IF NOT LONGHAUL THEN METRO
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
		
		    //echo 'Project: ' . $project . '</br>';
	      //echo 'SubProject: ' . $subProject . '</br>';
		
	      $i=0;
				$existings= array();
		
        foreach($_POST['cbKey'] as $cbKey) {
		
		      //echo $cbKey . '</br>';
	  
          $result= $mysqli->query("Select * from Population where CB_KEY='$cbKey'");
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
		

	          $internalCkt= $row['EXCHANGE_CARRIER_CIRCUIT_ID'];
			      $internalCktCln= clean($internalCkt);
	          $lecCkt= $row['LEC_CKT'];
		        $lecCktCln= clean($lecCkt);
            $ban= $row['BAN'];
	          $vendor= $row['VENDOR_GRP'];
	          $mrc= $row['MRC'];
						$lata= $row['LATA'];
	          $provSys= $row['ASAP_INSTANCE'];
		        $rateCode= $row['RATE_CODE'];
			      $zClli= $row['UNQ_Z_CLLI'];
						$circuitDesignID= $row['CIRCUIT_DESIGN_ID'];
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
							(PROJECT,SUBPROJECT,PLANNER,INTERNAL_ORDER,
							INTERNAL_CKT,INTERNAL_CKT_CLN,VENDOR_CKT,VENDOR_CKT_CLN,
					    VENDOR,BAN,PROV_SYS,MRC,NEW_MRC,SAVINGS,DATE_ADDED,LAST_UPDATE,
							ON_FORECAST,FIN_FCAST,STATUS,RATE_CODE,CIRCUIT_DESIGN_ID,LATA) 
		          values 
							('$project','$subProject','$name','TBD',
							'$internalCkt','$internalCktCln','$lecCkt','$lecCktCln',
						  '$vendor','$ban','$provSys','$mrc','0.00','$mrc','$date1','$date2',
		          'y','y','IDENTIFIED','$rateCode','$circuitDesignID','$lata')");

              $result3= $mysqli->query("Update Population set ON_FORECAST='y' where CB_KEY='$cbKey'");
		
		          $i++;
	          }
	        }
        } //END FOR EACH CB_KEY
	  
		    // SHOW HOW MANY CIRCUITS WERE ADDED TO FORECAST
	      if($i>0) { 
			
	        echo '<div style="margin:200 auto;width:400px;text-align:center;font-family:Arial;">';  
          echo '<h3>' . $i . ' ';
			
		      if($i==1){ echo 'Circuit was '; } else { echo 'Circuits were '; }
		      echo 'Added Succesfully.</h3>';
				  echo '</div>';
			  }
			
			  //SHOW CIRCUITS ALREADY ON FORECAST
			  $countExisting= count($existings);
			
		    if($countExisting>0) { 
			
			    echo '<div style="width:1000px;margin:20px auto;text-align:center;">';
				
				  $data= serialize($existings);
				  $data= htmlentities($data);
				
			
			    echo '<b>' . $countExisting . ' circuits were found to be already exisiting in the forecast. </br>';
				  echo 'Are you sure you want to add these circuits to the forecast? </b></br></br>';
				  echo '<form method="post" action="population-manage-existing.php">';
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
			
			    nextUrl("population.php");
			  }
      }
		}
  }
  
  //FLAG FOR OPTIMAL WAS POSTED
  else if(isset($_POST['flag'])) {
    //CBKEY WAS POSTED
    if(isset($_POST['cbKey'])) {
	
	    $date= date("m/d/Y");
	  
	    //FOREACH CBKEY
	    foreach($_POST['cbKey'] as $cbKey) {
	  
	      //echo $cbKey . '</br>';
		
	      $result= $mysqli->query("Select * from Population where CB_KEY='$cbKey'");
        $row= $result->fetch_assoc();
		
		    $lecCkt= $row['LEC_CKT'];
		    $ban= $row['BAN'];
		  
		    //echo 'LEC CKT: ' . $lecCkt . '</br>';
		    echo 'BAN: ' . $ban . '</br>';

		    //SET OPTIMAL CURRENTLY SET TO NO
		    if(($row['OPTIMAL']=='n')||($row['OPTIMAL']=='')) { 
		
		      //echo 'Optimal currently set to No </br>';
		
		      if($row['EXCHANGE_CARRIER_CIRCUIT_ID']!='') { 
	          $internalCkt= $row['EXCHANGE_CARRIER_CIRCUIT_ID'];
		        $internalCktCln= trim(preg_replace('/[^a-zA-Z0-9\']/','',$internalCkt));
	        }
	  
	        else if($row['PARENT_CKT']!='') { 
	          $internalCkt= $row['PARENT_CKT'];
		        $internalCktCln= trim(preg_replace('/[^a-zA-Z0-9\']/','',$internalCkt));
	        }
		
		      //echo 'INTERNAL CKT: ' . $internalCkt . '</br>';
		  
          $result2= $mysqli->query("Update Population set OPTIMAL='y' where CB_KEY='$cbKey'");
		      $result3= $mysqli->query("Insert into Optimal (CB_KEY,LEC_CKT,INTERNAL_CKT,BAN,NAME,DATE_ADDED) 
		      values ('$cbKey','$lecCkt','$internalCkt','$ban','$name','$date')");    
		    }
		    //END SET OPTIMAL CURRENTLY SET TO NO
		
		    //UNSET OPTIMAL CURRENTLY SET TO YES
		    else { 

          $result2= $mysqli->query("Update Population set OPTIMAL='n' where CB_KEY='$cbKey'");
		      $result3= $mysqli->query("Delete from Optimal where CB_KEY='$cbKey')");
		    }
		    //END UNSET OPTIMAL CURRENTLY SET TO YES
      }
	    //END FOREACH CBKEY	CHECKED FOR OPTIMAL
	  
	    echo '<div style="margin:200 auto;width:400px;text-align:center;font-family:Arial;">';  
      echo '<h3>Circuits were Flagged Successfully.</h3>  Redirecting...';
	    echo '<meta http-equiv="REFRESH" content="2;url=' . $_SERVER['HTTP_REFERER'] . '">'; 
	  }
	  //END CBKEY WAS POSTED	
  }
  //END FLAG FOR OPTIMAL WAS POSTED
  
  
  //ACTION WAS NOT POSTED
  else {         
	  echo '<div style="margin:200 auto;width:400px;text-align:center;font-family:Arial;">';  
    echo '<h3>You must select an action.</h3>  Redirecting...';
	  echo '<meta http-equiv="REFRESH" content="2;url=' . $_SERVER['HTTP_REFERER'] . '">';
  }
			
?>

