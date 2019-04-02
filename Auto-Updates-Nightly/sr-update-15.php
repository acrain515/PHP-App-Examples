 </br>
Inserts into Tracking where Not Matched, Project and Order For pulled from Notes</br></br> 

<?php

  $date= date("Y-m-d");
  
  require_once('../local.php');
  require_once('../functions.php');
	require_once('../prod.php');
  
  $result= $local->query("Select * from SRTempD 
	where MATCHED=''
	and DOCUMENT_NUMBER!=''
	and ORDER_FOR!=''
	and ORDER_FOR!='NF'
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
		$milePop= $row['MILE_POP'];
		$internalCktCln= clean($internalCkt);
		$assignedTo= $row['ASSIGNED_TO'];
		
		$subProject= $row['SUBPROJECT'];
		$subProject= ucwords($subProject);
		if(strpos($subProject,'Clean List')!==false) { $subProject= "Metro Clean List"; }
		else if($subProject=='Network Optimization') { $subProject= "Metro Optimization"; }
		else if($subProject=='T1 Migration') { $subProject= "T1 Migration"; }
		else if(strpos($subProject,'Mux')!==false) { $subProject= "Metro Mux"; }
		else { $subProject= "Metro Optimization"; }
		
		echo 'SubProject: ' . $subProject . '</br>';
		
		$project= 'Metro';
		
		$planner= $row['PLANNER'];
		$mrc= $row['MRC'];
		$vendor= $row['VENDOR'];
		
		$result3= $mysqli->query("Insert into Simple 
			(INTERNAL_ORDER,INTERNAL_CKT,INTERNAL_CKT_CLN,ASSIGNED_TO,VENDOR_CKT,VENDOR_CKT_CLN,BAN,PROJECT,SUBPROJECT,
			RATE_CODE,PROV_SYS,CIRCUIT_DESIGN_ID,VENDOR,MRC,PLANNER,DATE_ADDED,STATUS,ON_FORECAST)
			values
			('$orderNumber','$internalCkt','$internalCktCln','$assignedTo','$lecCkt','$lecCkt','$ban','$project','$subProject',
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
		
		echo '</br>';
  }
  
  nextUrl("designer-update.php");

?>




