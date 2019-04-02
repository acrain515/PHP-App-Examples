<?php

  if(isset($_GET['n'])) {
  
    $n= $_GET['n'];
	  $f= $_GET['f'];
  
    echo $n . '</br>';
	  echo $f . '</br>';
	
	  $file = 'Custom/'.$n.'/'.$f.'.php';
		
	  echo $file . '</br>';
	
	  unlink($file);
	
	  echo '<meta http-equiv="refresh" content="0; url=custom.php">';
	
  }
  
 ?>