<?php 

//SET VARIABLES FOR OVERALL DOC
  //FIRST PART OF FILE NAME, DATE AND EXTENSION ARE ADDED LATER
  $bookTitle="Keith-Aging-Int";

//SET ARRAY FOR COL LETTERS
  $alpha = array('A','B','C','D','E','F','G','H','I','J','K', 'L','M','N','O','P','Q','R','S','T','U','V','W','X ','Y','Z');

  require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';

  $excel = new PHPExcel();
  $excel->getProperties()
    ->setCreator("Adam Crain")
	->setLastModifiedBy("Adam Crain")
	->setTitle("$bookTitle")
	->setSubject("")
	->setDescription("")
	->setKeywords("")
	->setCategory("");
		
  require_once('../local.php');
  
  $system= "PAE";
  $parent= "('SVGSDES')";
  
  $sheet1= $excel->getActiveSheet();
 
//SHEET 1 - AGING PAE
 
  //NAME SHEET 1
  $sheet1->setTitle('Aging PAE');
  
  $queues= array();
  //GET DISTINCT AGING QUEUES
  $result= $local->query("Select * from Tasks_$system where (PARENT_QUEUE in $parent or QUEUE in $parent) and RELEASE_DATE!='' and COMP_DATE='' group by QUEUE");
  while($row= $result->fetch_assoc()) { array_push($queues,$row['QUEUE']); }

  $headerCount= count($queues);
  
  $headerFirst= "B1";
  $headerLast= $alpha[$headerCount].'1';
  
  $contentFirst="B2";

  $x=0;
  foreach($queues as $queue) {
  
    $x++;
	$colNumber= $x;
    $cell= $alpha[$colNumber]."1";
	$cellValue= $queue;
  
    $sheet1->setCellValue("$cell","$cellValue");
  }
  
  $tasks= array();
  //GET DISTINCT AGING TASKS
  $result2= $local->query("Select * from Tasks_$system where (PARENT_QUEUE in $parent or QUEUE in $parent) and RELEASE_DATE!='' and COMP_DATE='' group by TASK");
  while($row2= $result2->fetch_assoc()) { array_push($tasks,$row2['TASK']); }

  $labelCount= count($tasks);
  
  $labelFirst= "A2";
  $labelLast= "A".($labelCount+1);

  $y=1;
  foreach($tasks as $task) {
  
    $y++;
	$rowNumber= $y;
    $cell= "A".$rowNumber;
	$cellValue= $task;
  
    $sheet1->setCellValue("$cell","$cellValue");
	
    $x=0;
	//FOREACH QUEUE
	foreach($queues as $queue) {
	
	  $x++;
	  $colNumber= $x;
	
	  $agings= array();

      $result3= $local->query("Select * from Tasks_$system where QUEUE='$queue' and TASK='$task' and RELEASE_DATE!='' and COMP_DATE=''");
      while ($row3= $result3->fetch_assoc()) {
	    
        $relStr= strtotime($row3['RELEASE_DATE']);
		$now= strtotime("now");
	    $aging= ($now-$relStr)/86400;
         
        array_push($agings,$aging);
      } 

      $agingCount= count($agings);
      $sum= array_sum($agings);
	  
	  $cell= $alpha[$colNumber].''.$rowNumber;

      if($agingCount>0) {
        $cellValue= round($sum/$agingCount,1);
        $sheet1->setCellValue("$cell","$cellValue");
	  }
	  else { $sheet1->setCellValue("$cell","-"); }
	}
  }
  
  $contentLast= $alpha[$colNumber] . '' . $rowNumber;
  
  //STYLE ARRAYS  
  $borderAll= array('borders'=>array('allborders'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN)));
  $borderOutline= array('borders'=>array('outline'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN)));
  $borderRight= array('borders'=>array('right'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN)));
  $borderDashRight =array('borders'=>array('right'=>array('style'=>PHPExcel_Style_Border::BORDER_DASHED)));
  
//SET CONTENT COLUMN WIDTHS 
  foreach(range('B','Z') as $columnID) { $sheet1->getColumnDimension($columnID)->setWidth(10); }
//SET ROW LABEL COLUMN WIDTH
  $sheet1->getColumnDimension("A")->setWidth(14);
//CENTER HEADER TEXT
  $sheet1->getStyle("$headerFirst:$headerLast")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//CENTER CONTENT TEXT
  $sheet1->getStyle("$contentFirst:$contentLast")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
//HEADER BACKGROUND
  $sheet1->getStyle("$headerFirst:$headerLast")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F1678');
