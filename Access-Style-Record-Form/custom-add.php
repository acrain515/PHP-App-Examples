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
		Query Name:<input type="text" name="queryName">
		<input type="hidden" name="source" value="Dbb">
		<input type="hidden" name="new" value="new">
		<input type="submit" value="NEXT"></br></br>
	  </form>