<?php
require __DIR__ . '/../../vendor/autoload.php';
use Multi\MsisdnListMsisdn;

$mls = new MsisdnListMsisdn();
$data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
$listData['title'] = $data['title'];
$msisdnData['msisdn'] = $data['msisdn'];
$list = $mls->Db->insert('msisdn_list',$listData);

if($list->id && $msisdnData){
    $msisdnData['id_msisdn_list'] = $list->id;
    $listMssdn = $mls->Db->insert('msisdn_list_msisdn',$msisdnData);
}
if($list && $listMssdn){
    echo json_encode([
        'success' => true,
        'message' => 'The new list added successfully',
    ]);
}else{
    echo json_encode([
        'success' => false,
        'message' => 'Something went wrong',
    ]);
}

