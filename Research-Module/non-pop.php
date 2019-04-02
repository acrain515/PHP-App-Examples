<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>

<?php 
if(!isset($_COOKIE['oatmeal'])) { echo '<meta http-equiv="REFRESH" content="0;url=../login.php">'; } 
require_once('../connection.php'); 
?>
  <link rel="icon" href="../images/favicon.ico">
  <link rel="shortcut icon" href="../images/favicon.ico">

  <title>Manual Add - UTOPIA</title>
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
    #searchForm { width:500px;margin:20px auto; }
    #searchForm form { border:1px solid #444;padding:20px;}
    #searchForm table { border-collapse:collapse; }
    #searchForm td { padding:15px 5px;text-align:center;width:120px; }
    #searchForm td.label { text-align:center;font-size:20px;font-weight:bold;width:160px; }
    #searchForm td.searchField { width:320px; }
    #searchForm input[type="text"] { background:#efefef;text-align:center;padding:2px;border:1px solid #aaa;border-radius:2px;height:28px;font-size:20px;width:300px; }
    #searchForm input:focus { border: 1px solid #cc0099;background: #fff;outline: none; }
    #searchForm input[type="radio"] { height:20px; }
    #searchForm input[type="submit"] { height:26px;margin:10px;padding:4px 6px;background:#14aaff;color:#fff;font-size:12px;font-weight:bold;border:1px solid #ccc; }
    #searchForm input[type="submit"]:hover { background:#0097ea;cursor:pointer; }
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

  <h1>Manual Add</h1>

  <!-- ORDER SEARCH FORM-->
  <div id="searchForm">
    <form method="post" action="non-pop-add.php">
      <table style="width:400px;">
        <tr><td class="label">Circuit ID </br><span style="font-size:10px;">w/ slashes if internal</span></td>
        <td class="searchField"><input style="width:260px;" type="text" name="circuit"/></td></tr>
		</tr>
	  </table></br></br>
	  <div style="float:left;">
		
		<b>Rate Code:</b> </br>
		<table style="border:1px solid #ccc;">
		  <td style="width:80px;">DS1</br><input type="radio" name="rateCode" value="DS1"></td>
      <td style="width:80px;">DS3 ></br><input type="radio" name="rateCode" value="DS3"></td>
		</table>
		
		</br>
		
		<b>Type:</b></br>
	  <table style="border:1px solid #ccc;">
		<tr>
		  <td style="width:80px;">LEC</br><input type="radio" name="type" value="lec"></td>
      <td style="width:80px;">INTERNAL</br><input type="radio" name="type" value="internal"></td>
		</tr> 
	  </table>
		
		</div>
		
	  <div style="float:right;width:200px;">
		
		<b>If DS1, for:</b></br>
		<table style="border:1px solid #ccc;">
		  <td style="width:80px;">Mileage</br><input type="radio" name="ds1For" value="mileage"></td>
      <td style="width:80px;">Clear DS3</br><input type="radio" name="ds1For" value="ds3"></td>
		</table>
		</br>
		
		<b>Project:</b></br>
	  <select name="project">
		<option value=""></option>
	  <?php
	    $result= $mysqli->query("Select SUBPROJECT from Projects group by SUBPROJECT");
		while($row= $result->fetch_assoc()) {
		  echo '<option value="'.$row['SUBPROJECT'].'">'.$row['SUBPROJECT'].'</option>';
		}
	  ?>
	  </select>
		
		</div>
		
	  <div style="clear:both;"></div> </br>
		
	  </br>
		
	    <b>Source:</b></br>
      <table style="border:1px solid #ccc;">
        <tr>
          <td style="width:80px;">PAE M6</br><input type="radio" name="source" value="pae"></td>
          <td style="width:80px;">NVX M5</br><input type="radio" name="source" value="nvx"></td>
          <td style="width:80px;">TSG</br><input type="radio" name="source" value="tsg"></td>
          <td style="width:80px;">WIN</br><input type="radio" name="source" value="win"></td>
		  <td style="width:80px;">CAT</br><input type="radio" name="source" value="cat"></td>
		  <td style="width:80px;">DM</br><input type="radio" name="source" value="dm"></td>
        </tr>
        </table>
      <div style="width:100px;margin:0 auto;"><input type="submit" value="ADD"/></div>
    </form>
  </div>

</div>
</div>
</body>