<?php
 
$table = 'Decision_Model';

$primaryKey = 'CLLI';
 
$columns = array(
  array( 'db' => 'CLLI', 'dt' => 0, 'formatter' => function($d,$row) { return '<a href="mileage-clli-loading.php?clli='.$d.'" target="blank" title="show circuits"><img src="../images/detail.jpg" height="21" border="0" ></a>'; } ),
  array( 'db' => 'CLLI', 'dt' => 1, 'formatter' => function($d,$row) { return '<a href="clli-detail.php?clli='.$d.'" target="blank">'.$d.'</a>'; } ),
  array( 'db' => 'COLO', 'dt' => 2, 'formatter' => function($d,$row) { if($d==2) { return 'ON-NET'; } else if($d==1) { return 'COLO'; }; } ),
  array( 'db' => 'LATA', 'dt' => 3 ),
  array( 'db' => 'OWNER',  'dt' => 4 ),
  array('db' => 'VENDOR', 'dt'=> 5),
  array('db' => 'MILEAGE_PAE', 'dt'=> 6),
  array('db' => 'MILEAGE_NVX', 'dt'=> 7),
  array('db' => 'AVAILABLE_PAE', 'dt'=> 8),
  array( 'db' => 'AVAILABLE_NVX', 'dt' => 9 ),
  array( 'db' => 'DS3_NEED', 'dt' => 10 ),
	array( 'db' => 'TRACKED', 'dt' => 11, 'formatter' => function($d,$row) { return '$' . number_format($d); } ),
	array( 'db' => 'GROOM', 'dt' => 12, 'formatter' => function($d,$row) { return '$' . number_format($d); } ),
  array( 'db' => 'NOT_TRACKED', 'dt' => 13, 'formatter' => function($d,$row) { return '$' . number_format($d); } )
);
 
require_once('../config/details.php');
 
require('ssp.class.php');
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);

?>