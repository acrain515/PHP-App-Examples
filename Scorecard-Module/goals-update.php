<?php 

  require_once('../connection2.php');

  $months= array("JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC");

  if(isset($_POST['target'])) { 
	
	  $target= $_POST['target'];
		
		//echo 'Target: ' . $target . '</br>';
		
		foreach($months as $month) {
		  ${$month}= $_POST[$month];
		
		  //echo 'Month: ' . $month . '</br>';
		  //echo 'Variable: ' . ${$month} . '</br>';
			
			$result= $dev->query("Update `Targets` set `$month`='${$month}' where `TARGET_NAME`='$target'");
			
			echo '</br>';
		}
	}
?>