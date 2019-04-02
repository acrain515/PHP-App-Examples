<?php
 
  $table = 'Mileage';
  $primaryKey = 'CB_KEY';
 
  $columns = array(
    array( 'dt' => 0, 'db' => 'CB_KEY', 
			'formatter' => function($d,$row) { return '<input class="checkbox1" type="checkbox" name="cbKey[]" value="'.$d.'">'; } 
		),
		array( 'dt' => 1, 'db' => 'CB_KEY', 
			'formatter' => function($d,$row) { 
			  return '<a href="mileage-edit.php?cbKey='.$d.'" target="blank"><img src="../images/gear.png" height="21"</a>'; 
			} 
		),
    array( 'dt' => 2, 'db' => 'LEC_CKT' ),
    array( 'dt' => 3, 'db' => 'INTERNAL_CKT' ),
	  array( 'dt' => 4, 'db' => 'LEGACY_ID'  ),
    array( 'dt' => 5, 'db' => 'SYS' ),
    array( 'dt' => 6, 'db' => 'QTY' ),
    array( 'dt' => 7, 'db' => 'CHARGE',
		  'formatter' => function($d,$row) { return '$' . number_format($d); }
		),
    array( 'dt' => 8, 'db' => 'VENDOR' ),
    array( 'dt' => 9, 'db' => 'CLLI' ),
	  array( 'dt' => 10, 'db' => 'INV_ALOC' ),
		array( 'dt' => 11, 'db' => 'CUSTOMER_NAME' ),
		array( 'dt' => 12, 'db' => 'CUSTOMER_ACCT' ),
		array( 'dt' => 13, 'db' => 'SEGMENT' ),
    array( 'dt' => 14, 'db' => 'SORU' ), 
    array( 'dt' => 15,'db' => 'OPTIMAL', 
		  'formatter' => function($d,$row) { 
		    if($d=='y') { return '<img src="../images/flag-green.png" border="0" height="21">'; } 
			  else { return '<img src="../images/flag-off.png" border="0" height="21">'; }
			} 
		),	
		array( 'dt' => 16, 'db' => 'DBB_OPP', 
			'formatter' => function($d,$row) { 
			  if($d=='y') { return '<img src="../images/flag-red.png" border="0" height="21">'; } 
				else { return '<img src="../images/flag-off.png" border="0" height="21">'; }
			} 
		),
    array( 'dt' => 17, 'db' => 'ON_FORECAST', 
			'formatter' => function($d,$row) { 
			  if($d=='y') { return '<img src="../images/flag-blue.png" border="0" height="21">'; } 
				else { return '<img src="../images/flag-off.png" border="0" height="21">'; }
			} 
		),
		//array( 'dt' => 17, 'db' => 'DBB_OPP ', 
			//'formatter' => function($d,$row) { 
			  //if($d=='y') { return '<img src="../images/flag-red.png" border="0" height="21">'; } 
				//else { return '<img src="../images/flag-off.png" border="0" height="21">'; }
			//} 
		//)
  );
 
  require_once('../config/details.php');
 
  require( 'ssp.class.php' );
 
  echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
  );
	
?>

