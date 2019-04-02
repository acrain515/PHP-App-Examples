<!-- METRO NAV ONLY -->
<style>
#menu { float:right;width:340px;  }
#menu td { padding: 6px 16px; }
#menu a { color: #222; text-decoration: none;font-size: 16px; }
#menu a:hover { color: #ff0073; }

#menu-wide { float:right;width:500px;  }
#menu-wide td { padding: 6px 16px; }
#menu-wide a { color: #222; text-decoration: none;font-size: 16px; }
#menu-wide a:hover { color: #ff0073; }
</style>

<?php if($level=='a') { ?>

	<div id="menu-wide">
	  <table>
		  <tr>					
			  <td><a href="../search.php">Search</a></td>
			  <td><a href="../projects.php">Projects</a></td>
				<td><a href="../research.php">Research</a></td>
				<td><a href="../scorecards.php">Scorecard</a></td>
				<td><a href="../longhaul/">Longhaul</a></td>
				<td><a href="../longhaul/">Dbb</a></td>
			</tr>
		</table>
	</div>	
	
<?php }  else if ($level!=='c') {  ?>	

	<div id="menu-wide">
	  <table>
		  <tr>					
			  <td><a href="../search.php">Search</a></td>
			  <td><a href="../projects.php">Projects</a></td>
				<td><a href="../research.php">Research</a></td>
				<td><a href="../scorecards.php">Scorecard</a></td>
			</tr>
		</table>
	</div>	
	
<?php }  else {  ?>

  <div id="menu">
	  <table>
		  <tr>
				<td><a href="../search.php">Search</a></td>
				<td><a href="../projects.php">Projects</a></td>
				<td><a href="../research.php">Research</a></td>
			</tr>
		</table>
	</div>
	
<?php } ?>