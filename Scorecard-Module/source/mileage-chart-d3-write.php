<?php 

  date_default_timezone_set('America/New_York');

  require_once('../../connection.php');
	require_once('../../functions.php');
	
	$firstStr= strtotime(date("Y-m-15 H:i:s"));
  $first= date("Y-m-01 00:00:00",$firstStr);
	$lastStr= strtotime(date("Y-m-d", strtotime("+1 month", $firstStr)));
	$last= date("Y-m-01 00:00:00",$lastStr);

	
	echo 'Start First: ' . $first . '</br>';
	echo 'Start Last: ' . $last . '</br>';
	
	$month= date("M",$firstStr);
	
	$filename = 'mileage-chart-d3-source.php';

  $myfile = fopen($filename, "w") or die("Unable to open file!");
  //fwrite($myfile, "<?php \n\n");
	//fwrite($myfile, "  $");
	//fwrite($myfile, "datas= array(");
	
	$names= array("Diane Bowens", "Beth Drumm", "Robyn Nichols", "Ryan Smith", "Linda Walker",
	"Michele Jackson", "Teresa Hay");
	$namesIn= "('Diane Bowens', 'Beth Drumm', 'Robyn Nichols', 'Ryan Smith', 'Linda Walker',
	'Michele Jackson', 'Teresa Hay')";
	
	foreach($names as $name) {
	
	  $result2= $mysqli->query("Select count(*) as THE_COUNT from Simple 
	  where RATE_CODE='DS1'
		and NCS_OWNER='$name'
		and (ASSIGNED_TO='' or SAVINGS>0)
	  and DATE_ADDED>='$first' and DATE_ADDED<'$last'");
	  $row2= $result2->fetch_assoc();
	
	  $count= $row2['THE_COUNT'];
		
    echo 'Count: ' . $count . '</br>';
		
		$splitNames= explode(" ",$name);
		$firstName= $splitNames[0];
		
		fwrite($myfile,"['");
		fwrite($myfile,$firstName);
		fwrite($myfile,"',");
	  fwrite($myfile,$count);
		fwrite($myfile,",");
		fwrite($myfile,$count);
		fwrite($myfile,",");
		fwrite($myfile,"'color: #40C9FB',"); 
		
		include('goals.php');
		
		foreach($WinDS1FindsIndividualCount as $key=>$value) {
		echo 'Key: ' . $key . '</br>';
		  if($month==$key) { fwrite($myfile,$value); }
		}
		
		fwrite($myfile,"],"); 

	  echo '</br>';
	}
	
	$result2= $mysqli->query("Select count(*) as THE_COUNT from Simple 
	where RATE_CODE='DS1'
  and NCS_OWNER not in $namesIn
	and (ASSIGNED_TO='' or SAVINGS>0)
	and DATE_ADDED>='$first' and DATE_ADDED<'$last'");
	$row2= $result2->fetch_assoc();
	
	$count= $row2['THE_COUNT'];
	
	fwrite($myfile,"['");
  fwrite($myfile,"Other");
	fwrite($myfile,"',");
	fwrite($myfile,$count);
	fwrite($myfile,",");
	fwrite($myfile,$count);
	fwrite($myfile,",");
	fwrite($myfile,"'color: #40C9FB',"); 
	
	include('goals.php');
		
	foreach($WinDS1FindsIndividualCount as $key=>$value) {
		echo 'Key: ' . $key . '</br>';
		if($month==$key) { fwrite($myfile,$value); }
	}
		
	fwrite($myfile,"]");
	
	fclose($myfile); 
	
	nextUrl("mileage-chart-e-write.php");
	
?>