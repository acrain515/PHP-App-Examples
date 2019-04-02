DS3 E Write
<?php 

  date_default_timezone_set('America/New_York');

  require_once('../../connection.php');
	require_once('../../functions.php');
	
	$filename = 'ds3-e-source.php';

  $myfile = fopen($filename, "w") or die("Unable to open file!");
  //fwrite($myfile, "<?php \n\n");
	//fwrite($myfile, "  $");
	//fwrite($myfile, "datas= array(");

	//DESIGN STATUS
	  $result= $mysqli->query("Select sum(SAVINGS) as SAVINGS from Simple 
	  where RATE_CODE!='DS1'
		and STATUS in ('PENDING DESIGN','PENDING DESIGN REVIEW','PENDING DI ISSUE','PENDING DS3 INSTALL',
		'PENDING SUBORDINATE GROOM','PENDING DISC ORDER')");
	  $row= $result->fetch_assoc();
	
	  $designSavings= $row['SAVINGS'];
    echo 'Design: ' . $designSavings . '</br>';
		
		$result= $mysqli->query("Select count(*) as THE_COUNT from Simple 
	  where RATE_CODE!='DS1'
		and STATUS in ('PENDING DESIGN','PENDING DESIGN REVIEW','PENDING DI ISSUE','PENDING DS3 INSTALL',
		'PENDING SUBORDINATE GROOM','PENDING DISC ORDER')");
	  $row= $result->fetch_assoc();
		
		$designCount= $row['THE_COUNT'];
		$designAvg= round($designSavings/$designCount);
		
		fwrite($myfile,"['");
		fwrite($myfile,"Design',");
		fwrite($myfile,$designAvg);
		fwrite($myfile,",");
		fwrite($myfile,$designAvg);
		fwrite($myfile,",");
		fwrite($myfile,"'color: #40C9FB'");
		fwrite($myfile,"],");
		
		//PROVISION STATUS
	  $result= $mysqli->query("Select sum(SAVINGS) as SAVINGS from Simple 
	  where RATE_CODE!='DS1'
		and STATUS in ('PENDING PROV REVIEW','PROV REVIEW')");
	  $row= $result->fetch_assoc();
	
	  $provSavings= $row['SAVINGS'];
    echo 'Provision: ' . $provSavings . '</br>';
		
		$result= $mysqli->query("Select count(*) as THE_COUNT from Simple 
	  where RATE_CODE!='DS1'
		and STATUS in ('PENDING PROV REVIEW','PROV REVIEW')");
	  $row= $result->fetch_assoc();
	
	  $provSavings= $row['SAVINGS'];
		
		$provCount= $row['THE_COUNT'];
		$provAvg= round($provSavings/$provCount);
		
		fwrite($myfile,"['");
		fwrite($myfile,"Provision',");
		fwrite($myfile,$provAvg);
		fwrite($myfile,",");
		fwrite($myfile,$provAvg);
		fwrite($myfile,",");
		fwrite($myfile,"'color: #40C9FB'");
		fwrite($myfile,"],");
		
		//VENDOR STATUS
	  $result= $mysqli->query("Select sum(SAVINGS) as SAVINGS from Simple 
	  where RATE_CODE!='DS1'
		and STATUS in ('PENDING RESCHEDULE','PENDING VENDOR','PENDING FOC','PENDING LEC')");
	  $row= $result->fetch_assoc();
	
	  $vendorSavings= $row['SAVINGS'];
    echo 'Vendor: ' . $vendorSavings . '</br>';
		
		$result= $mysqli->query("Select count(*) as THE_COUNT from Simple 
	  where RATE_CODE!='DS1'
		and STATUS in ('PENDING RESCHEDULE','PENDING VENDOR','PENDING FOC','PENDING LEC')");
	  $row= $result->fetch_assoc();
		
		$vendorCount= $row['THE_COUNT'];
		$vendorAvg= round($vendorSavings/$vendorCount);
		
		fwrite($myfile,"['");
		fwrite($myfile,"Vendor',");
		fwrite($myfile,$vendorAvg);
		fwrite($myfile,",");
		fwrite($myfile,$vendorAvg);
		fwrite($myfile,",");
		fwrite($myfile,"'color: #40C9FB'");
		fwrite($myfile,"],");
		
		//CUSTOMER STATUS
	  $result= $mysqli->query("Select sum(SAVINGS) as SAVINGS from Simple 
	  where RATE_CODE!='DS1'
		and STATUS in ('PENDING CUSTOMER ORDER')");
	  $row= $result->fetch_assoc();
	
	  $customerSavings= $row['SAVINGS'];
    echo 'Customer: ' . $customerSavings . '</br>';
		
		$result= $mysqli->query("Select count(*) as THE_COUNT from Simple 
	  where RATE_CODE!='DS1'
		and STATUS in ('PENDING CUSTOMER ORDER')");
	  $row= $result->fetch_assoc();
		
		$customerCount= $row['THE_COUNT'];
		$customerAvg= round($customerSavings/$customerCount);
		
		fwrite($myfile,"['");
		fwrite($myfile,"Customer',");
		fwrite($myfile,$customerAvg);
		fwrite($myfile,",");
		fwrite($myfile,$customerAvg);
		fwrite($myfile,",");
		fwrite($myfile,"'color: #40C9FB'");
		fwrite($myfile,"],");
		
		//TRAFFIC STATUS
	  $result= $mysqli->query("Select sum(SAVINGS) as SAVINGS from Simple 
	  where RATE_CODE!='DS1'
		and STATUS in ('TRAFFIC')");
	  $row= $result->fetch_assoc();
	
	  $trafficSavings= $row['SAVINGS'];
    echo 'Traffic Savings: ' . $trafficSavings . '</br>';
		
		$result= $mysqli->query("Select count(*) as THE_COUNT from Simple 
	  where RATE_CODE!='DS1'
		and STATUS in ('TRAFFIC')");
	  $row= $result->fetch_assoc();
		
		$trafficCount= $row['THE_COUNT'];
		$trafficAvg= round($trafficSavings/$trafficCount);
		
		fwrite($myfile,"['");
		fwrite($myfile,"Traffic',");
		fwrite($myfile,$trafficAvg);
		fwrite($myfile,",");
		fwrite($myfile,$trafficAvg);
		fwrite($myfile,",");
		fwrite($myfile,"'color: #40C9FB'");
		fwrite($myfile,"],");
		
		//FOC STATUS
	  $result= $mysqli->query("Select sum(SAVINGS) as SAVINGS from Simple 
	  where RATE_CODE!='DS1'
		and STATUS='FOC RECEIVED'");
	  $row= $result->fetch_assoc();
	
	  $focSavings= $row['SAVINGS'];
    echo 'FOC Received: ' . $focSavings . '</br>';
		
		$result= $mysqli->query("Select count(*) as THE_COUNT from Simple 
	  where RATE_CODE!='DS1'
		and STATUS='FOC RECEIVED'");
	  $row= $result->fetch_assoc();
		
		$focCount= $row['THE_COUNT'];
		$focAvg= round($focSavings/$focCount);
		
		fwrite($myfile,"['");
		fwrite($myfile,"FOC Received',");
		fwrite($myfile,$focAvg);
		fwrite($myfile,",");
		fwrite($myfile,$focAvg);
		fwrite($myfile,",");
		fwrite($myfile,"'color: #40C9FB'");
		fwrite($myfile,"],");
		
		//SUM ALL FOR TOTAL
		$totalSavings= $focSavings+$vendorSavings+$provSavings+$designSavings+$customerSavings+$trafficSavings;
		$totalCount= $focCount+$vendorCount+$provCount+$designCount+$customerCount+$trafficCount;
		$totalAvg= round($totalSavings/$totalCount);
		
		echo 'Total: ' . $total . '</br>';
		
		fwrite($myfile,"['");
		fwrite($myfile,"Total',");
		fwrite($myfile,$totalAvg);
		fwrite($myfile,",");
		fwrite($myfile,$totalAvg);
		fwrite($myfile,",");
		fwrite($myfile,"'color: #FB670F'");
		fwrite($myfile,"]");
	
	  echo '</br>';
		
	//fwrite($myfile,");");
	
	fclose($myfile); 
	
	nextUrl("ds3-finds-monthly-savings-write.php");
	
?>