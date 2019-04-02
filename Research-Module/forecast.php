<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
<?php include('../cookie.php'); ?>
<style>
body { font-family:Arial;font-size:12px;padding:0;margin:0;background-image:url('images/grad2.jpg');
background-repeat:no-repeat; }
#header { width:100%;height:40px;margin:0;padding:0;background:#fff;color#777;box-shadow:0 1px 4px rgba(0, 0, 0, 0.5); }
#navbar { width:1000px;margin:0 120px;padding:4px;background:#fff; }
#logo { float:left;width:250px; }
#logo td { border: 0;padding:0;text-align:left; }
#menu { float:right;width:500px;  }
#menu td { padding: 6px 16px; }
#menu a { color: #222; text-decoration: none;font-size: 16px; }
#menu a:hover { color: #ff0073; }
#navbar table { border-collapse:collapse; }
#container { margin:40px auto;background:#fff;padding:20px; min-height:670px; }
#content { background:#fff; }
#content table { border-collapse: collapse;margin:20px auto; }
#content th { border:1px solid #333;padding:2px 0 0 0;background: linear-gradient(to bottom, rgba(168,255,5,1) 0%, rgba(242,255,61,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a8ff05', endColorstr='#f2ff3d', GradientType=0 ); 
		text-align:center; }
#content td { border:1px solid #aaa;padding:0;;height:20px; }

