<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
  <link rel="icon" href="../images/favicon.ico">
  <link rel="shortcut icon" href="../images/favicon.ico">

  <title>UTOPIA</title>

  <script type="text/javascript" src="../js/jquery.js"></script>
  
<?php
  
  date_default_timezone_set('America/New_York');
  
  require_once('../connection.php');

  $raisin= $_COOKIE['oatmeal'];

?>

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
</head>
<body>
  <div id="header">
    <div id="navbar">
      <div id="logo">
        <table>
          <tr><td><a href="../index.php"><img src="../images/ulogo.png" height="28" border="0"></a></td></tr>
        </table>
      </div>
      <div id="menu">
        <table>
          <tr>
		    <td><a href="../search.php">Search</a></td>
            <td><a href="../projects.php">Projects</a></td>
            <td><a href="../research.php">Research</a></td>
          </tr>
        </table>
      </div>
    </div>
  </div>

  <div id="main">
    <div style="text-align:center;margin:100px auto;">
  
<script>
$("#imgId").show(); // Show loading image.
</script>


<script>
$.post( "forecast-write.php?", function( data ) {
     //$("#imgId").hide(); // Hide loading image.
	 
     window.location = "forecast.php"; // Redirect to URL.
});
</script>

<img src="../images/loading.gif" id="imgId" />
    </div>
  </div>
</body>
	

