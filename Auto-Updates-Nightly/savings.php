Savings </br> 
Sets NEW_MRC='0.00' and SAVINGS=MRC for Disconnect Orders in Tracking </br>
</br> 

<?php

  require_once('../prod.php');
	require_once('../functions.php');
	

  $result= $mysqli->query("Select * from Project_Orders 
  where ACTIVITY_IND='D' and STATUS='Pending'");
  while ($row= $result->fetch_assoc()) {
  
    $internalOrder= $row['ORDER_NUMBER'];
		echo $internalOrder . '</br>';
		
		$result2= $mysqli->query("Select ID,MRC from Simple
		where INTERNAL_ORDER='$internalOrder'
		and (NEW_MRC='' or NEW_MRC='0.00')");
		while($row2= $result2->fetch_assoc()) { 
		
		  $id= $row2['ID'];
			$mrc= $row2['MRC'];
			echo 'ID: ' . $id . '</br>';
			
			$result3= $mysqli->query("Update Simple set 
			NEW_MRC='0.00',SAVINGS='$mrc'
			where ID='$id'");
		}
	  
	  echo '</br>';
	}
	
	nextUrl("exception.php");

?>