//HEADER BORDER
  $sheet1->getStyle("$headerFirst:$headerLast")->applyFromArray($borderAll);
//HEADER BOLD FONT
  $sheet1->getStyle("$headerFirst:$headerLast")->applyFromArray(array("font"=>array("bold"=>true)));
//HEADER WHITE TEXT
  $sheet1->getStyle("$headerFirst:$headerLast")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
//BORDER OUTLINE ROW LABELS
  $sheet1->getStyle("$labelFirst:$labelLast")->applyFromArray($borderOutline);
//BOLD ROW LABELS
  $sheet1->getStyle("$labelFirst:$labelLast")->applyFromArray(array("font"=>array("bold"=>true)));
//GRAY FILL ROW LABELS
  $sheet1->getStyle("$labelFirst:$labelLast")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFDCDCDC');  





  
//SHEET 2 - INTERVALS PAE

  $sheet2= $excel->createSheet();
  $sheet2->setTitle("Intervals PAE"); 
  
   $queues= array();
  //GET DISTINCT AGING QUEUES
  $result= $local->query("Select * from Tasks_$system where (PARENT_QUEUE in $parent or QUEUE in $parent) and RELEASE_DATE!='' and COMP_DATE!='' group by QUEUE");
  while($row= $result->fetch_assoc()) { array_push($queues,$row['QUEUE']); }

  $headerCount= count($queues);
  
  $headerFirst= "B1";
  $headerLast= $alpha[$headerCount].'1';
  
  $contentFirst="B2";

  $x=0;
  foreach($queues as $queue) {
  
    $x++;
	$colNumber= $x;
    $cell= $alpha[$colNumber]."1";
	$cellValue= $queue;
  
    $sheet2->setCellValue("$cell","$cellValue");
  }
  
  $tasks= array();
  //GET DISTINCT AGING TASKS
  $result2= $local->query("Select * from Tasks_$system where (PARENT_QUEUE in $parent or QUEUE in $parent) and RELEASE_DATE!='' and COMP_DATE!='' group by TASK");
  while($row2= $result2->fetch_assoc()) { array_push($tasks,$row2['TASK']); }

  $labelCount= count($tasks);
  
  $labelFirst= "A2";
  $labelLast= "A".($labelCount+1);

  $y=1;
  foreach($tasks as $task) {
  
    $y++;
	$rowNumber= $y;
    $cell= "A".$rowNumber;
	$cellValue= $task;
  
    $sheet2->setCellValue("$cell","$cellValue");
	
    $x=0;
	//FOREACH QUEUE
	foreach($queues as $queue) {
	
	  $x++;
	  $colNumber= $x;
	
	  $intervals= array();

      $result3= $local->query("Select * from Tasks_$system where QUEUE='$queue' and TASK='$task' and RELEASE_DATE!='' and COMP_DATE!=''");
      while ($row3= $result3->fetch_assoc()) {
	  
	    $compStr= strtotime($row3['COMP_DATE']);
        $now= strtotime("now");
        $dif= ($now-$compStr)/86400;
		  
        if($dif<92) {

          $relStr= strtotime($row3['RELEASE_DATE']);
          $interval= ($compStr-$relStr)/86400;

          array_push($intervals,$interval);
        }
      } 

      $intervalsCount= count($intervals);
      $sum= array_sum($intervals);
	  
	  $cell= $alpha[$colNumber].''.$rowNumber;
	  
      if($intervalsCount>0) {
        $cellValue= round($sum/$intervalsCount,1);
        $sheet2->setCellValue("$cell","$cellValue");
      }   
	  else { $sheet2->setCellValue("$cell","-"); }
	}
  }
  
  $contentLast= $alpha[$colNumber] . '' . $rowNumber;
  
//SET CONTENT COLUMN WIDTHS 
  foreach(range('B','Z') as $columnID) { $sheet1->getColumnDimension($columnID)->setWidth(10); }
//SET ROW LABEL COLUMN WIDTH
  $sheet2->getColumnDimension("A")->setWidth(14);
//CENTER HEADER TEXT
  $sheet2->getStyle("$headerFirst:$headerLast")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//CENTER CONTENT TEXT
  $sheet2->getStyle("$contentFirst:$contentLast")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
//HEADER BACKGROUND
  $sheet2->getStyle("$headerFirst:$headerLast")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F1678');
//HEADER BORDER
  $sheet2->getStyle("$headerFirst:$headerLast")->applyFromArray($borderAll);
//HEADER BOLD FONT
  $sheet2->getStyle("$headerFirst:$headerLast")->applyFromArray(array("font"=>array("bold"=>true)));
