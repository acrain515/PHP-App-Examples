<?php 
  require_once('../../../connection.php'); 

echo "<div style=\"display:none;\">Select LEC_CKT,DATE_ADDED from     Dbb where LEC_CKT = '82KQGN702459SW' endQuery</div>";

echo '<table>'; 
echo '<tr>'; 
echo '<th>LEC_CKT</th>';echo '<th>DATE_ADDED</th>';echo '</tr>'; 

  $resultNew= $mysqli->query("Select LEC_CKT,DATE_ADDED from     Dbb where LEC_CKT = '82KQGN702459SW'");
  while( $row= $resultNew->fetch_assoc()) { 

    echo '<tr>';
    foreach($row as $item) {
      echo '<td>' . $item . '</td>';
    }
    echo '</tr>';
  } 

echo '</table>'; 
?>