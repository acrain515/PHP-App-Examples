Sr Update 13 </br>
Get Order For and Project-  DS1s Not Yet Matched</br></br> 

<?php

  $date= date("Y-m-d");
  
  require_once('../local.php');
  require_once('../functions.php');
	require_once('../kpi.php');
  
  $result= $local->query("Select * from SRTempD 
	where MATCHED=''
	and DOCUMENT_NUMBER!=''
	and ORDER_FOR=''
	and RATE_CODE='DS1'
	group by DOCUMENT_NUMBER
	order by ID desc
	");
  while($row= $result->fetch_assoc()) {
  
	  $id= $row['ID'];
    $documentNumber= $row['DOCUMENT_NUMBER'];
		$orderNumber= $row['ORDER_NUMBER'];
		$planner= $row['PLANNER'];
		$sys= $row['SYS'];
		
		include('../system-tables-kpi.php');
	
		echo '<b>DocumentNumber: ' . $documentNumber . '</b></br>';
		echo 'Sys: ' . $sys . '</br>';
		echo 'Order Number: ' . $orderNumber . '</br>';
		echo 'Planner: ' . $planner . '</br>';
		
		$orderFor="";
		$subProject="";
		
		
		$result2 = oci_parse($kpi,"Select NOTE_TEXT
    from $tableNotes
    where DOCUMENT_NUMBER='$documentNumber'
    and SYSTEM_GEN_IND='N'
		and NOTE_TEXT not like 'Circuit User Data%'
    ");
    oci_execute($result2);
    while($row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS)) {
		
		  $notes= $row2['NOTE_TEXT'];
			
	    echo 'Notes: ' . $notes . '</br>';
			
			if(
			  ((stripos($notes,'Groom')!==false)||(stripos($notes,'move')!==false))
				&&
				((stripos($notes,'DS1')!==false)||(stripos($notes,'T1')!==false)||(stripos($notes,'DS-1')!==false))
				&&
				((stripos($notes,'disconnect')!==false)||(stripos($notes,'clear')!==false))
				&&
				((stripos($notes,'DS3')!==false)||(stripos($notes,'DS-3')!==false))
			){ 
			
			  $orderFor= "Clear DS3";
				
				if(stripos($notes,'Project Name')!==false) { 
			
			    $subProject= scrape($notes,"Project Name","\n");
					$subProject= str_replace(":","",$subProject);
					$subProject= trim($subProject);
			  }
				
				else if(stripos($notes,'PROJECT:')!==false) { 
			
			    $subProject= scrape($notes,"Project:","\n");
					$subProject= trim($subProject);
			  }

			}
			
			else if(
			  ((stripos($notes,'DS1')!==false)||(stripos($notes,'T1')!==false)||(stripos($notes,'DS-1')!==false)
				||(stripos($notes,'mile')!==false))
				&&
				((stripos($notes,'mileage')!==false)||(stripos($notes,'correct location')!==false)||(stripos($notes,'correct co')!==false))
			) {
			
			  $orderFor= "Mileage";
				$subProject= "T1 Migration";
			}
		}
		
		if($orderFor!='') {  
		
		  if($subProject=='') {  $subProject= "Metro Optimization"; }
			
			echo 'Order For: ' . $orderFor . '</br>';
			echo 'SubProject: ' . $subProject . '</br>';
				
			$result4= $local->query("Update SRTempD set 
		  ORDER_FOR='$orderFor',
		  SUBPROJECT='$subProject'
		  where DOCUMENT_NUMBER='$documentNumber'");
		}
		
		else {
		  $result4= $local->query("Update SRTempD set 
		  ORDER_FOR='NF'
		  where DOCUMENT_NUMBER='$documentNumber'");
		}
		
		
		
		echo '</br>';
  }
  
  nextUrl("sr-update-14.php");

?>




