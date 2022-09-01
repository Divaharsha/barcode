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

if (empty($_POST['admin_id'])) {
    $response['success'] = false;
    $response['message'] = "Admin Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['kdm'])) {
    $response['success'] = false;
    $response['message'] = "KDM is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['metal'])) {
    $response['success'] = false;
    $response['message'] = "Metal is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['katcha'])) {
    $response['success'] = false;
    $response['message'] = "Katcha is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['cash_hand'])) {
    $response['success'] = false;
    $response['message'] = "Cash On Hand is Empty";
    print_r(json_encode($response));
    return false;
}
$admin_id = $db->escapeString($_POST['admin_id']);
$kdm = $db->escapeString($_POST['kdm']);
$metal = $db->escapeString($_POST['metal']);
$katcha = $db->escapeString($_POST['katcha']);
$cash_hand = $db->escapeString($_POST['cash_hand']);

$sql = "SELECT * FROM openingmaster WHERE EXISTS (SELECT * FROM openingmaster)";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);

if($num==1){
    $response['success'] = false;
    $response['message'] = "Data Already Exists";
    $sql = "SELECT * FROM openingmaster ORDER BY id DESC LIMIT 1";
    $db->sql($sql);
    $res = $db->getResult();
    $response['data'] = $res;
}

else{
    $sql = "INSERT INTO openingmaster (`admin_id`,`kdm`,`metal`,`katcha`,`cash_hand`)VALUES('$admin_id','$kdm','$metal','$katcha','$cash_hand')";
    $db->sql($sql);
    $sql = "SELECT * FROM openingmaster ORDER BY id DESC LIMIT 1";
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "Opening Master Added Successfully ";
    $response['data'] = $res;
}


print_r(json_encode($response));
?>