<?php
 
$table = 'Dbb';
$primaryKey = 'LEC_CKT';
 
$columns = array(
  array( 'db' => 'CB_KEY', 'dt' => 0, 'formatter' => function($d,$row) { return '<input class="checkbox1" type="checkbox" name="cbKey[]" value="'.$d.'">'; } ),
  array( 'db' => 'LEC_CKT',  'dt' => 1 ),
  array( 'db' => 'BAN', 'dt' => 2 ),
	array( 'db' => 'VENDOR', 'dt' => 3 ),
  array( 'db' => 'MRC', 'dt' => 4 , 'formatter' => function($d,$row) { return '$' . number_format($d); }),
  array('db' => 'PROJECT', 'dt'=> 5 ),
  array( 'db' => 'RESEARCHER', 'dt' => 6 ),
);
 
require_once('../config/details.php');
 
require( 'ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);
?>