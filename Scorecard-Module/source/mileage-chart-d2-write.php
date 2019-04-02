Mileage D2 Write
<?php 

  date_default_timezone_set('America/New_York');

  require_once('../../connection.php');
	require_once('../../functions.php');
	
	$firstStr= strtotime(date("Y-m-15 H:i:s"));
  $startDate= date("Y-m-01 00:00:00",$firstStr);
	$lastStr= strtotime(date("Y-m-d", strtotime("+1 month", $firstStr)));
	$endDate= date("Y-m-01 00:00:00",$lastStr);

	
	$month= date("M",$firstStr);
	
	echo 'Start First: ' . $startDate . '</br>';
	echo 'Start Last: ' . $endDate . '</br>';
	
	$filename = 'mileage-chart-d2-source.php';

  $myfile = fopen($filename, "w") or die("Unable to open file!");

	include('1-axcent-owners.php');
	
	//QUERY THE AXC COUNTS
	$result5= $mysqli->query("Select count(*) as THE_COUNT from Simple 
	where RATE_CODE='DS1'
  and NCS_OWNER in $namesIn
	and DATE_ADDED>='$startDate' and DATE_ADDED<'$endDate'
	and (ASSIGNED_TO='' or SAVINGS>0)
	");
	$row5= $result5->fetch_assoc();
	
	echo '</br>';
	echo $first . '</br>';
	echo $last . '</br>';
	echo $namesIn . '</br>';
	
	$count= $row5['THE_COUNT'];
  echo 'Count: ' . $count . '</br>';
	
	//WRITE THE AXC COUNTS TO LAST COLUMN
		
	fwrite($myfile,"['");
	fwrite($myfile,"Axcent");
	fwrite($myfile,"',");
	fwrite($myfile,$count);
	fwrite($myfile,",");
	fwrite($myfile,$count);
	fwrite($myfile,",");
	fwrite($myfile,"'color: #40C9FB',"); 
	
	include('goals.php');
		
	foreach($AxcentDS1FindsCount as $key=>$value) {
		echo 'Key: ' . $key . '</br>';
		if($month==$key) { fwrite($myfile,$value); }
	}
		
	fwrite($myfile,"]");
	
		
	//fwrite($myfile,");");
	
	fclose($myfile); 
	
	nextUrl("mileage-chart-d3-write.php");
	
?>