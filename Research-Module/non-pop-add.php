<?php

  date_default_timezone_set('America/New_York');
  
  require_once('../cookie.php');
	require_once('../connection.php');
	
	if(is_null($_POST['rateCode'])) { 
	
	  echo '<div style="margin:200 auto;width:400px;text-align:center;font-family:Arial;">';  
    echo '<h3>ERROR</h3>';
		echo 'Rate Code Must be Selected';
		echo '<meta http-equiv="REFRESH" content="4;url=non-pop.php">';
	}
	
	else {
  
    $circuit= $_POST['circuit'];
    $type= $_POST['type'];
    $source= $_POST['source'];
    $project= $_POST['project'];
	  $rateCode= $_POST['rateCode'];
		
		//echo 'Type: ' . $type . '</br>';
		//echo 'Rate Code: ' . $rateCode . '</br>';
    
		$dateAdded= date("m/d/Y");
    $circuitCln= trim(preg_replace('/[^a-zA-Z0-9\']/','',$circuit));
		
		if(($rateCode=='DS1')&&(is_null($_POST['ds1For']))) { 
		
		  echo '<div style="margin:200 auto;width:400px;text-align:center;font-family:Arial;">';  
      echo '<h3>ERROR</h3>';
		  echo 'If DS1, Must select what DS1 is For.';
			echo '<meta http-equiv="REFRESH" content="4;url=non-pop.php">';
		}
		
		else {
		
		  if(isset($_POST['ds1For'])) { $owner= $_POST['ds1For']; }
			else { $owner==''; }
			
			//echo 'Owner: ' . $owner . '</br>';

      if($type=='lec') {
  
        $result= $mysqli->query("Select * from Mileage where LEC_CKT='$circuitCln' limit 1");
	      $result2= $mysqli->query("Select * from Population where LEC_CKT='$circuitCln' limit 1");
        if((($result)&&(mysqli_num_rows($result)>0))|| (($result2)&&(mysqli_num_rows($result2)>0))) {
  
          echo '<div style="margin:200 auto;width:400px;text-align:center;font-family:Arial;">';  
          echo '<h3>ERROR</h3>';
	        echo 'Circuit was found in Mileage or Population, can only be added from there.';
	        echo '<meta http-equiv="REFRESH" content="4;url=non-pop.php">';
        }
	
        else {
	
	        $result3= $mysqli->query("Select * from Simple where VENDOR_CKT_CLN='$circuitCln' limit 1");
	        if(($result3)&&(mysqli_num_rows($result3)>0)) {
	          echo '<div style="margin:200 auto;width:400px;text-align:center;font-family:Arial;">';  
            echo '<h3>ERROR</h3>';
	          echo 'Circuit is already on Forecast.</br>Redirecting...';
	          echo '<meta http-equiv="REFRESH" content="4;url=non-pop.php">';
	        }
	  
	        else {
	
	          $circuitCln= mysqli_real_escape_string($mysqli,$circuitCln);
  
            $result= $mysqli->query("Insert into Pull_Subs (INTERNAL_CKT,SYS,CIRCUIT_DESIGN_ID,PROJECT,OWNER,DATE_ADDED)
            values ('$circuit','$source','$type','$project','$owner','$dateAdded')");

            echo '<div style="margin:200 auto;width:400px;text-align:center;font-family:Arial;">';  
            echo '<h3>Save Successful.</h3> Circuit and associated info will be added to system within 24 hours.';
            echo '<meta http-equiv="REFRESH" content="4;url=non-pop.php">';
	        }
        }
      }
  
      else {
  
        if(strpos($circuit,'/')!==false) {
  
	        $result= $mysqli->query("Select * from Population where EC_ID_CLN='$circuitCln' limit 1");
          if(($result)&&(mysqli_num_rows($result)>0)) {
  
            echo '<div style="margin:200 auto;width:400px;text-align:center;font-family:Arial;">';  
            echo '<h3>ERROR</h3>';
	          echo 'Circuit was found in Population, can only be added from there.';
	          echo '<meta http-equiv="REFRESH" content="4;url=non-pop.php">';
          }
	
          else {
	  
	          $result2= $mysqli->query("Select * from Simple where INTERNAL_CKT_CLN='$circuitCln' limit 1");
		        if(($result2)&&(mysqli_num_rows($result2)>0)) {
		          echo '<div style="margin:200 auto;width:400px;text-align:center;font-family:Arial;">';  
              echo '<h3>ERROR</h3>';
	            echo 'Circuit is already on Forecast.</br>Redirecting...';
	            echo '<meta http-equiv="REFRESH" content="4;url=non-pop.php">';
		        }
		
		        else {
	
	            $circuitCln= mysqli_real_escape_string($mysqli,$circuitCln);
  
              $result= $mysqli->query("Insert into Pull_Subs (INTERNAL_CKT,SYS,CIRCUIT_DESIGN_ID,PROJECT,OWNER,DATE_ADDED)
              values ('$circuit','$source','$type','$project','$owner','$dateAdded')");

              echo '<div style="margin:200 auto;width:400px;text-align:center;font-family:Arial;">';  
              echo '<h3>Save Successful.</h3> Circuit and associated info will be added to system within 24 hours.';
              echo '<meta http-equiv="REFRESH" content="4;url=non-pop.php">';
		        }
	        }
        }
	
	      else {
	        echo '<div style="margin:200 auto;width:400px;text-align:center;font-family:Arial;">';  
          echo '<h3>ERROR.</h3>Please include slashes for Internal Ckt IDs.</br>Redirecting...';
          echo '<meta http-equiv="REFRESH" content="4;url=non-pop.php">';
				}
	    }
    }
	}
  
?>
  
  