//HEADER WHITE TEXT
  $sheet2->getStyle("$headerFirst:$headerLast")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
//BORDER OUTLINE ROW LABELS
  $sheet2->getStyle("$labelFirst:$labelLast")->applyFromArray($borderOutline);
//BOLD ROW LABELS
  $sheet2->getStyle("$labelFirst:$labelLast")->applyFromArray(array("font"=>array("bold"=>true)));
//GRAY FILL ROW LABELS
  $sheet2->getStyle("$labelFirst:$labelLast")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFDCDCDC');
  
  

//START NVX

  $system="NVX";
  
  //SHEET 3 - AGING NVX
 
  $sheet3= $excel->createSheet();
  $sheet3->setTitle('Aging NVX');
  
  $queues= array();
  //GET DISTINCT AGING QUEUES
  $result= $local->query("Select * from Tasks_$system where (PARENT_QUEUE in $parent or QUEUE in $parent) and RELEASE_DATE!='' and COMP_DATE='' group by QUEUE");
  while($row= $result->fetch_assoc()) { array_push($queues,$row['QUEUE']); }

  $headerCount= count($queues);
  
  $headerFirst= "B1";
  $headerLast= $alpha[$headerCount].'1';
  
  $contentFirst="B2";

  $x=0;
  foreach($queues as $queue) {
  
    $x++;
	$colNumber= $x;
    $cell= $alpha[$colNumber]."1";
	$cellValue= $queue;
  
    $sheet3->setCellValue("$cell","$cellValue");
  }
  
  $tasks= array();
  //GET DISTINCT AGING TASKS
  $result2= $local->query("Select * from Tasks_$system where (PARENT_QUEUE in $parent or QUEUE in $parent) and RELEASE_DATE!='' and COMP_DATE='' group by TASK");
  while($row2= $result2->fetch_assoc()) { array_push($tasks,$row2['TASK']); }

  $labelCount= count($tasks);
  
  $labelFirst= "A2";
  $labelLast= "A".($labelCount+1);

  $y=1;
  foreach($tasks as $task) {
  
    $y++;
	$rowNumber= $y;
    $cell= "A".$rowNumber;
	$cellValue= $task;
  
    $sheet3->setCellValue("$cell","$cellValue");
	
    $x=0;
	//FOREACH QUEUE
	foreach($queues as $queue) {
	
	  $x++;
	  $colNumber= $x;
	
	  $agings= array();

      $result3= $local->query("Select * from Tasks_$system where QUEUE='$queue' and TASK='$task' and RELEASE_DATE!='' and COMP_DATE=''");
      while ($row3= $result3->fetch_assoc()) {
	    
        $relStr= strtotime($row3['RELEASE_DATE']);
		$now= strtotime("now");
	    $aging= ($now-$relStr)/86400;
         
        array_push($agings,$aging);
      } 

      $agingCount= count($agings);
      $sum= array_sum($agings);
	  
	  $cell= $alpha[$colNumber].''.$rowNumber;

      if($agingCount>0) {
        $cellValue= round($sum/$agingCount,1);
        $sheet3->setCellValue("$cell","$cellValue");
	  }
	  else { $sheet3->setCellValue("$cell","-"); }
	}
  }
  
  $contentLast= $alpha[$colNumber] . '' . $rowNumber;
  
//SET CONTENT COLUMN WIDTHS 
  foreach(range('B','Z') as $columnID) { $sheet1->getColumnDimension($columnID)->setWidth(10); }
//SET ROW LABEL COLUMN WIDTH
  $sheet3->getColumnDimension("A")->setWidth(14);
//CENTER HEADER TEXT
  $sheet3->getStyle("$headerFirst:$headerLast")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//CENTER CONTENT TEXT
  $sheet3->getStyle("$contentFirst:$contentLast")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
//HEADER BACKGROUND
  $sheet3->getStyle("$headerFirst:$headerLast")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F1678');
//HEADER BORDER
  $sheet3->getStyle("$headerFirst:$headerLast")->applyFromArray($borderAll);
//HEADER BOLD FONT
  $sheet3->getStyle("$headerFirst:$headerLast")->applyFromArray(array("font"=>array("bold"=>true)));
//HEADER WHITE TEXT
  $sheet3->getStyle("$headerFirst:$headerLast")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
//BORDER OUTLINE ROW LABELS
  $sheet3->getStyle("$labelFirst:$labelLast")->applyFromArray($borderOutline);
//BOLD ROW LABELS
  $sheet3->getStyle("$labelFirst:$labelLast")->applyFromArray(array("font"=>array("bold"=>true)));
