<?php

 require(APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel.php');
        require(APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');
        $objExcel = new PHPExcel();
        $objExcel->setActiveSheetIndex(0);
        $objExcel->getActiveSheet()->setCellValue('A1','test');
        $filename ="testexcel.Xlsx";
        $objExcel->getActiveSheet()->SetTitle("test title");
        header('Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition:attachment;filename="'.$filename.'"');
        header('Cache-control:max-age=0');
        $Writer=PHPExcel_IOFactory::createWriter($objExcel,'Excel2007');
        $Writer->save('php://output');
        exit;