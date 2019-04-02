<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
<title>Goals Admin - Utopia</title>
<?php 
require_once('../connection2.php');
$months= array("JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC");
?>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	
<style>
* { font-family:Arial;font-size:13px; }
table { border-collapse:collapse; }
input { background:#ededed;width:60px;border:0;font-size:17px; }
td { background:#ededed;border-top:1px solid #1492DA;border-bottom:1px solid #1492DA;
border-left:1px solid #777;border-right:1px solid #777;padding:0; }
input[type="submit"] { background:#ededed;font-size:11px;font-weight:bold;border:0; height:100%; }
input[type="submit"]:hover { cursor:pointer; opacity:0.8; }
</style>
</head>
  
<h2>Goals Admin</h2>
<table>
<tr>
<th></th>
<?php foreach($months as $month) { echo '<th>' . $month . '</th>'; } ?>
</tr>

<?php

$x=0;
$result= $dev->query("Select TARGET_NAME from Targets order by TARGET_NAME");
while($row= $result->fetch_assoc()) {

$x++;

$target= $row['TARGET_NAME'];

?>

<form method="post" action="goals-update.php" target="hiddenFrame">
<tr>

<?php

  if($x % 2==0 ) { echo '<td style="padding:0 4px;background: #deff5b;"><b>'; }
  else { echo '<td style="padding:0 4px;"><b>'; }

  echo $target . '</b></td>';

$result2= $dev->query("Select * from Targets where TARGET_NAME='$target'");
$row2= $result2->fetch_assoc();

foreach($months as $month) {
  
	echo '<td>';
	
	if($x % 2==0 ) { echo '<input style="background: #deff5b;" type="text" name="'.$month.'" value="'.$row2[$month].'"></td>'; }
  else { echo '<input type="text" name="'.$month.'" value="'.$row2[$month].'" onChange="this.form.submit()"></td>'; }
}

echo '<input type="hidden" name="target" value="'.$target.'">';

?>
<input style="display:none;" type="submit" value="">
</tr>
</form>

<?php } ?>
</table>
<div style="margin:20px 0;padding:100px 0 0 0;width:950px;text-align:right;"><a href="source/goals-write.php">Refresh Charts</a></div>

<iframe style="display:none;" src="" name="hiddenFrame" id="hiddenFrame"></iframe>



