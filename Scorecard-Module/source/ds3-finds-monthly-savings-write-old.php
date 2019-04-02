<?php 

  date_default_timezone_set('America/New_York');

  require_once('../../connection.php');
	require_once('../../functions.php');
	
	$today= strtotime(date("Y-m-15 H:i:s"));
	$firstStr= strtotime("-3 months",$today);
  $first= date("Y-m-01 00:00:00",$firstStr);
	$lastStr= strtotime(date("Y-m-d", strtotime("-2 months", $today)));
	$last= date("Y-m-01 00:00:00",$lastStr);

	
	echo 'Start First: ' . $first . '</br>';
	echo 'Start Last: ' . $last . '</br>';
	
	$filename = 'ds3-finds-monthly-savings-source.php';

  $myfile = fopen($filename, "w") or die("Unable to open file!");
  //fwrite($myfile, "<?php \n\n");
	//fwrite($myfile, "  $");
	//fwrite($myfile, "datas= array(");
	
	for($x=0;$x<4;$x++) {
	
	  $month= date("M",$firstStr);

    echo 'Month: ' . $month . '</br>';	

	  $result= $mysqli->query("Select sum(SAVINGS) as SAVINGS from Simple 
	  where RATE_CODE='DS3'
	  and DATE_ADDED>='$first' and DATE_ADDED<'$last'");
	  $row= $result->fetch_assoc();
	
	  $savings= round($row['SAVINGS']);
		$savings= substr($savings,0,-3);
		
    echo 'Current Count: ' . $savings . '</br>';
		
		fwrite($myfile,"['");
		fwrite($myfile,$month);
		fwrite($myfile,"',");
		fwrite($myfile,$savings);
		fwrite($myfile,",");
		fwrite($myfile,$savings);
		fwrite($myfile,",");
		
		//COLORS THE LAST BAR ORANGE
		if($x==3) { fwrite($myfile,"'color: #FB670F',"); }
		else { fwrite($myfile,"'color: #40C9FB',"); }
		
		include('goals.php');
		
		foreach($DS3FindsSave as $key=>$value) {
		echo 'Key: ' . $key . '</br>';
		  if($month==$key) { fwrite($myfile,$value); }
		}
		
		if($x==3) { fwrite($myfile,"]");}
		else { fwrite($myfile,"],"); }
		
	  $firstStr= strtotime("+1 month", $firstStr);
		$first= date("Y-m-01 00:00:00",$firstStr);
		$lastStr= strtotime("+1 month",$lastStr);
		$last= date("Y-m-01 00:00:00",$lastStr);
	
	  echo 'First: ' . $first . '</br>';
		echo 'Last: ' . $last . '</br>';
	

	  echo '</br>';
	}
		
	//fwrite($myfile,");");
	
	fclose($myfile); 
	
	nextUrl("ds3-finds-monthly-write.php");
	
?>