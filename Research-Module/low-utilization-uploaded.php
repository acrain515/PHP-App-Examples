<body style="font-family:Arial;">
<div style="width:200px;margin:200px auto;">
<?php

    require_once('../connection.php');

    $fh = fopen($_FILES['file']['tmp_name'], 'r+');

    $lines = array();
	
	$filename = 'temp/'.$clli.'.txt';

    $myfile = fopen("low-utilization.txt", "w") or die("Unable to open file!");
    fwrite($myfile, "{\n");
    fwrite($myfile,"  \"data\": [\n");

    while(($row = fgetcsv($fh, 8192)) !== FALSE ) {
       $lines[] = $row;
    }
	
	$count= count($lines);
    $i=0;

    foreach($lines as $line) {

      $i++;
      
      if(($i>1)&&($line[0]!=='')) {
 
        //print_r($line);
        //echo '</br></br>';

        $internalCkt= mysqli_real_escape_string($mysqli,$line[0]);
        $availablePorts= mysqli_real_escape_string($mysqli,$line[1]);
        $sys= mysqli_real_escape_string($mysqli,$line[2]);
		
		fwrite($myfile,"    [\n");
	    fwrite($myfile,"      \"<input class=\\\"checkbox1\\\" type=\\\"checkbox\\\" name=\\\"internalCkt[]\\\" value=\\\"$internalCkt\\\">\",\n");
	    fwrite($myfile,"      \"$internalCkt\",\n");
	    fwrite($myfile,"      \"$availablePorts\",\n");
	    fwrite($myfile,"      \"$sys\"\n");
	
	    if($i<$count) { fwrite($myfile,"    ],\n"); }
	
	    else { fwrite($myfile,"    ]\n"); }
      }
    }

    fwrite($myfile,"  ]\n");
    fwrite($myfile, "}\n");
    fclose($myfile); 

    echo '<h2>Upload Successful</h2>';
    echo '<h3>Redirecting....</h3>';
    echo '<meta http-equiv="REFRESH" content="1;url=index.php">';

?>

</div>
</body>
