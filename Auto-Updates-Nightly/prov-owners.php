<?php 

  require_once('../prod.php');
	require_once('../local.php');

  $userArray= array();
	$workQs= array();
  
  $result= $mysqli->query("Select USER,NAME from Users 
	where (ORG='Tony Marler'
	and NAME!='Anthony Marler') or N_WIN='Axcent'");
  $count= mysqli_num_rows($result);
  $last= $count-1;
  while($row= $result->fetch_assoc()) {
  
    $user= strtoupper($row['USER']);
		$name= $row['NAME'];
	
	  array_push($userArray,$user);
		
		$result2= $local->query("Select * from Work_Queues
		where OWNER='$name'");
		
		while($row2= $result2->fetch_assoc()) { 
		
		  $qID= $row2['WORK_QUEUE_ID'];
			array_push($workQs,$qID);
		}
	
	//echo $user . '</br>';
  }
  
  $users= "(";
  for($x=0; $x<$count-1; $x++) {
    	$users.= "'$userArray[$x]',";
  }
  $users.="'$userArray[$last]'";
  $users.=")";
  
  //echo $users . '</br>';
	
	$count2= count($workQs);
	$last2= $count2-1;
	
	$qs= "(";
  for($x=0; $x<$count-1; $x++) {
    	$qs.= "'$workQs[$x]',";
  }
  $qs.="'$workQs[$last2]'";
  $qs.=")";
	
	echo $qs . '</br>';
	
?>