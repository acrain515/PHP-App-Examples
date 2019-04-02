<style>
body { font-family:Arial;font-size:11px; }
th { font-size:12px; }
td { font-size:11px;border:1px solid #ccc;padding:2px; }
input[type="submit"] { height:26px;margin:10px 0;padding:4px 6px;background:#14aaff;color:#fff;font-size:12px;font-weight:bold;border:1px solid #ccc; }
input[type="submit"]:hover { background:#0097ea;cursor:pointer; }
h3 { font-size: 20px; }
</style>


<script>
  setTimeout(function(){
	  parent.location.reload();
	}, 3000);
</script>

<body>
<?php

if(!isset($_COOKIE['oatmeal'])) { echo '<meta http-equiv="REFRESH" content="0;url=../login.php">'; }
  
  require_once('../connection.php');
  
  $raisin= $_COOKIE['oatmeal'];

  $result= $mysqli->query("Select * from Users where RAISIN='$raisin'");
  $row= $result->fetch_assoc(); 
  $name= $row['NAME'];
  $nameNoSpace= str_replace(" ","",$name);
	
	
	
	$existingQuery= $_POST['existingQuery'];
	$newQuery= $_POST['newQuery'];
	
	$directory="Custom/".$nameNoSpace;
	
	$existingFile= $directory.'/'.$existingQuery.'.php';
	$newFile= $directory.'/'.$newQuery.'.php';
	
	copy($existingFile,$newFile);
	
	echo '<h3>Copy Successful.</h3>';
	echo 'Reloading...';
	
	
		


	?>