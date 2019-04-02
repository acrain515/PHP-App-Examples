Sr Update New 5b </br>
Deletes where Planner Not yet Assigned and Match not Found </br>

<?php
  
  require_once('../local.php');
	require_once('../functions.php');
  
  $result= $local->query("Delete from SRTempD where MATCHED='' and PLANNER=''");
  
  nextUrl("sr-update-6.php");

?>





