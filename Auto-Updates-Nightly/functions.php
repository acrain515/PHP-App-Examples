<?php 

  function nextUrl($url) {
    echo '<meta http-equiv="refresh" content="1; url='.$url.'">';
  }
  
  function refreshPage($x) {
	
    echo '<meta http-equiv="REFRESH" content="1;url=' . $_SERVER['HTTP_REFERER'] . '">';
  }
	
	function clean($x) { 
	
	  $y= trim(preg_replace('/[^a-zA-Z0-9\']/','',$x));
		return $y;
	}
  
?>