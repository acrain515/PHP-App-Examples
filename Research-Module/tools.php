<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
  <link rel="icon" href="../images/favicon.ico">
  <link rel="shortcut icon" href="../images/favicon.ico">
	<?php require_once('../cookie.php'); ?>

  <title>Admin Tools - UTOPIA</title>
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

<!-- PAGE STYLE-->
  <style>
    body { font-family:Arial; }
    h2 { font-size:28px; }
    #searchForm { margin:80px auto; }
		#searchForm table { margin: 0 auto;padding:10px; }
		#searchForm td { font-size:18px;white-space:nowrap; }
		input[type="radio"] { height:20px; }
    input[type="submit"] { height:26px;margin:10px;padding:4px 6px;background:#14aaff;color:#fff;font-size:12px;font-weight:bold;border:1px solid #ccc; }
    input[type="submit"]:hover { background:#0097ea;cursor:pointer; }
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

  <h1>Admin Tools</h1>
	
<div style="float:left;border:1px dashed #999;padding:10px;width:400px;margin:20px;">
<h3>User Admin</h3>
<?php include('../user-admin.php'); ?>
</div>

	

<div style="float:left;border:1px dashed #999;padding:10px;width:210px;margin:20px;">
<h3>Task Details</h3>
<form method="post" action="http://utopia.dev.windstream.com:8080/task-details.php" target="_blank">
Orders:</br>
<textarea style="width:200px;height:200px;resize:none;" name="data"></textarea>
</br>
<input style="width:100px;" type="submit" value="SEARCH">
</form>
</div>

<div style="clear:both;"></div>
</div>
</body>


