<?php 

  date_default_timezone_set('America/New_York');

  require_once('../../connection.php');
	require_once('../../functions.php');
	
	$filename = 'mileage-chart-e-source.php';

  $myfile = fopen($filename, "w") or die("Unable to open file!");
  //fwrite($myfile, "<?php \n\n");
	//fwrite($myfile, "  $");
	//fwrite($myfile, "datas= array(");

	//DESIGN STATUS
	  $result= $mysqli->query("Select sum(SAVINGS) as SAVINGS from Simple 
	  where RATE_CODE='DS1'
		and STATUS in ('PENDING DESIGN','PENDING DESIGN REVIEW','PENDING DI ISSUE','PENDING DS3 INSTALL',
		'PENDING SUBORDINATE GROOM','PENDING DISC ORDER','TRAFFIC')
		and (ASSIGNED_TO='' or SAVINGS>0)
		");
	  $row= $result->fetch_assoc();
	
	  $design= round($row['SAVINGS']);
		$design= substr($design,0,-3);
		
    echo 'Design: ' . $design . '</br>';
		
		fwrite($myfile,"['");
		fwrite($myfile,"Design',");
		fwrite($myfile,$design);
		fwrite($myfile,",");
		fwrite($myfile,$design);
		fwrite($myfile,",");
		fwrite($myfile,"'color: #40C9FB'");
		fwrite($myfile,"],");
		
		//PROVISION STATUS
	  $result= $mysqli->query("Select sum(SAVINGS) as SAVINGS from Simple 
	  where RATE_CODE='DS1'
		and STATUS in ('PENDING PROV REVIEW','PROV REVIEW')
		and (ASSIGNED_TO='' or SAVINGS>0)
		");
	  $row= $result->fetch_assoc();
	
	  $prov= round($row['SAVINGS']);
		$prov= substr($prov,0,-3);
		
    echo 'Provision: ' . $prov . '</br>';
		
		fwrite($myfile,"['");
		fwrite($myfile,"Provision',");
		fwrite($myfile,$prov);
		fwrite($myfile,",");
		fwrite($myfile,$prov);
		fwrite($myfile,",");
		fwrite($myfile,"'color: #40C9FB'");
		fwrite($myfile,"],");
		
		//VENDOR STATUS
	  $result= $mysqli->query("Select sum(SAVINGS) as SAVINGS from Simple 
	  where RATE_CODE='DS1'
		and STATUS in ('PENDING RESCHEDULE','PENDING VENDOR','PENDING FOC','PENDING LEC')
		and (ASSIGNED_TO='' or SAVINGS>0)
		");
	  $row= $result->fetch_assoc();
	
	  $vendor= round($row['SAVINGS']);
		$vendor= substr($vendor,0,-3);
		
    echo 'Vendor: ' . $vendor . '</br>';
		
		fwrite($myfile,"['");
		fwrite($myfile,"Vendor',");
		fwrite($myfile,$vendor);
		fwrite($myfile,",");
		fwrite($myfile,$vendor);
		fwrite($myfile,",");
		fwrite($myfile,"'color: #40C9FB'");
		fwrite($myfile,"],");
		
		//FOC STATUS
	  $result= $mysqli->query("Select sum(SAVINGS) as SAVINGS from Simple 
	  where RATE_CODE='DS1'
		and STATUS='FOC RECEIVED'
		and (ASSIGNED_TO='' or SAVINGS>0)
		");
	  $row= $result->fetch_assoc();
	
	  $foc= round($row['SAVINGS']);
		$foc= substr($foc,0,-3);
		
    echo 'FOC Received: ' . $foc . '</br>';
		
		fwrite($myfile,"['");
		fwrite($myfile,"FOC Received',");
		fwrite($myfile,$foc);
		fwrite($myfile,",");
		fwrite($myfile,$foc);
		fwrite($myfile,",");
		fwrite($myfile,"'color: #40C9FB'");
		fwrite($myfile,"],");
		
		//SUM ALL FOR TOTAL
		$total= $foc+$vendor+$prov+$design;
		
		echo 'Total: ' . $total . '</br>';
		
		fwrite($myfile,"['");
		fwrite($myfile,"Total',");
		fwrite($myfile,$total);
		fwrite($myfile,",");
		fwrite($myfile,$total);
		fwrite($myfile,",");
		fwrite($myfile,"'color: #FB670F'");
		fwrite($myfile,"]");
	
	  echo '</br>';
		
	//fwrite($myfile,");");
	
	fclose($myfile); 
	
	nextUrl("mileage-chart-f-write.php");
	
?>