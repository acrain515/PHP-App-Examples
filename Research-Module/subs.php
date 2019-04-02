<?php
date_default_timezone_set('America/New_York');
  
  require_once('../connection.php');
  
  if(!isset($_COOKIE['oatmeal'])) { echo '<meta http-equiv="REFRESH" content="0;url=../login.php">'; }
  
  $raisin= $_COOKIE['oatmeal'];
  //$raisin= "qm7he7fs7t";

  $chocolate= $mysqli->query("Select * from Users where RAISIN='$raisin'");
    
  $macadamia= $chocolate->fetch_assoc(); 
  $name= $macadamia['NAME'];
  
  $ids= $_GET['ids'];
  
  ?>
<div style="margin:200 auto;width:400px;text-align:center;font-family:Arial;">
You added DS3s to the forecast. </br> Do you also want to add the DS1s assigned to those DS3s to the forecast?
</br></br>
<form method="post" action="subs-add.php">
Yes<input type="radio" name="add" value="y">
No<input type="radio" name="add" value="n"></br>
<input type="hidden" name="ids" value="<?php echo $ids; ?>">
<input type="submit" value="Submit">
</form>
</div>