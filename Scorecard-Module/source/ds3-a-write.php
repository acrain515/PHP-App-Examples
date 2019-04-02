DS3 A Write
<?php 

  date_default_timezone_set('America/New_York');

  require_once('../../connection.php');
	require_once('../../functions.php');
	
	$today= strtotime(date("Y-m-15 H:i:s"));
	$firstStr= strtotime("-2 months",$today);
  $first= date("Y-m-01 00:00:00",$firstStr);
	$lastStr= strtotime(date("Y-m-d", strtotime("-2 months", $today)));
	$last= date("Y-m-01 00:00:00",$lastStr);
	
	echo 'Start First: ' . $first . '</br>';
	echo 'Start Last: ' . $last . '</br>';
	
	$filename = 'ds3-a-source.php';

  $myfile = fopen($filename, "w") or die("Unable to open file!");
  //fwrite($myfile, "<?php \n\n");
	//fwrite($myfile, "  $");
	//fwrite($myfile, "datas= array(");
	
	for($x=0;$x<4;$x++) {
	
	  $month= date("M",$firstStr);
		
		$monthNumber= date("m",$firstStr);
		$year= date("Y",$firstStr);
		$search= $monthNumber . '%' . $year;

    echo 'Month: ' . $monthNumber . '</br>';
    echo 'Search: ' . $search . '</br>';		

	  $result= $mysqli->query("Select sum(SAVINGS) as SAVINGS from Simple 
	  where RATE_CODE!='DS1'
	  and INITIAL_FOC like '$search' and ACTUAL_FOC=''
		");
	  $row= $result->fetch_assoc();
		
		$result2= $mysqli->query("Select sum(SAVINGS) as SAVINGS from Simple
		where RATE_CODE!='DS1'
		and ACTUAL_FOC like '$search'
		");
		$row2= $result2->fetch_assoc();
		
		$result3= $mysqli->query("Select INTERNAL_CKT_CLN,RATE_CODE,ACTUAL_FOC,SAVINGS
		from Simple 
		where RATE_CODE!='DS1'
		and ACTUAL_FOC like '$search'");
		while($row3= $result3->fetch_assoc()) {
		
		  echo $row3['INTERNAL_CKT_CLN'] . ' ' . $row3['RATE_CODE'] . ' ' . $row3['ACTUAL_FOC'] . ' ' . $row3['SAVINGS'] . '</br>';
		}
	
	  $savings= $row['SAVINGS'];
		$savings2= $row2['SAVINGS'];
		$totalSavings= round($savings+$savings2);
		$totalSavings= substr($totalSavings,0,-3);
		
		echo 'Savings 1: ' . $savings . '</br>';
		echo 'Savings 2: ' . $savings2 . '</br>';
    echo 'Current Savings: ' . $totalSavings . '</br>';
		
		fwrite($myfile,"['");
		fwrite($myfile,$month);
		fwrite($myfile,"',");
		fwrite($myfile,$totalSavings);
		fwrite($myfile,",");
		fwrite($myfile,$totalSavings);
		fwrite($myfile,",");
		
		//COLORS THE CURRENT BAR ORANGE
		if($x==2) { fwrite($myfile,"'color: #FB670F',"); }
		else { fwrite($myfile,"'color: #40C9FB',"); }
		
		include('goals.php');
		
		foreach($DS3CutsSave as $key=>$value) {
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
	
	nextUrl("ds3-b-write.php");
	
?>

