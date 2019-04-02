<?php 

  date_default_timezone_set('America/New_York');

  require_once('../../connection.php');
	require_once('../../functions.php');
	
	$firstStr= strtotime(date("Y-m-15 H:i:s"));
  $first= date("Y-m-01 00:00:00",$firstStr);
	$lastStr= strtotime(date("Y-m-d", strtotime("+1 month", $firstStr)));
	$last= date("Y-m-01 00:00:00",$lastStr);
	
	$monthNumber= date("m",$firstStr);
	$year= date("Y",$firstStr);
	$search= $monthNumber . '%' . $year;

  echo 'Month: ' . $monthNumber . '</br>';
  echo 'Search: ' . $search . '</br>';
	
	echo 'Start First: ' . $first . '</br>';
	echo 'Start Last: ' . $last . '</br>';
	
	$filename = 'mileage-chart-i-source.php';

  $myfile = fopen($filename, "w") or die("Unable to open file!");
  //fwrite($myfile, "<?php \n\n");
	//fwrite($myfile, "  $");
	//fwrite($myfile, "datas= array(");
	
	//$names= array("Ryan Smith","Robyn Nichols","Linda Walker","Michele Jackson");
	
	$result= $mysqli->query("Select NAME from Users 
	where ORG='Tony Marler' and NAME not in ('Anthony Marler','Matthew Clarke') and N_WIN='DS1'");
	while($row= $result->fetch_assoc()) {
	
	  $name= $row['NAME'];
	
	//foreach($names as $name) {
	
	  $result2= $mysqli->query("Select count(*) as THE_COUNT from Simple 
	  where RATE_CODE='DS1'
		and PROV_OWNER='$name'
		and INITIAL_FOC like '$search' and ACTUAL_FOC=''
		and SAVINGS>0
	  ");
	  $row2= $result2->fetch_assoc();
	
	  $count= $row2['THE_COUNT'];
		
		$result2= $mysqli->query("Select count(*) as THE_COUNT from Simple 
	  where RATE_CODE='DS1'
		and PROV_OWNER='$name'
		and ACTUAL_FOC like '$search'
		and SAVINGS>0
	  ");
	  $row2= $result2->fetch_assoc();
	
	  $count2= $row2['THE_COUNT'];
		
		$totalCount= $count+$count2;
		
		$splitNames= explode(" ",$name);
		$firstName= $splitNames[0];
		
		fwrite($myfile,"['");
		fwrite($myfile,$firstName);
		fwrite($myfile,"',");
	  fwrite($myfile,$totalCount);
		fwrite($myfile,",");
		fwrite($myfile,$totalCount);
		fwrite($myfile,",");
		fwrite($myfile,"'color: #40C9FB',");
		fwrite($myfile,"77],");

	  echo '</br>';
	}
	
	fclose($myfile); 
	
	nextUrl ("ds3-a-write.php");
	
?>

