
<?php 

  require_once('options.php');

  foreach($discStatusOptions as $option) {

    echo '<option value="'.$option.'">'.$option.'</option>';
  }	
	
?>	