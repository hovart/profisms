<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', 0);
ini_set('max_execution_time', -1);


require __DIR__ . '/../../vendor/autoload.php';
global $BController, $User;

use Multi\MsisdnListMsisdn;
use Multi\SmsMulti;

$importfrom = getString('importfrom', '');

$removefirst = getInt('removefirst');
$removediacritics = getInt('removediacritics', 0);
$duplicity = getString('duplicity', 'nonumbertext');
$caption = getString('caption','test');
$msisdnlists = getArray('msisdnlists', array());

$result = $caption ? SmsMulti::ERROR_FILE : SmsMulti::ERROR_CAPTION ;
$id = getInt('id',1);
$result = SmsMulti::ERROR_ERROR;
$smsMulti = new SmsMulti($id);
$csv = json_decode($smsMulti->csv, true);

if ($importfrom == 'list') {
  if (sizeOf($msisdnlists)) {
    
    $fn = randomHash(10) . "_list_" . join('.', $msisdnlists);
    $fn = SAVED . "{$fn}.csv";
    $mls = new MsisdnListMsisdn();
    if ($fd = fOpen($fn, 'w')) {

      foreach($msisdnlists as $mlId) {
          $lists = $mls->Db->select('msisdn_list_msisdn')->where(['id_msisdn_list' => $mlId])->all();
          foreach($lists as $list) {
            fWrite($fd, $list['msisdn'] . "\n");
          };
      }
      fClose($fd);
      
    }
  }
} else {
    if (($reader = SmsMulti::GetFileReader('file')) && $caption)
  {
    $fn = randomHash(10) . "_" . $_FILES['file']['name'];
    $fn = DATA . "$fn";

      if (@move_uploaded_file($_FILES['file']['tmp_name'], $fn))
    {
        $newDate = getString('date');

        if ($reader == 'csv')
        {
            $objReader = PHPExcel_IOFactory::createReader($reader);
            $objReader
                ->setDelimiter($csv['delimiter'])
                ->setEnclosure($csv['enclosure'])
//            ->setLineEnding($csv['lineending'])
                ->setInputEncoding($csv['encoding']);
            $objPHPExcel = $objReader->load($fn);
            $objPHPExcel->setActiveSheetIndex(0);
            $list = $objPHPExcel->getActiveSheet();

            $i = 1; //Ignore column names
            $invalidDates = [];
            $fn = randomHash(10) . "_imported_list";
            $fn = DATA . "{$fn}.csv";
            $currentDateTime = date('Y-m-d');
            $fnSave = "imported_list_" . $User->id . '_' . $currentDateTime;
            $fnSave = SAVED . "{$fnSave}.csv";
            if ($fdSave = fopen($fnSave, 'w')) {
                while ($i < 10000) {

                    if ($list->getCell("A" . $i)->getValue() != '') {
                        $dateValue = $list->getCell("B" . $i)->getValue();
                        $date = trim($dateValue);
                        if ($date == '' || is_valid_date_format($date)) {
                            if ($date == '' && $newDate) {
                                $newDate = convert_date_format($newDate);
                                $date = $newDate;
                            }
                            $isValid = is_valid_date($date);

                            if (!$isValid) {
                                $invalidDates[] = (int)$list->getCell("A" . $i)->getValue();
                            }
                        }
                        $result = SmsMulti::ERROR_NOERROR;

                        $smsMulti->Save(array(
                            'number' => $list->getCell("A" . $i)->getValue(),
                            'date' => $date,
                            'name' => $list->getCell("C" . $i)->getValue(),
                            'phone' => $list->getCell("D" . $i)->getValue(),
                            'age' => $list->getCell("E" . $i)->getValue(),
                            'email' => $list->getCell("F" . $i)->getValue(),
                        ), $fdSave);

                        $i++;
                    } else break;
                }
            }
            // Close the file
            fclose($fdSave);

            if(sizeof($invalidDates)){
                echo json_encode([
                    'error' => 1,
                    'message' => 'invalid or empty dates',
                    'rows' => join(',', $invalidDates)
                ]);
            }else{
                echo json_encode([
                    'error' => 0,
                    'message' => 'Imported successfully',
                    'rows' => join(',', $invalidDates)
                ]);
            }


        }

    }
  }
}
if ($result == SmsMulti::ERROR_NOERROR)
{
  $BController->Reload['CTRL'] = 'sms_send_multi0';
  $BController->Reload['id'] = $smsMulti->id;
}  
else
{
  $BController->Reload['CTRL'] = 'sms_send_multi';
  $BController->Reload['error'] = $result;
}
