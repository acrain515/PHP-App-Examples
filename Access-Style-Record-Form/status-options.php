
<?php 

  require_once('options.php');

  foreach($researchStatusOptions as $option) {

    echo '<option value="'.$option.'">'.$option.'</option>';
  }	
	
?>	