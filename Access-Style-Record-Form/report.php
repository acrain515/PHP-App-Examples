<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
<?php include('../cookie.php'); ?>
<style>
body { font-family:Arial;font-size:12px;padding:0;margin:0;background-image:url('images/grad2.jpg');
background-repeat:no-repeat;width:2600px; }
#header { width:100%;height:40px;margin:0;padding:0;background:#fff;color#777;box-shadow:0 1px 4px rgba(0, 0, 0, 0.5); }
#navbar { width:1000px;margin:0 120px;padding:4px;background:#fff; }
#logo { float:left;width:250px; }
#logo td { border: 0;padding:0;text-align:left; }
#menu { float:right;width:500px;  }
#menu td { padding: 6px 16px; }
#menu a { color: #222; text-decoration: none;font-size: 16px; }
#menu a:hover { color: #ff0073; }
#navbar table { border-collapse:collapse; }

#container { margin:40px;background:#fff;padding:20px; min-height:670px; }
#content { background:#fff; }
#content table { border-collapse: collapse;margin:20px 0; }
#content th { border:1px solid #333;padding:2px 0 0 0;background: linear-gradient(to bottom, rgba(168,255,5,1) 0%, rgba(242,255,61,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a8ff05', endColorstr='#f2ff3d', GradientType=0 ); 
		text-align:center; }