//GRAY FILL ROW LABELS
  $sheet3->getStyle("$labelFirst:$labelLast")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFDCDCDC');  
  
  
  
  
  //SHEET 4 - INTERVALS NVX

  $sheet4= $excel->createSheet();
  $sheet4->setTitle("Intervals NVX"); 
  
   $queues= array();
  //GET DISTINCT AGING QUEUES
  $result= $local->query("Select * from Tasks_$system where (PARENT_QUEUE in $parent or QUEUE in $parent) and RELEASE_DATE!='' and COMP_DATE!='' group by QUEUE");
  while($row= $result->fetch_assoc()) { array_push($queues,$row['QUEUE']); }

  $headerCount= count($queues);
  
  $headerFirst= "B1";
  $headerLast= $alpha[$headerCount].'1';
  
  $contentFirst="B2";

  $x=0;
  foreach($queues as $queue) {
  
    $x++;
	$colNumber= $x;
    $cell= $alpha[$colNumber]."1";
	$cellValue= $queue;
  
    $sheet4->setCellValue("$cell","$cellValue");
  }
  
  $tasks= array();
  //GET DISTINCT AGING TASKS
  $result2= $local->query("Select * from Tasks_$system where (PARENT_QUEUE in $parent or QUEUE in $parent) and RELEASE_DATE!='' and COMP_DATE!='' group by TASK");
  while($row2= $result2->fetch_assoc()) { array_push($tasks,$row2['TASK']); }

  $labelCount= count($tasks);
  
  $labelFirst= "A2";
  $labelLast= "A".($labelCount+1);

  $y=1;
  foreach($tasks as $task) {
  
    $y++;
	$rowNumber= $y;
    $cell= "A".$rowNumber;
	$cellValue= $task;
  
    $sheet4->setCellValue("$cell","$cellValue");
	
    $x=0;
	//FOREACH QUEUE
	foreach($queues as $queue) {
	
	  $x++;
	  $colNumber= $x;
	
	  $intervals= array();

      $result3= $local->query("Select * from Tasks_$system where QUEUE='$queue' and TASK='$task' and RELEASE_DATE!='' and COMP_DATE!=''");
      while ($row3= $result3->fetch_assoc()) {
	  
	    $compStr= strtotime($row3['COMP_DATE']);
        $now= strtotime("now");
        $dif= ($now-$compStr)/86400;
		  
        if($dif<92) {

          $relStr= strtotime($row3['RELEASE_DATE']);
          $interval= ($compStr-$relStr)/86400;

          array_push($intervals,$interval);
        }
      } 

      $intervalsCount= count($intervals);
      $sum= array_sum($intervals);
	  
	  $cell= $alpha[$colNumber].''.$rowNumber;
	  
      if($intervalsCount>0) {
        $cellValue= round($sum/$intervalsCount,1);
        $sheet4->setCellValue("$cell","$cellValue");
      }   
	  else { $sheet4->setCellValue("$cell","-"); }
	}
  }
  
  $contentLast= $alpha[$colNumber] . '' . $rowNumber;
  
//SET CONTENT COLUMN WIDTHS 
  foreach(range('B','Z') as $columnID) { $sheet1->getColumnDimension($columnID)->setWidth(10); }
//SET ROW LABEL COLUMN WIDTH
  $sheet4->getColumnDimension("A")->setWidth(14);
//CENTER HEADER TEXT
  $sheet4->getStyle("$headerFirst:$headerLast")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//CENTER CONTENT TEXT
  $sheet4->getStyle("$contentFirst:$contentLast")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
//HEADER BACKGROUND
  $sheet4->getStyle("$headerFirst:$headerLast")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F1678');
//HEADER BORDER
  $sheet4->getStyle("$headerFirst:$headerLast")->applyFromArray($borderAll);
//HEADER BOLD FONT
  $sheet4->getStyle("$headerFirst:$headerLast")->applyFromArray(array("font"=>array("bold"=>true)));
//HEADER WHITE TEXT
  $sheet4->getStyle("$headerFirst:$headerLast")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
//BORDER OUTLINE ROW LABELS
  $sheet4->getStyle("$labelFirst:$labelLast")->applyFromArray($borderOutline);
//BOLD ROW LABELS
  $sheet4->getStyle("$labelFirst:$labelLast")->applyFromArray(array("font"=>array("bold"=>true)));
//GRAY FILL ROW LABELS
  $sheet4->getStyle("$labelFirst:$labelLast")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFDCDCDC');

  
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
  
  