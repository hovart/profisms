<?php
require __DIR__ . '/../../vendor/autoload.php';
error_reporting(E_ALL);
ini_set('display_errors',1);
use Multi\MsisdnListMsisdn;

$mls = new MsisdnListMsisdn();
$data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
$response = $mls->Db->delete('msisdn_list')->where(['id'=>$data['id']]);

if($response){
    echo json_encode([
        'success' => true,
        'message' => 'The list deleted successfully',
    ]);
}else{
    echo json_encode([
        'success' => false,
        'message' => 'Something went wrong',
    ]);
}

