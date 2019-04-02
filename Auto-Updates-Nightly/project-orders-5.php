Project Orders 5 </br> 
</br>

<?php
  
  require_once('../prod.php');
	require_once('../functions.php');
  
  $result= $mysqli->query("Select SYSORD,ORDER_NUMBER
  from Project_Orders
  where STATUS='Canceled'
  ");
  while($row= $result->fetch_assoc()) {
  
	  $sysOrd= $row['SYSORD'];
		$orderNumber= $row['ORDER_NUMBER'];
	
	  echo 'Order Number: ' . $orderNumber . '</br>';
	  echo $sysOrd . '</br>';
		
		$result2= $mysqli->query("Select ID from Simple
		where INTERNAL_ORDER='$orderNumber'");
		if(($result2)&&(mysqli_num_rows($result2)>0)) {
		
		  echo 'MatchFound </br>';
			
			while($row2= $result2->fetch_assoc()) { 
			
			  $id= $row2['ID'];
				echo 'ID: ' . $id . '</br>';
				
				$result3= $mysqli->query("Update Simple set 
				INTERNAL_ORDER='TBD'
				where ID='$id'");
			}
		}

	  echo '</br>';
	
  }
	
	nextUrl("project-tasks-1.php");
  
?>



