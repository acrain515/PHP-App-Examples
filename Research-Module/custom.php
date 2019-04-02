<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>

  <link rel="icon" href="../images/favicon.ico">
  <link rel="shortcut icon" href="../images/favicon.ico">
  <title>Custom Query - UTOPIA</title>

<?php require_once('../cookie.php'); ?>
 
 <script>
 $(function() {
    $('.confirm').click(function() {
        return window.confirm("Are you sure?");
    });
});
</script>


<!--HEADER STYLE-->
<style>
body { margin:0;padding:0;background-image:url('../images/grad2.jpg');background-repeat:no-repeat;font-family:Arial;color:#222; }
a { text-decoration: none;color: #333; }
#header { width:100%;height:40px;margin:0;padding:0;background:#fff;color#777;box-shadow:0 1px 4px rgba(0, 0, 0, 0.5); }
#navbar { width:980px;margin:0 auto;padding:5px;background:#fff; }
#logo { float:left; }
#logo td { border: 0;padding:0;text-align:left;width:100px; }
#menu { float:right; }
#menu td { padding: 6px 16px; }
#menu a { color: #222; text-decoration: none;font-size: 16px; }
#menu a:hover { color: #ff0073; }
#navbar table { border-collapse:collapse; }
#main { width:1000px;background:#fff;margin:40px auto;padding:20px 20px 40px 20px;
box-shadow:0 1px 4px rgba(0, 0, 0, 0.5), 0 0 40px rgba(0, 0, 0, 0.1) inset;
min-height:600px; }
</style>


<style>
h2 { font-size: 28px; }
#research2 { width: 1000px; margin:0 auto; }
#research2 a { text-decoration:none;color:#222; }
#research2 a:hover { color:#ff0073; }
#research2 th { text-align:center;font-size:11px; }
#research2 td { text-align:center;font-size:11px;padding:4px 10px; }
#research2 input[type="submit"] { height:26px;margin:10px 0;padding:4px 6px;background:#14aaff;color:#fff;font-size:12px;font-weight:bold;border:1px solid #ccc; }
#research2 input[type="submit"]:hover { background:#0097ea;cursor:pointer; }
</style>

</head>

<body>
  <div id="header">
    <div id="navbar">
      <div id="logo">
        <table>
          <tr><td><a href="../index.php"><img src="../images/ulogo.png" height="28" border="0"></a></td></tr>
        </table>
      </div>
     <?php include('nav.php'); ?>
    </div>
  </div>

<div id="main">
  <div id="research2">
  <h2>Custom Query</h2>
	<div style="float:left;width:280px;">
	  <h3>Saved</h3>
	  <table>
	  <tr><th>Run</th><th>Edit</th><th>Copy</th><th>Delete</th></tr>
	
      <?php
	  
	    $fileDir = '../research/custom/'.$nameNoSpace.'/';
		
		$files= glob($fileDir . "*.php");
		
		foreach ($files as $file) {
		
		  $pathSplit= explode("/",$file);
		  $lastPart= str_replace(".php","",$pathSplit[4]);
		  
          echo '<tr>';
		  echo '<td style="font-size:13px;text-align:left;"><a href="'.$file.'" target="blank">'.$lastPart.'</a></td>';
			echo '<td><a href="custom-edit.php?file='.$lastPart.'" target="custom2">';
			echo '<img style="height:18px;" src="../images/gear.png" border="0"></a></td>';
			echo '<td><a href="custom-copy.php?file='.$lastPart.'" target="custom2">';
			echo '<img style="height:18px;" src="../images/copy.png" border="0"></a></td>';
		  echo '<td style="padding:4px;text-align:center;"><a href="custom-delete.php?n='.$nameNoSpace.'&f='.$lastPart.'" 
		  onclick="if (confirm(\'Are you sure?\')) { return true; } else { return false; }"><img style="height:14px;border:0;" src="../images/delete-icon.png"></a></td>';
		  
		  echo '</tr>';
		}
		
	  ?>
	  </table>
	</div>
	<div style="float:right;width:700px;">
	  
	  <iframe src="custom-add.php" name="custom2" frameborder="1px solid #333" width="600" height="460"></iframe>
	  </br></br>
	</div>
	<div style="clear:both;"></div>
  </div>
</body>
