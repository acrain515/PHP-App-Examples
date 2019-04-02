DS3 Finds Monthly Write
<?php 

  date_default_timezone_set('America/New_York');

  require_once('../../connection.php');
	require_once('../../functions.php');
	
	$today= date("Y-m-15 H:i:s");
	$todayStr=  strtotime($today);
	
	echo 'Today: ' . $today . '</br>';
	echo 'Today Str: ' . $todayStr . '</br>';
	
	$goBackStr= strtotime('-4 months',$todayStr);
	$goBack= date("Y-m-d H:i:s",$goBackStr);
	
	echo 'Go Back: ' . $goBack . '</br>';
	
	$startDate= date("Y-m-01 00:01:01",$goBackStr);
	$endDate= date("Y-m-t 23:00:00",$goBackStr);
	
	echo 'Back4 STart: ' . $startDate . '</br>';
	echo 'Back4 End: ' . $endDate . '</br>';
	
	$filename = 'ds3-finds-monthly-source.php';

  $myfile = fopen($filename, "w") or die("Unable to open file!");
  //fwrite($myfile, "<?php \n\n");
	//fwrite($myfile, "  $");
	//fwrite($myfile, "datas= array(");
	
	for($x=0;$x<4;$x++) {
	
	  $goBackStr= strtotime("+1 month", $goBackStr);
		$startDate= date("Y-m-01 00:00:00",$goBackStr);
		$endDate= date("Y-m-t 23:59:59",$goBackStr);
	
	  echo 'Start Date: ' . $startDate . '</br>';
		echo 'End Date: ' . $endDate . '</br>';
	
	  $month= date("M",$goBackStr);

    echo 'Month: ' . $month . '</br>';	

	  $result= $mysqli->query("Select count(*) as THE_COUNT from Simple 
	  where RATE_CODE='DS3'
	  and DS3_ORDER>='$startDate' and DS3_ORDER<='$endDate'");
	  $row= $result->fetch_assoc();
	
	  $count= $row['THE_COUNT'];
    echo 'Current Count: ' . $count . '</br>';
		
		fwrite($myfile,"['");
		fwrite($myfile,$month);
		fwrite($myfile,"',");
		fwrite($myfile,$count);
		fwrite($myfile,",");
		fwrite($myfile,$count);
		fwrite($myfile,",");
		
		//COLORS THE LAST BAR ORANGE
		if($x==3) { fwrite($myfile,"'color: #FB670F',"); }
		else { fwrite($myfile,"'color: #40C9FB',"); }
		
		include('goals.php');
		
		foreach($DS3FindsSave as $key=>$value) {
		echo 'Key: ' . $key . '</br>';
		  if($month==$key) { fwrite($myfile,$value); }
		}
		fwrite($myfile,",");
		
		if($x==3) { fwrite($myfile,"]");}
		else { fwrite($myfile,"],"); }

	  echo '</br>';
	}
	
	fclose($myfile); 
	
	nextUrl("ds3-finds-user-write.php");
	
?>