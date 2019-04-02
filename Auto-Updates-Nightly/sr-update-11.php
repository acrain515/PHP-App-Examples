Sr Update New 11 </br>
Identifies Mileage Circuits not in Mileage Table </br></br>

<?php

  $date= date("Y-m-d");
  
  require_once('../local.php');
	require_once('../kpi.php');
  require_once('../functions.php');
  
  $result= $local->query("Select * from SRTempD 
	where MATCHED=''
  and LEC_CKT_CLN!=''
	and BAN!=''
	and MILE_POP=''
	and ORDER_NUMBER!=''
	");
  while($row= $result->fetch_assoc()) {
  
	  $id= $row['ID'];
    $orderNumber= $row['ORDER_NUMBER'];
    $internalCkt= $row['INTERNAL_CKT'];
		$circuitDesignID= $row['CIRCUIT_DESIGN_ID'];
		$sys= $row['SYS'];
		$lecCkt= $row['LEC_CKT_CLN'];
		$internalCktCln= trim(clean($internalCkt));
		$ban= $row['BAN'];
	
    echo 'Internal Ckt: ' . $internalCkt . '</br>';
    echo 'LEC Ckt: ' . $lecCkt . '</br>';
		echo 'OrderNumber: ' . $orderNumber . '</br>';
		
		$result2 = oci_parse($kpi,"Select distinct USOC
    from Cat.CIRCUIT_DETAIL@catprd
    where CONDENSED_EC_CIRCUIT='$lecCkt'
		and DATE_OF_ENTRY>SYSDATE-90");
    oci_execute($result2);
    while($row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS)) {
		
		  $usoc= $row2['USOC'];
			
			echo 'Usoc: ' . $usoc . '</br>';
			
			if($usoc=='TMECS') {
			
			  $result4= $local->query("Update SRTempD set MILE_POP='M' 
			  where ID='$id'");
			}
			
			else {
			
			  $result3= $local->query("Select * from USOC where USOC='$usoc'");
			  if(($result3)&&(mysqli_num_rows($result3)>0)) { 
			
			    echo 'Mileage! </br>';
			
			    $result4= $local->query("Update SRTempD set MILE_POP='M' 
			    where ID='$id'");
				}
			}
		}
		
		echo '</br>';
  }
	
	oci_close($kpi);
  
  nextUrl("sr-update-12.php");

?>




