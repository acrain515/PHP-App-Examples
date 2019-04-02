<div style="width:400px;margin:200px auto;text-align:center;font-family:Arial;font-size:18px;">

<?php 

  require_once('../functions.php');
	date_default_timezone_set('America/New_York');

  if(isset($_POST['LEC_CKT'])) { 
	
	  $LEC_CKT= $_POST['LEC_CKT'];
	  $BAN= $_POST['BAN'];
	  $RESEARCHER= $_POST['RESEARCHER'];
		$PROJECT= $_POST['PROJECT'];
		$SUBPROJECT= $_POST['SUBPROJECT'];
	
	  //echo 'Lec Ckt: ' . $LEC_CKT . '</br>';
	  //echo 'BAN: ' . $BAN . '</br>';
	  //echo 'Researcher: ' . $RESEARCHER . '</br>';
	
	  if(($LEC_CKT!='')&&($BAN!='')) {
		
		  $date= date("Y-m-d");

	    $cbKey= $LEC_CKT . '' . $BAN;
			$lecCktCln= trim(preg_replace('/[^a-zA-Z0-9\']/','',$LEC_CKT));
	
	    require_once('../connection.php');
	
	    $result2= $mysqli->query("Select * from Dbb where CB_KEY='$cbKey'");
	    if(($result2)&&(mysqli_num_rows($result2)>0)) { 
	
	      echo 'ERROR</br></br>';
		    echo 'Circuit already exists in database.</br></br>';
		    echo '<span style="font-size: 15px;">Redirecting... </span></br>';
		
		    echo '<span style="font-size: 15px;"><meta http-equiv="REFRESH" content="4;url=index.php"></span>';
	    }
	
	    else {
			
			  $result3= $mysqli->query("Insert into Dbb 
				(CB_KEY,LEC_CKT,LEC_CKT_CLN,BAN,RESEARCHER,PROJECT,SUBPROJECT,DATE_ADDED,RESEARCH_STATUS)
				values
				('$cbKey','$LEC_CKT','$lecCktCln','$BAN','$RESEARCHER','$PROJECT','$SUBPROJECT','$date','Pending Review')
				");
				
				echo 'Circuit Added Successfully. </br></br>';
				echo 'Redirecting... </br>';
				echo '<meta http-equiv="REFRESH" content="2;url=index.php">';
      }
	
    }

    else { 

      echo 'ERROR</br></br>';
	    echo 'LEC Ckt ID and BAN must be entered.</br></br>';
	    echo '<span style="font-size: 15px;">Redirecting... </span></br>';
	    echo '<meta http-equiv="REFRESH" content="4;url=index.php">';
    }
	}
	
	else { 
	
	  echo '<meta http-equiv="REFRESH" content="0;url=index.php">';
	}


?>
</div>


