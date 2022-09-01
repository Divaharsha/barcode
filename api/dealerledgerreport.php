<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


include_once('../includes/crud.php');
$db = new Database();
$db->connect();

if (empty($_POST['sundry'])) {
    $response['success'] = false;
    $response['message'] = "Type of Sundry is Empty";
    print_r(json_encode($response));
    return false;
}

$sundry = $db->escapeString($_POST['sundry']);
$sql = "SELECT * FROM `goldsmith_master`,`daily_transaction` WHERE sundry ='$sundry' AND goldsmith_master.id=daily_transaction.goldsmith_master_id";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num == 1){
    $response['success'] = true;
    $response['message'] = "Retrieved Successfully";
    $response['data'] = $res;
    print_r(json_encode($response));
}
else{
    $response['success'] = false;
    $response['message'] = "No Data Found";
    print_r(json_encode($response));

}
?>