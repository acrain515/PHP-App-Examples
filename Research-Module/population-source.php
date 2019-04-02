<?php
 
$table = 'Population';
 
$primaryKey = 'CB_KEY';
 
$columns = array(
    array( 'db' => 'CB_KEY', 'dt' => 0, 'formatter' => function($d,$row) { return '<a href="population-detail.php?cbKey='.$d.'" target="blank"><img src="../images/detail.jpg" height="20" border="0" alt="detail"></a>'; } ),
    array( 'db' => 'CB_KEY', 'dt' => 1, 'formatter' => function($d,$row) { return '<input class="checkbox1" type="checkbox" name="cbKey[]" value="'.$d.'">'; } ),
    array( 'db' => 'LEC_CKT',  'dt' => 2),
    array( 'db' => 'MRC', 'dt' => 3, 'formatter' => function($d,$row) { return '$' . number_format($d); } ),
    array( 'db' => 'VENDOR_GRP',  'dt' => 4 ),
    array('db' => 'EXCHANGE_CARRIER_CIRCUIT_ID', 'dt'=> 5),
	array('db' => 'UNASSIGNED', 'dt'=> 6, 'formatter' => function($d,$row) { if($d==0) { return ''; } else { return $d; }} ),
    array( 'db' => 'ASAP_INSTANCE', 'dt' => 7),
    array( 'db' => 'RATE_CODE', 'dt' => 8 ),
    array( 'db' => 'LATA', 'dt' => 9 ),
    array( 'db' => 'REVEX_GRP', 'dt' => 10 ), 	
    array( 'db' => 'OPTIMAL', 'dt' => 11, 'formatter' => function($d,$row) { if($d=='y') { return '<img src="../images/flag-blue.png" border="0" height="21">'; } else { return '<img src="../images/flag-off.png" border="0" height="21">'; }} ),
    array( 'db' => 'ON_FORECAST', 'dt' => 12, 'formatter' => function($d,$row) { if($d=='y') { return '<img src="../images/flag-blue.png" border="0" height="21">'; } else { return '<img src="../images/flag-off.png" border="0" height="21">'; }} ),  	  	
);

require_once('../config/details.php');

require('ssp.class.php');
 
echo json_encode(
    SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns)
);
?>