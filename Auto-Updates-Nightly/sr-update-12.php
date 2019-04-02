Sr Update 12 </br>
Match Circuit/Order to Tracking Table where Order Exists but Circuit Does Not </br></br> 

<?php

  $date= date("Y-m-d");
  
  require_once('../local.php');
	require_once('../prod.php');
  require_once('../functions.php');
  
  $result= $local->query("Select * from SRTempD 
	where MATCHED=''
  and LEC_CKT_CLN!=''
	and BAN!=''
	and ORDER_NUMBER!=''
	");
  while($row= $result->fetch_assoc()) {
  
	  $id= $row['ID'];
    $orderNumber= $row['ORDER_NUMBER'];
    $internalCkt= $row['INTERNAL_CKT'];
		$circuitDesignID= $row['CIRCUIT_DESIGN_ID'];
		$sys= $row['SYS'];
		$rateCode= $row['RATE_CODE'];
		$lecCkt= $row['LEC_CKT_CLN'];
		$ban= $row['BAN'];
		$cbKey= $lecCkt . '' . $ban;
		
		$planner= $row['PLANNER'];
		$mrc= $row['MRC'];
		$vendor= $row['VENDOR'];
		
		$milePop= $row['MILE_POP'];
		$internalCktCln= trim(clean($internalCkt));
	
    echo 'Internal Ckt: ' . $internalCkt . '</br>';
    echo 'LEC Ckt: ' . $lecCkt . '</br>';
		echo 'OrderNumber: ' . $orderNumber . '</br>';
		echo 'Rate Code: ' . $rateCode . '</br>';
		echo 'Circuit Design ID: ' . $circuitDesignID . '</br>';
		
		$result2= $mysqli->query("Select PROJECT,SUBPROJECT,ASSIGNED_TO from Simple 
		where INTERNAL_ORDER='$orderNumber'
		");
		if(($result2)&&(mysqli_num_rows($result2)>0)) { 
		
		  $row2= $result2->fetch_assoc();
		
      echo 'Match Found! </br>';
			
			$project= $row2['PROJECT'];
			$subProject= $row2['SUBPROJECT'];
			$assignedTo= $row2['ASSIGNED_TO'];
			
			echo 'Project: ' . $project . '</br>';
			echo 'SubProject: ' . $subProject . '</br>';
			echo 'Assigned To: ' . $assignedTo . '</br>';
			
			$result3= $mysqli->query("Insert into Simple 
			(INTERNAL_ORDER,INTERNAL_CKT,INTERNAL_CKT_CLN,ASSIGNED_TO,VENDOR_CKT_CLN,BAN,PROJECT,SUBPROJECT,
			RATE_CODE,PROV_SYS,CIRCUIT_DESIGN_ID,VENDOR,MRC,PLANNER,DATE_ADDED,STATUS,ON_FORECAST)
			values
			('$orderNumber','$internalCkt','$internalCktCln','$assignedTo','$lecCkt','$ban','$project','$subProject',
			'$rateCode','$sys','$circuitDesignID','$vendor','$mrc','$planner','$date','IDENTIFIED','y')
			");
			
			
			if($milePop=='M') {
			
			  $result4= $mysqli->query("Update Mileage set 
				ON_FORECAST='y'
				where CB_KEY='$cbKey'");
			}
			
			else if($milePop=='P') { 
			  
				$result4= $mysqli->query("Update Population set
				ON_FORECAST='y'
				where CB_KEY='$cbKey'");
			}
			
			$result5= $local->query("Update SRTempD set 
			MATCHED='y',DATE_MATCHED='$date'
			where ID='$id'");
		}
		
		echo '</br>';
  }
  
  nextUrl("sr-update-13.php");

?>




