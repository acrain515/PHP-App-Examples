<?php 

  $months= array("JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC");

  require_once('../../connection2.php');
	require_once('../../functions.php');

  $filename = 'goals.php';
  $myfile = fopen($filename, "w") or die("Unable to open file!");
	
	fwrite($myfile, "<?php \n\n");


  $result= $dev->query("Select TARGET_NAME from Targets");
  while($row= $result->fetch_assoc()) {

    $targetName= $row['TARGET_NAME'];
		
		$target= str_replace(" ","",$targetName);
	
	  
	  fwrite($myfile, "  $");
	  fwrite($myfile, "$target= array(");
	  
		$result2= $dev->query("Select * from Targets where TARGET_NAME='$targetName'");
		$row2= $result2->fetch_assoc();
		
		foreach($months as $month) { 
		
		   echo 'Month: ' . $month . '</br>';
			 $monthFormat= ucfirst(strtolower($month));
			 
			 echo 'Month Format: ' . $monthFormat . '</br>';
		
		   $goal= $row2[$month];
			
			 echo $goal . '</br>';
			
			fwrite($myfile,'"');
			fwrite($myfile,$monthFormat);
			fwrite($myfile,'"=>"');
			fwrite($myfile,$goal);
			
			if($month=='DEC') { fwrite($myfile,'"'); }
			else { fwrite($myfile,'",'); }
		}
		
		fwrite($myfile,");");
		fwrite($myfile,"\n\n");
		
	}
	
	
	fwrite ($myfile,"?>");
	fclose($myfile); 
	
	nextUrl("mileage-chart-a-write.php");
	
?>