input { width:97%; }
a { text-decoration:none; color: #333; }
a:hover { color: #dc036d; }
select { font-family: Arial Narrow; font-size:11px;width:100%;margin:0; }
input[type="submit"] { width:80px;height:22px;margin:0;padding:2px 6px;border:0; background:#14aaff;color:#fff;font-size:12px;font-weight:bold;border-radius:2px; }
input[type="submit"]:hover { background:#0097ea;cursor:pointer; }
td.submit { border:5px solid #fff;text-align:center;width:100px;height:26px;margin:10px; background:#14aaff;color:#fff;font-size:12px;font-weight:bold; }
td.submit a { font-family:Arial;color: #fff;text-decoration:none; }
td.submit:hover { background:#0097ea;cursor:pointer; }
input.expand { width:20px;height:15;padding:0;background:none;color:#222;font-size:14px;font-weight:bold; }
input.expand:hover { background: none; }
thead input[type="checkbox"] { width: 13px;height:13px;padding:0;margin:0;vertical-align:bottom;
position:relative;top:-1px;overflow:hidden;display:none; }
label { display: block; padding-left: 15px; text-indent: -15px; }
thead input[type="checkbox"] + label span { display: inline-block;width:10px; height:10px; background-image: url('images/sort.png'); background-size:10px 10px;cursor:pointer; }
tbody input[type="checkbox"] { width: 13px;height:13px; }

</style>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $('#selectAll').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });
   
});
</script>
</head>

<body>
 <div id="header">
    <div id="navbar">
      <div id="logo">
        <table>
          <tr><td><a href="../index.php"><img src="../images/ulogo.png" height="28" border="0"></a></td></tr>
        </table>
      </div>
    </div>
  </div>
<div id="container">
<div id="content">
<?php

  require_once('../connection.php');
	require_once('../functions.php');
	
	//LIMIT RESULTS
	if(isset($_POST['limit'])) { $limit= $_POST['limit']; }
	else { $limit= "10"; }
	
	//if(isset($_POST['search'])) { $search= $_POST['search']; }
	$search="";

  if(isset($_POST['var'])) {
    $vars= $_POST['var'];
  
    //print_r($vars);
  
    foreach ($vars as $key=>$value) {
  
      if($value!='') {
			
			  if(($key=='INTERNAL_CKT_CLN')||($key=='VENDOR_CKT_CLN')||($key=='INTERNAL_ORDER')) { 
				
				  $search.= "and " . $key . " like '%" . $value . "%'";
				}
				
				else {
  
		      $search .= "and " . $key . " = '" . $value . "'";
				}
		
		  ${'var'.$key}= $value;
	    }
    }
  }
	
	//echo 'Search: ' . $search . '</br>';
	
	
	//SORT INPUTS
	$sort="";

  if(isset($_POST['sort'])) {
    $sorts= $_POST['sort'];
  
    foreach ($sorts as $key=>$value) {
  
      if($value!='') {
  
		    $sort= " order by " . $key;
				
				$sortField= trim(str_replace("order by","",$sort));
		
		    ${'sort'.$key}= $value;
	    }
    }
	}
		
	//echo 'Sort: ' . $sort . '</br>';
		
	//IF NO SORT VALUES POSTED, CHECK IF ONE WAS UNSET FOR REVERSE SORT
	if($sort=='') {
		
		//echo 'Sort is Blank';
		  if(isset($_POST['sortField'])) {
			
			  $sortField= $_POST['sortField'];
			  $sort= " order by " .$sortField. " desc";
				$sortField="";
			}
			
			else { $sortField= ""; }
		}	

	
	
	//echo 'SortField: ' . $sortField . '</br>';
	
?>

<form method="post" action="forecast.php">
Show: <select style="width:60px;" name="limit" onchange="this.form.submit()">
  <option value="10" <?php if($limit==10) { echo ' selected="true"'; } ?>>10</option>
	<option value="25" <?php if($limit==25) { echo ' selected="true"'; } ?>>25</option>
	<option value="50" <?php if($limit==50) { echo ' selected="true"'; } ?>>50</option>
	<option value="100" <?php if($limit==100) { echo ' selected="true"'; } ?>>100</option>
	<option value="200" <?php if($limit==200) { echo ' selected="true"'; } ?>>200</option>
</select></br></br>


  <table>
	<thead>
  <tr>
	<th style="border:0;background:#fff;"></th>
	<th>
	<input type="checkbox" id="VENDOR_CKT_CLN" name="sort[VENDOR_CKT_CLN]" onchange="this.form.submit()" 
	<?php if($sortField=='VENDOR_CKT_CLN') { echo ' checked'; } ?>>
	<label for="VENDOR_CKT_CLN">&nbsp; LEC Circuit<span></span></label>
	  <input type="text" name="var[VENDOR_CKT_CLN]" 
		value="<?php if($VENDOR_CKT_CLN!='on') { echo $varVENDOR_CKT_CLN; } ?>" onChange="this.form.submit()">
	</th>

	<th>
	<input type="checkbox" id="INTERNAL_CKT_CLN" name="sort[INTERNAL_CKT_CLN]" onchange="this.form.submit()" 
	<?php if($sortField=='INTERNAL_CKT_CLN') { echo ' checked'; } ?>>
	<label for="INTERNAL_CKT_CLN">&nbsp; Internal Circuit<span></span></label>
	  <input type="text" name="var[INTERNAL_CKT_CLN]" value="<?php echo $varINTERNAL_CKT_CLN; ?>" onChange="this.form.submit()">
	</th>
	
	<th>
	<input type="checkbox" id="SAVINGS" name="sort[SAVINGS]" onchange="this.form.submit()" 
	<?php if($sortField=='SAVINGS') { echo ' checked'; } ?>>
	<label for="SAVINGS">&nbsp; Savings<span></span></label>
	</th>
	
	<th>Rate Code</br>
	  <select style="margin:5px 0 0 0;" name="var[tracking.RATE_CODE]" onchange="this.form.submit()">
			<option value=""></option>
			<option value="DS3" <?php if($varRATE_CODE=='DS3'){ echo ' selected="true"'; } ?>>DS3</option>
			<option value="DS1" <?php if($varRATE_CODE=='DS1'){ echo ' selected="true"'; } ?>>DS1</option>
		</select>
	</th>
	

	
	<!-- SUBPROJECT -->
	<th>
	  <input type="checkbox" id="SUBPROJECT" name="sort[SUBPROJECT]" onchange="this.form.submit()" 
	  <?php if($sortField=='SUBPROJECT') { echo ' checked'; } ?>>
	  <label for="SUBPROJECT">&nbsp;  SubProject<span></span></label>
		<select style="margin:5px 0 0 0;" name="var[SUBPROJECT]" onchange="this.form.submit()">
		<option value=""></option>
		<?php 
		
		  $result9= $mysqli->query("Select SUBPROJECT from Projects order by SUBPROJECT");
	    while($row9= $result9->fetch_assoc()) {
			
			  $projectOption= $row9['SUBPROJECT'];
				echo '<option value="'.$projectOption.'"';
				if($projectOption==$varSUBPROJECT) { echo ' selected="true"'; }
				echo '>'.$projectOption.'</option>';
			}
		?>
		</select>
	</th>
	
  
	<!--STATUS-->
	<th>
	  <input type="checkbox" id="STATUS" name="sort[STATUS]" onchange="this.form.submit()" 
	  <?php if($sortField=='STATUS') { echo ' checked'; } ?>>
	  <label for="STATUS">&nbsp;  Status<span></span></label>
		<select style="margin:5px 0 0 0;" name="var[STATUS]" onchange="this.form.submit()">
		<option value=""></option>
		<option value="<?php echo $varSTATUS; ?>" selected="true"><?php echo $varSTATUS; ?></option>
		<?php  include('../status-options.php'); ?>
		</select>
	</th>
	

	
	
  <!-- INTERNAL ORDER -->
	<th style="width:120px;">
	<input type="checkbox" id="INTERNAL_ORDER" name="sort[INTERNAL_ORDER]" onchange="this.form.submit()" 
	<?php if($sortField=='INTERNAL_ORDER') { echo ' checked'; } ?>>
	<label for="INTERNAL_ORDER">&nbsp; Order<span></span></label>
	<input type="text" name="var[INTERNAL_ORDER]" 
	value="<?php if($INTERNAL_ORDER!='on') { echo $varINTERNAL_ORDER; } ?>" onChange="this.form.submit()">
	</th>
	
	
	<!-- READY TASK  -->
	<th>
	  <input type="checkbox" id="TASK_TYPE" name="sort[TASK_TYPE]" onchange="this.form.submit()" 
	  <?php if($sortField=='TASK_TYPE') { echo ' checked'; } ?>>
	  <label for="TASK_TYPE">&nbsp;  Ready Task<span></span></label>
		<select style="margin:5px 0 0 0;" name="var[TASK_TYPE]" onchange="this.form.submit()">
		<option value=""></option>
		<?php 
		
		  $result9= $mysqli->query("Select TASK_TYPE from Project_Tasks group by TASK_TYPE order by TASK_TYPE");
	    while($row9= $result9->fetch_assoc()) {
			
			  $readyTaskOption= $row9['TASK_TYPE'];
				echo '<option value="'.$readyTaskOption.'"';
				if($readyTaskOption==$varTASK_TYPE) { echo ' selected="true"'; }
				echo '>'.$readyTaskOption.'</option>';
			}
		?>
		</select>
	</th>
	
  <!-- TASK OWNER  -->
	<th>
	  <input type="checkbox" id="TASK_OWNER" name="sort[TASK_OWNER]" onchange="this.form.submit()" 
	  <?php if($sortField=='TASK_OWNER') { echo ' checked'; } ?>>
	  <label for="TASK_OWNER">&nbsp;  Task Owner<span></span></label>
		<select style="margin:5px 0 0 0;" name="var[TASK_OWNER]" onchange="this.form.submit()">
		<option value=""></option>
		<?php 
		
		  $result9= $mysqli->query("Select TASK_OWNER from Project_Tasks group by TASK_OWNER order by TASK_OWNER");
	    while($row9= $result9->fetch_assoc()) {
			
			  $taskOwnerOption= $row9['TASK_OWNER'];
				echo '<option value="'.$taskOwnerOption.'"';
				if($taskOwnerOption==$varTASK_OWNER) { echo ' selected="true"'; }
				echo '>'.$taskOwnerOption.'</option>';
			}
		?>
		</select>
	</th>
	
	<th>
	<input type="checkbox" id="DAYS_READY" name="sort[DAYS_READY]" onchange="this.form.submit()" 
	<?php if($sortField=='DAYS_READY') { echo ' checked'; } ?>>
	<label for="DAYS_READY">&nbsp; Days Ready<span></span></label>
	</th>
	

  

	
  </tr>
	
	<?php if($sortField!='') { echo '<input type="hidden" name="sortField" value="'.$sortField.'">'; } ?>
	<?php if($search!='') { echo '<input type="hidden" name="search" value="'.$search.'">'; } ?>
	</form>
	</thead>

	<tbody>
  <form method="post" action="forecast-update.php">

<?php

  //echo 'Search: ' . $search . '</br>';

  $e=0;
	
	$query= "Select tracking.ID,VENDOR_CKT_CLN, INTERNAL_CKT_CLN, SAVINGS, tracking.RATE_CODE, SUBPROJECT, tracking.STATUS, tracking.INTERNAL_ORDER, TASK_TYPE, TASK_OWNER, DAYS_READY from Simple tracking left join Project_Tasks tasks on tracking.INTERNAL_ORDER=tasks.ORDER_NUMBER where 1 $search $sort limit $limit";
	
	$result= $mysqli->query("$query");
	while($row= $result->fetch_assoc()) {
	
	  $id= $row['ID'];
	  $internalOrder= $row['INTERNAL_ORDER'];
		$orderPage= orderPage($id,$internalOrder);
		$savings= $row['SAVINGS'];
	
	  echo '<tr>';
		echo '<td><input type="checkbox" class="checkbox1" name="check[]" value="'.$id.'"></td>';
		echo '<td style="width:240;min-width:240;max-width:240;text-align:center;">'. $row['VENDOR_CKT_CLN'] .'</td>';
		echo '<td style="width:240;min-width:240;max-width:240;text-align:center;">';
		echo '<a href="'.$orderPage.'" target="_blank">';
		echo $row['INTERNAL_CKT_CLN'];
    echo '</a></td>';
		echo '<td style="width:80px;text-align:center;">$'. number_format($savings,2) .'</td>';
		echo '<td style="width:80px;text-align:center;">'. $row['RATE_CODE'] .'</td>';

		echo '<td style="width:100px;text-align:center;">'. $row['SUBPROJECT'] .'</td>';
		echo '<td style="width:100px;text-align:center;">'. $row['STATUS'] .'</td>';

		echo '<td style="width:100px;text-align:center;">'. $internalOrder .'</td>';
		echo '<td style="width:100px;text-align:center;">'. $row['TASK_TYPE'] .'</td>';
		echo '<td style="width:100px;text-align:center;">'. $row['TASK_OWNER'] .'</td>';
		echo '<td style="width:100px;text-align:center;">'. $row['DAYS_READY'] .'</td>';


		
		echo '</tr>';
	 
	} 
  
	echo '<tr><td style="border:0;"><input type="checkbox" id="selectAll" ></td><td style="border:0;">Select All</td></tr>';
	
  ?>
	
	</tbody>
</table>
<a style="color:#fc0274;" href="../csv.php?q=<?php echo $query; ?>" target="_blank">Export to CSV</a>
</br></br>

<div style="width:200px;padding:10px;border:1px solid #ccc;">
	
<b>Update for Selected</b></br></br>
Status: &nbsp; &nbsp;
<select style="width:160px;" name="status">
<option value=""></option>
<?php include('../status-options.php'); ?>
</select>
</br></br>
<div style="float:right;">
<input type="submit" value="SAVE">
</div>
<div style="clear:both;"></div>
</div>
</form>

	
</div>
</div>




