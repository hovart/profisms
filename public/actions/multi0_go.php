<?php
require __DIR__ . '/../../vendor/autoload.php';

global $BController, $BView, $BConfig, $User, $BDebug;

use Multi\PhoneNumber;
use Multi\SmsMulti;

$id = getInt('id',1);
$result = SmsMulti::ERROR_ERROR;
$smsMulti = new SmsMulti($id);

if ($smsMulti->id && ($User->id == $smsMulti->idUser))
{

  $fn = DATA . $smsMulti->file . '.csv';
  $removefirst = $smsMulti->removefirst;
  $reader = $smsMulti->filetype;
  $csv = json_decode($smsMulti->csv, true);
  $duplicity = $smsMulti->duplicity;
//  if (strtolower($reader) == 'csv')
//  {
//
//    if (($fd = fOpen($fn . ".csv", 'r')))
//    {
//      $result = SmsMulti::ERROR_NOERROR;
//
//      if ($fdOriginal = fOpen($fn. ".csv", 'r'))
//      {
//        $rows = 0;
//        $cols = 0;
//        $i = 0;
//        $rowIndex = 0;
//        $first = $removefirst ? 1 : 0;
//        $invalid = array();
//
//        while ($row = fgetcsv($fdOriginal, 1000))
//        {
//
//          $cols = sizeOf($row);
//          if ($rowIndex >= $first)
//          {
//            if ($csv['encoding'] <> 'utf-8')
//              for ($j = 0; $j < $cols; $j++) $row[$j] = iconv($csv['encoding'], 'utf-8', $row[$j]);
//            if ($smsMulti->removediacritics)
//              for ($j = 0; $j < $cols; $j++) $row[$j] = cs2us($row[$j]);
//            for ($j = 0; $j < $cols; $j++) $row[$j] = trim($row[$j]);
//
//            //
//            if ($row[0])
//            {
//              $rows++;
//              $_num = $row[0];
//
//              $num = PhoneNumber::GetPhone($_num);
//              //echo "$_num, $num | ";
//              if (!$num)
//              {
//                array_push($invalid, $_num);
//              }
//              else
//              {
//                $row[0] = $num;
//                fWrite($fd, arrayAsCSV($row, ',') . "\r\n");
//              }
//            }
//          }
//          $rowIndex++;
//        }
//
//        $smsMulti->Save(array(
//          'original_rows' => $rows,
//          'original_columns' => $cols,
//        ));
//        $smsMulti->Save(array(
//          'invalid' => join(",", $invalid),
//        ));
//        fClose($fdOriginal);
//      }
//      fClose($fd);
//      if (($smsMulti->original_columns == 0) || ($smsMulti->original_rows == 0))
//      {
//        $result = SmsMulti::ERROR_FILE;
//      }
//    }
//  }
//  else
//  {
//
//
//  }

  if (($fd = fOpen($fn . ".csv", 'w')))
  {
    $result = SmsMulti::ERROR_NOERROR;

    if ($reader)
    {
      $objReader = PHPExcel_IOFactory::createReader($reader);
      if ($reader == 'CSV')
      {
        $objReader
            ->setDelimiter($csv['delimiter'])
            ->setEnclosure($csv['enclosure'])
//            ->setLineEnding($csv['lineending'])
            ->setInputEncoding($csv['encoding']);
      }


      $objPHPExcel = $objReader->load($fn);
      $objPHPExcel->setActiveSheetIndex(0);
      $list = $objPHPExcel->getActiveSheet();
      $rows = 0;
      $cols = 0;
      $i = 1;
      while ($i < 100001)
      {
        if ($list->getCell("A" . $i)->getValue() != '')
        {
          $rows = $i;
          $i++;
        }
        else break;
      }
      for ($r = 1; $r <= $rows; $r++)
      {
        for ($i = 65; $i < 91; $i++)
        {
          if ($list->getCell(chr($i) . $r)->getValue() != '')
          {
            $cols = max($cols, $i - 64);
          }
        }
      }
      $row = $removefirst ? 2 : 1;
      $smsMulti->Save(array(
          'original_rows' => $removefirst ? $rows - 1 : $rows,
          'original_columns' => $cols,
          'test' => 'test',
      ));
      $invalid = array();
      while($row <= $rows)
      {
        $col = 1;
        $data = array();
        $_num = $list->getCell("A" . $row)->getCalculatedValue();
        $num = PhoneNumber::GetPhone($_num);
        if (!$num)
        {
          array_push($invalid, $_num);
        }
        else
        {
          while ($col <= $cols)
          {
            $_cvalue = ($col == 1) ? $num : $list->getCell(chr(64 + $col) . $row)->getCalculatedValue();
            if (($col == 2) && $_cvalue) {
              if (is_numeric($_cvalue)) {
                $_cvalue = msdt2strdt((float)$_cvalue);
              } else {
                $_cvalue = date("Y-m-d H:i:s", strtotime($_cvalue));
              }
            }
            array_push($data, $_cvalue);
            $col++;
          }
          if ($smsMulti->removediacritics)
            for ($j = 0; $j < sizeOf($data); $j++) $data[$j] = cs2us($data[$j]);
          fWrite($fd, arrayAsCSV($data, ',') . "\r\n");
        }
        $row++;

      }
      $smsMulti->Save(array(
          'invalid' => join(",", $invalid),
      ));
    }
    fClose($fd);
    if (($smsMulti->original_columns == 0) || ($smsMulti->original_rows == 0))
    {
      $result = SmsMulti::ERROR_FILE;
    }
  }
  $BView->Data['result'] = $result;
  $BView->Data['id'] = $smsMulti->id;
}
else 
{
  echo "nic"; 
  exit;
}



  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  


