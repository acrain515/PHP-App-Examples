<?php 

//SET VARIABLES FOR OVERALL DOC
  //FIRST PART OF FILE NAME, DATE AND EXTENSION ARE ADDED LATER
  $bookTitle="Miranda-Pending-Ready-PAE";
  $system= "PAE";
  $parent= "('NETPROV','NETPRV1','NETSVG')";

//SET ARRAY FOR COL LETTERS
  $alpha = array('A','B','C','D','E','F','G','H','I','J','K', 'L','M','N','O','P','Q','R','S','T','U','V','W','X ','Y','Z');

  require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';

  $excel = new PHPExcel();
  $excel->getProperties()
    ->setCreator("Adam Crain")
	->setLastModifiedBy("Adam Crain")
	->setTitle("Keith Pending & Ready PAE")
	->setSubject("")
	->setDescription("")
	->setKeywords("")
	->setCategory("");
		
  require_once('../local.php');
  
  $tasks= array();
  
  $result= $local->query("Select * from Tasks_$system where STATUS='Ready' and (PARENT_QUEUE in $parent or QUEUE in $parent) group by TASK");
  while($row= $result->fetch_assoc()) { array_push($tasks,$row['TASK']); }

  $taskCount= count($tasks);
  
  $header1Last= $alpha[$taskCount+1].'1';
  $header2Last= $alpha[$taskCount+1].'2';
  
  //print_r($tasks);
  
  $sheet1= $excel->getActiveSheet();
  
  //NAME SHEET 1
  $sheet1->setTitle('Summary');
  
  $sheet1
  ->setCellValue("B1", "Pending")
  ->setCellValue("C1", "Ready")
  ->setCellValue("B2", "DD");
			
  $i=B;
  foreach($tasks as $task) {
			
    $i++;
    $cell= $i."2";
    $sheet1->setCellValue("$cell", "$task");
  }

//GET ALL THE QUEUES IN THE PARENT QUEUE WITH PENDING DD TASKS OR PENDING/READY OTHER TASKS
  $result2= $local->query("Select * from Tasks_$system where (STATUS='Ready' or (TASK='DD' and STATUS='Pending')) and (PARENT_QUEUE in $parent or QUEUE in $parent) group by QUEUE");
  
  $v=2;
  while($row2= $result2->fetch_assoc()) {
  
    $v++;
    $cell= "A".$v;
    $queue= $row2['QUEUE'];
	
	$sheet1->setCellValue("$cell", "$queue");
	//$sheet1->getStyle("$cell")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

//GET THE COUNT OF THE PENDING DD TASKS IN EACH QUEUE 	
	$result3= $local->query("Select count(*) as theCount from Tasks_$system where TASK='DD' and STATUS='Pending' and QUEUE='$queue'");
    $row3= $result3->fetch_assoc();

    $cellValue= $row3['theCount'];
	$cell= "B".$v;
	  
	$sheet1->setCellValue("$cell","$cellValue");
	
//GET THE COUNTS FOR EACH READY TASK IN EACH QUEUE	
	
	for($x=0;$x<$taskCount;$x++) {
	
	  $task= $tasks[$x];
	
      $result4= $local->query("Select *,count(*) as theCount from Tasks_$system where STATUS='READY' and QUEUE='$queue' and TASK='$task'");
	  while($row4= $result4->fetch_assoc()) {
	  
        $cellValue= $row4['theCount'];
		$colNumber= $x+2;
		$column= $alpha[$colNumber];
		$cell= $column.''.$v;
		
		$sheet1->setCellValue("$cell","$cellValue");
	  }
	}   
  }
  
  $lastRow= $v;
  $lastCol= $alpha[$taskCount+1];
  $lastCell= $lastCol.''.$lastRow;
  $qLast= "A".$lastRow;  
  
  
//STYLE ARRAYS  
  $borderAll= array('borders'=>array('allborders'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN)));
  $borderOutline= array('borders'=>array('outline'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN)));
  $borderRight= array('borders'=>array('right'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN)));
  $borderDashRight =array('borders'=>array('right'=>array('style'=>PHPExcel_Style_Border::BORDER_DASHED)));

//MERGE HEADER 1 CELLS
  $sheet1->mergeCells("C1:$header1Last");
//SET CONTENT COLUMN WIDTHS 
  foreach(range('B','Z') as $columnID) { $sheet1->getColumnDimension($columnID)->setWidth(10); }
