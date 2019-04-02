<?php 
  require_once('../../../connection.php'); 

echo "<div style=\"display:none;\">Select LEC_CKT,BILL_SYS,BILL_ACCT,CUSTOMER_NAME,ADDRESS,INTERNAL_CKT,INV_SYS,INV_ACCT,PSR,PSR_COMPLETE_DATE,PSR_USER,RESEARCHER,RESEARCH_DATE,RESEARCH_STATUS,PROCESS_FAILURE,DISC_STATUS from     Dbb where RESEARCH_DATE > '2015-01-01' and RESEARCH_STATUS = 'Disconnect' and PROCESS_FAILURE like '%No Disco Sent%' endQuery</div>";

echo '<table>'; 
echo '<tr>'; 
echo '<th>LEC_CKT</th>';echo '<th>BILL_SYS</th>';echo '<th>BILL_ACCT</th>';echo '<th>CUSTOMER_NAME</th>';echo '<th>ADDRESS</th>';echo '<th>INTERNAL_CKT</th>';echo '<th>INV_SYS</th>';echo '<th>INV_ACCT</th>';echo '<th>PSR</th>';echo '<th>PSR_COMPLETE_DATE</th>';echo '<th>PSR_USER</th>';echo '<th>RESEARCHER</th>';echo '<th>RESEARCH_DATE</th>';echo '<th>RESEARCH_STATUS</th>';echo '<th>PROCESS_FAILURE</th>';echo '<th>DISC_STATUS</th>';echo '</tr>'; 

  $resultNew= $mysqli->query("Select LEC_CKT,BILL_SYS,BILL_ACCT,CUSTOMER_NAME,ADDRESS,INTERNAL_CKT,INV_SYS,INV_ACCT,PSR,PSR_COMPLETE_DATE,PSR_USER,RESEARCHER,RESEARCH_DATE,RESEARCH_STATUS,PROCESS_FAILURE,DISC_STATUS from     Dbb where RESEARCH_DATE > '2015-01-01' and RESEARCH_STATUS = 'Disconnect' and PROCESS_FAILURE like '%No Disco Sent%'");
  while( $row= $resultNew->fetch_assoc()) { 

    echo '<tr>';
    foreach($row as $item) {
      echo '<td>' . $item . '</td>';
    }
    echo '</tr>';
  } 

echo '</table>'; 
?>