Project Orders 2c </br> 
What: Disc Order </br>
From: Longhaul </br>
To: Project_Orders </br></br>
<?php

  $date= date("d-m-Y", strtotime("-72 months", strtotime(date("d-m-Y"))));

  require_once('../prod.php');
	require_once('../functions.php');
	require_once('../kpi.php');
	
	$systems= array("NVX","PAE","TSG","WIN");
  
  $result= $mysqli->query("Select * from Project_Orders
  where INVENTORY_SYS='NF'
  ");
  while($row= $result->fetch_assoc()) {
  
	  $sysOrd= $row['SYSORD'];
    $orderNumber= $row['ORDER_NUMBER'];
	   
		echo $orderNumber . '</br>';
		$foundDocumentNumber= "";
		$foundSys= "";
		$found= "";
		
		$docs= array();
		foreach($systems as $sys) { 
		
		  //echo 'Sys: ' . $sys . '</br>';
		
		  include('../system-tables-kpi.php');
			
			$result2 = oci_parse($kpi,"Select DOCUMENT_NUMBER,LAST_MODIFIED_DATE
      from $tableSR
      where ORDER_NUMBER='$orderNumber' 
			and (
			  LAST_MODIFIED_DATE>TO_DATE('$date','mm/dd/yyyy')
				or 
				GMT_DT_TM_RECEIVED>TO_DATE('$date','mm/dd/yyyy')
			)
			and rownum<2
      ");
      oci_execute($result2);
      $row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);
			
			$documentNumber= $row2['DOCUMENT_NUMBER'];
			$lmd= strtotime($row2['LAST_MODIFIED_DATE']);
			
			if($documentNumber!='') {  
			
			  array_push($docs,array($lmd,$documentNumber,$sys));
				$found= 'y';
			}
		}
		
		echo '</br>';
		
		$countDocs= count($docs);
		if($countDocs>0) { 
		
		  if($countDocs>1) { rsort($docs); echo '<b>More than 1 Found</b></br>'; }
			
			print_r($docs);
		
		  $foundDocumentNumber= $docs[0][1];
			$foundSys= $docs[0][2];
			
			echo 'Found Document Number: ' . $docs[0][1] . '</br>';
			echo 'Found Sys: ' . $docs[0][2] . '</br>';
		}
		
		echo 'Found Document Number: ' . $foundDocumentNumber . '</br>';
		echo 'Found Sys: ' . $foundSys . '</br>';
		
		if($foundDocumentNumber=='') {  
		
		  $result3= $mysqli->query("Update Project_Orders set 
			INVENTORY_SYS='NF2' 
			where SYSORD='$sysOrd'");
		}
		
		else {
		
		  $result3= $mysqli->query("Update Project_Orders set 
			INVENTORY_SYS='$foundSys',
      DOCUMENT_NUMBER='$foundDocumentNumber'			
			where SYSORD='$sysOrd'");
		}
		
		echo '</br>';
  }
	
	nextUrl("project-orders-3.php");
  
?>
