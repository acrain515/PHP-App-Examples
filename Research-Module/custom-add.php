<style>
body { font-family:Arial;font-size:11px; }
th { font-size:12px; }
td { font-size:11px;border:1px solid #ccc;padding:2px; }
input[type="submit"] { height:26px;margin:10px 0;padding:4px 6px;background:#14aaff;color:#fff;font-size:12px;font-weight:bold;border:1px solid #ccc; }
input[type="submit"]:hover { background:#0097ea;cursor:pointer; }
h3 { font-size:20px; }
</style>

<body>

<h3>Add New</h3>
	  <form method="post" action="custom2.php">
	    Source: &nbsp;
	    <select name="source">
		  <option value=""></option>
			<option value="Project_Tasks">Ready Tasks</option>
			<option value="Project_Orders">Forecast Orders</option>
			<option value="Simple">Metro Tracking</option>
			<option value="Longhaul">Longhaul Tracking</option>
		  <option value="Population">Network Population</option>
		  <option value="Mileage">Customer T1s Mileage</option>
		  <option value="Decision_Model">Decision Model</option>
			<option value="Dbb">Dbb</option>
		</select>&nbsp;&nbsp;
		Query Name:<input type="text" name="queryName">
		<input type="hidden" name="new" value="new">
		<input type="submit" value="NEXT"></br></br>
	  </form>