//SET ROW LABEL COLUMN WIDTH
  $sheet1->getColumnDimension("A")->setWidth(14);
//CENTER HEADER TEXT
  $sheet1->getStyle("B1:$header2Last")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//CENTER CONTENT TEXT
  $sheet1->getStyle("B3:$lastCell")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//BORDER CONTENT TEXT
  $sheet1->getStyle("B3:$lastCell")->applyFromArray($borderOutline);
//HEADER 1 BACKGROUND
  $sheet1->getStyle("B1:$header1Last")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF000000');
//HEADER 2 BACKGROUND
  $sheet1->getStyle("B2:$header2Last")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F1678');
//BORDER ALL HEADER 2 
  $sheet1->getStyle("B2:$header2Last")->applyFromArray($borderAll);
//BORDER DASH RIGHT COLUMN 2
  $sheet1->getStyle("B1:B$lastRow")->applyFromArray($borderDashRight);
//BOLD HEADERS
  $sheet1->getStyle("B1:$header2Last")->applyFromArray(array("font"=>array("bold"=>true)));
//WHITE TEXT HEADERS
  $sheet1->getStyle("B1:$header2Last")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
//BORDER OUTLINE ROW LABELS
  $sheet1->getStyle("A3:$qLast")->applyFromArray($borderOutline);
//BOLD ROW LABELS
  $sheet1->getStyle("A3:$qLast")->applyFromArray(array("font"=>array("bold"=>true)));
//GRAY FILL ROW LABELS
  $sheet1->getStyle("A3:$qLast")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFDCDCDC');


  

//SHEET 2

  $sheet2= $excel->createSheet();
  $sheet2->setTitle("Data");
  
//HEADERS
  //SET FIRST HEADER COL INDIVIDUALLY
  $sheet2->setCellValue("A1", "ORDER_NUMBER");
  
  //SET REST HEADER COL FROM TABLE FIELD NAME RESULTS
  $vCol= "A";
  $result5= $local->query("Show columns from Tasks_$system");
  while($row5= $result5->fetch_assoc()) {
    $vCol++;
	$cell= $vCol."1";
	$cellValue= $row5['Field'];
  
    $sheet2->setCellValue("$cell","$cellValue");
  }
  
  $lastCol= $vCol;
  $lastHeaderCell= $cell;
    

//BOLD HEADERS
  $sheet2->getStyle("A1:$lastHeaderCell")->applyFromArray(array("font"=>array("bold"=>true)));
//SET AUTO WIDTH ON COLUMNS
  foreach(range("A","$lastCol") as $columnID) { $sheet2->getColumnDimension($columnID)->setAutoSize(true); }
//FREEZE TOP ROW
  $sheet2->freezePane("A2");
  
 
//GET CONTENT 
  $x=1;
  $result5= $local->query("Select * from Tasks_$system where (STATUS='Ready' or (TASK='DD' and STATUS='Pending')) and (PARENT_QUEUE in $parent or QUEUE in $parent)");
  while ($row5= $result5->fetch_assoc()) {
    
	$doc= $row5['DOCUMENT_NUMBER'];
  
    $x++;
	$cellA= "A".$x;

    $result6= $local->query("Select ORDER_NUMBER from Service_Requests_$system where DOCUMENT_NUMBER='$doc'");
    $row6= $result6->fetch_assoc();
	
	$sheet2->setCellValue("A$x","$row6[ORDER_NUMBER]");
	
	$c=0;
	foreach($row5 as $cellValue) {
	  $c++;
	  $cell= $alpha[$c].''.$x;
	  $sheet2->setCellValue("$cell","$cellValue");
	}
  }



//FINAL CONFIGURATION

  $excel->setActiveSheetIndex(0);
  
  //TODAYS DATE FOR DOCUMENT TITLE
  $date= date("Ymd");

  // Redirect output to a client’s web browser (Excel2007)
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="'.$bookTitle.'-'.$date.'.xlsx"');
  header('Cache-Control: max-age=0');
  // If you're serving to IE 9, then the following may be needed
  header('Cache-Control: max-age=1');

  // If you're serving to IE over SSL, then the following may be needed
  header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
  header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
  header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
  header ('Pragma: public'); // HTTP/1.0

  $objWriter = PHPExcel_IOFactory::createWriter($excel,'Excel2007');
  $objWriter->save('php://output');
  exit;

?>

