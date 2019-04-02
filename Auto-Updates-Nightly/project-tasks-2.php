Project Tasks 2 </br>
What: PAST_SLA (calculated from Aging and sla.php) </br>
To: Project_Tasks </br>

</br>

<?php

  //DETERMINES AND STORES DAYS PAST SLA
	
  require_once('../prod.php');
	require_once('../functions.php');
		
  $result2= $mysqli->query("Select * from Project_Tasks");
	while($row2= $result2->fetch_assoc()) {
		
		$id= $row2['ID'];
		$task= $row2['TASK_TYPE'];
		$daysReady= $row2['DAYS_READY'];
		
		  echo 'Task: ' . $task;
		  echo 'Days Ready: ' . $daysReady . '</br>';
		
		  include('sla.php');
	  
	    if($daysReady>$sla) {
	  
	      $pastSLA= $daysReady-$sla;
		  }
			
			else { $pastSLA="0"; }
		
		  echo 'Past SLA: ' . $pastSLA . '</br>';
		  echo '</br>';
			
			$result3= $mysqli->query("Update Project_Tasks set PAST_SLA='$pastSLA'
			where ID='$id'");
  }
	
	nextUrl("ds3-cancel-ds1.php");
	
?>