#content td { border:1px solid #aaa;padding:0;;height:20px; }


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
input { width:94%; }

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
			
			  if(($key=='BILL_ACCT')||($key=='VENDOR_CKT_CLN')||($key=='PROJECT')||($key=='SUBPROJECT')) { 
				
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

<form method="post" action="research-simple.php">
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
	<input type="checkbox" id="LEC_CKT_CLN" name="sort[LEC_CKT_CLN]" onchange="this.form.submit()" 
	<?php if($sortField=='LEC_CKT_CLN') { echo ' checked'; } ?>>
	<label for="LEC_CKT_CLN">&nbsp; LEC Circuit<span></span></label>
	  <input type="text" name="var[LEC_CKT_CLN]" 
		value="<?php if($LEC_CKT_CLN!='on') { echo $varLEC_CKT_CLN; } ?>" onChange="this.form.submit()">
	</th>

	<th>
	<input type="checkbox" id="BAN" name="sort[BAN]" onchange="this.form.submit()" 
	<?php if($sortField=='BAN') { echo ' checked'; } ?>>
	<label for="BAN">&nbsp; BAN<span></span></label>
	  <input type="text" name="var[BAN]" value="<?php echo $varBAN; ?>" onChange="this.form.submit()">
	</th>
	
	<th>
	<input type="checkbox" id="MRC" name="sort[MRC]" onchange="this.form.submit()" 
	<?php if($sortField=='MRC') { echo ' checked'; } ?>>
	<label for="MRC">&nbsp; MRC<span></span></label>
	</th>
	
	<th>
	<input type="checkbox" id="BILL_ACCT" name="sort[BILL_ACCT]" onchange="this.form.submit()" 
	<?php if($sortField=='BILL_ACCT') { echo ' checked'; } ?>>
	<label for="BILL_ACCT">&nbsp; SUB ID<span></span></label>
	  <input type="text" name="var[BILL_ACCT]" value="<?php echo $varBILL_ACCT; ?>" onChange="this.form.submit()">
	</th>
	
	<th>
	<input type="checkbox" id="INTERNAL_CKT" name="sort[INTERNAL_CKT]" onchange="this.form.submit()" 
	<?php if($sortField=='INTERNAL_CKT') { echo ' checked'; } ?>>
	<label for="INTERNAL_CKT">&nbsp; Internal Circuit<span></span></label>
	  <input type="text" name="var[INTERNAL_CKT]" value="<?php echo $varINTERNAL_CKT; ?>" onChange="this.form.submit()">
	</th>
	
	
	<th>
	<input type="checkbox" id="PROJECT" name="sort[PROJECT]" onchange="this.form.submit()" 
	<?php if($sortField=='PROJECT') { echo ' checked'; } ?>>
	<label for="PROJECT">&nbsp; Project<span></span></label>
	  <input type="text" name="var[PROJECT]" value="<?php echo $varPROJECT; ?>" onChange="this.form.submit()">
	</th>
	
	<th>
	<input type="checkbox" id="SUBPROJECT" name="sort[SUBPROJECT]" onchange="this.form.submit()" 
	<?php if($sortField=='SUBPROJECT') { echo ' checked'; } ?>>
	<label for="SUBPROJECT">&nbsp; SubProject<span></span></label>
	  <input type="text" name="var[SUBPROJECT]" value="<?php echo $varSUBPROJECT; ?>" onChange="this.form.submit()">
	</th>
	
	
	<th>
	<input type="checkbox" id="RESEARCHER" name="sort[RESEARCHER]" onchange="this.form.submit()" 
	<?php if($sortField=='RESEARCHER') { echo ' checked'; } ?>>
	<label for="RESEARCHER">&nbsp; Researcher<span></span></label>
	  <input type="text" name="var[RESEARCHER]" value="<?php echo $varRESEARCHER; ?>" onChange="this.form.submit()">
	</th>
	
	
	
	
  
	<!--RESEARCH_STATUS-->
	<th>
	  <input type="checkbox" id="RESEARCH_STATUS" name="sort[RESEARCH_STATUS]" onchange="this.form.submit()" 
	  <?php if($sortField=='RESEARCH_STATUS') { echo ' checked'; } ?>>
	  <label for="RESEARCH_STATUS">&nbsp;  Research Status<span></span></label>
		<select style="margin:5px 0 0 0;" name="var[RESEARCH_STATUS]" onchange="this.form.submit()">
		<option value=""></option>
		<option value="<?php echo $varRESEARCH_STATUS; ?>" selected="true"><?php echo $varRESEARCH_STATUS; ?></option>
		<?php  include('status-options.php'); ?>
		</select>
	</th>
	
	<!-- RESEARCH_DATE -->
	<th>Research Date</th>
	
	<!-- SOFT_DISC_DATE -->
	<th>Soft Disc Date</th>
	
		<!--DISC_STATUS-->
	<th>
	  <input type="checkbox" id="DISC_STATUS" name="sort[DISC_STATUS]" onchange="this.form.submit()" 
	  <?php if($sortField=='DISC_STATUS') { echo ' checked'; } ?>>
	  <label for="DISC_STATUS">&nbsp;  Disc Status<span></span></label>
		<select style="margin:5px 0 0 0;" name="var[DISC_STATUS]" onchange="this.form.submit()">
		<option value=""></option>
		<option value="<?php echo $varDISC_STATUS; ?>" selected="true"><?php echo $varDISC_STATUS; ?></option>
		<?php  include('disc-status-options.php'); ?>
		</select>
	</th>
	
	<!-- TO_LEC_DATE -->
	<th>Soft Disc Date</th>
	
	<!-- FOC_DATE -->
	<th>FOC Date</th>
  
  </tr>
	
	<?php if($sortField!='') { echo '<input type="hidden" name="sortField" value="'.$sortField.'">'; } ?>
	<?php if($search!='') { echo '<input type="hidden" name="search" value="'.$search.'">'; } ?>
	</form>
	</thead>

	<tbody>
  <form method="post" action="research-update.php">

<?php

  $e=0;
	
	$query= "Select ID,LEC_CKT_CLN,BAN,MRC,BILL_ACCT,INTERNAL_CKT,PROJECT,SUBPROJECT,RESEARCHER,RESEARCH_STATUS,RESEARCH_DATE,SOFT_DISC_DATE,DISC_STATUS,TO_LEC_DATE,FOC_DATE from Dbb where 1 $search $sort limit $limit";
	
	$result= $mysqli->query("$query");
	while($row= $result->fetch_assoc()) {
	
	  $id= $row['ID'];
	
	  echo '<tr>';
		echo '<td style="width:21px;min-width:21px;max-width:21px;"><input type="checkbox" class="checkbox1" name="check[]" value="'.$id.'"></td>';
		echo '<td style="width:340px;min-width:340px;max-width:340px;text-align:center;">';
		echo '<a href="tracking-simple.php?id='.$id.'" target="_blank">';
		echo $row['LEC_CKT_CLN'];
    echo '</a></td>';
		echo '<td style="width:100px;min-width:100px;max-width:100px;text-align:center;">'. $row['BAN'] .'</td>';
		echo '<td style="width:80px;min-width:80px;max-width:80px;text-align:center;">$'. number_format($mrc,2) .'</td>';
		echo '<td style="width:100px;min-width:100px;max-width:100px;text-align:center;">'. $row['BILL_ACCT'] .'</td>';
		echo '<td style="width:280px;min-width:280px;max-width:280px;text-align:center;">'. $row['INTERNAL_CKT'] .'</td>';
		echo '<td style="width:200px;min-width:200px;max-width:200px;text-align:center;">'. $row['PROJECT'] .'</td>';
		echo '<td style="width:200px;min-width:200px;max-width:200px;text-align:center;">'. $row['SUBPROJECT'] .'</td>';
		echo '<td style="width:100px;min-width:100px;max-width:100px;text-align:center;">'. $row['RESEARCHER'] .'</td>';
		echo '<td style="width:100px;min-width:100px;max-width:100px;text-align:center;">'. $row['RESEARCH_STATUS'] .'</td>';
		echo '<td style="width:100px;text-align:center;">'. $row['RESEARCH_DATE'] .'</td>';
		echo '<td style="width:100px;text-align:center;">'. $row['SOFT_DISC_DATE'] .'</td>';
		echo '<td style="width:100px;text-align:center;">'. $row['DISC_STATUS'] .'</td>';
		echo '<td style="width:100px;text-align:center;">'. $row['TO_LEC_DATE'] .'</td>';
		echo '<td style="width:100px;text-align:center;">'. $row['FOC_DATE'] .'</td>';
	
		echo '</tr>';
	 
	} 
  
	echo '<tr><td style="border:0;"><input type="checkbox" id="selectAll" ></td><td style="border:0;">Select All</td></tr>';
	
  ?>
	
	</tbody>
</table>
<a style="color:#fc0274;" href="../csv.php?q=<?php echo $query; ?>" target="_blank">Export to CSV</a>
</br></br>

<div style="width:300px;padding:10px;border:1px solid #ccc;">
	
<b>Update for Selected</b></br></br>
<table style="border:0;">
	  <tr>
      <td style="font-weight:bold;border:0;">Research Status: &nbsp;</td>
			<td style="border:0;">
        <select style="width:160px;" name="RESEARCH_STATUS">
        <option value=""></option>
        <?php include('status-options.php'); ?>
        </select>
      </td>
		</tr>
	
			<tr>
        <td style="font-weight:bold;border:0;">Researcher:</td>
			  <td style="border:0;"><input type="text" name="RESEARCHER"></td>
		  </tr>
</table>
  <div style="float:right;">
    <input type="submit" value="SAVE">
  </div>
  <div style="clear:both;"></div>
</div>

</form>

	
</div>
</div>