/*



$removefirst = getInt('removefirst', 0);
$csv = getArray('csv', array());
$duplicity = getString('duplicity', 'nonumbertext');


//printr($_POST);
//printr($_FILES);

//printr($removefirst);
//printr($csv);

$result = SmsMulti::ERROR_FILE;
$smsMulti = new SmsMulti();
if ($reader = SmsMulti::GetFileReader($_FILES['file']['name'], $_FILES['file']['tmp_name']))
{
  $fn = randomHash(10) . "_" . $_FILES['file']['name'];
  $fn = "data/$fn";
  if (move_uploaded_file($_FILES['file']['tmp_name'], $fn) && ($fd = fOpen($fn . ".csv", 'w')))
  {
    $result = SmsMulti::ERROR_NOERROR;
    $smsMulti->Save(array(
      'id_user' => $User->id,
      'file' => $fn,
      'removefirst' => $removefirst,
      'filetype' => $reader,
      'csv' => json_encode($csv),
      'duplicity' => $duplicity,
      'original_file' => $_FILES['file']['name'],
    ));    
    
    if ($reader)
    {
      $objReader = PHPExcel_IOFactory::createReader($reader);
      if ($reader == 'CSV')  
      {
        $objReader 
            ->setDelimiter($csv['delimiter'])
            ->setEnclosure($csv['enclosure'])
            ->setLineEnding($csv['lineending'])
            ->setInputEncoding($csv['encoding']);
      }
      //$objReader->setReadDataOnly(true);
        
      
      @$objPHPExcel = $objReader->load($fn);
      $objPHPExcel->setActiveSheetIndex(0);
      $list = $objPHPExcel->getActiveSheet();   
//      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV')
//          ->setDelimiter(',')
//          ->setEnclosure('"')
//          ->setLineEnding("\r\n")
//          ->setSheetIndex(0)
//          ->save($fn . ".csv");
      
      $rows = 0;
      $cols = 0;
      $i = 1;
      while ($i < 100001)
      {
        if ($list->getCell("A" . $i)->getValue() != '')
        {
          $rows = $i;
          $i++;
        }
        else break;
      }      
      for ($r = 1; $r <= $rows; $r++)
      {
        for ($i = 65; $i < 91; $i++)
        {
          if ($list->getCell(chr($i) . "1")->getValue() != '')
          {
            $cols = max($cols, $i - 64);
          }
        }
      }  
      $row = $removefirst ? 2 : 1;
      //echo "$cols x $rows";
      $smsMulti->Save(array(
        'original_rows' => $removefirst ? $rows - 1 : $rows,
        'original_columns' => $cols,
      ));      
      //echo $smsMulti->dataFile;
      while($row <= $rows)
      {
        $col = 1;
        $data = array();
        while ($col <= $cols)
        {
          array_push($data, $list->getCell(chr(64 + $col) . $row)->getCalculatedValue());
          $col++;
        }
        $row++;
        fWrite($fd, arrayAsCSV($data, ',') . "\r\n");
      }

    }
    fClose($fd);
    if (($smsMulti->original_columns == 0) || ($smsMulti->original_rows == 0))
    {
      $result == SmsMulti::ERROR_FILE;
    }
  }
}
if ($result == SmsMulti::ERROR_NOERROR)
{
  $BController->Reload['CTRL'] = 'sms_send_multi1';
  $BController->Reload['id'] = $smsMulti->id;
}  
else
{
  $BController->Reload['CTRL'] = 'sms_send_multi';
  $BController->Reload['error'] = $result;
}
*/


?>
