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

if (empty($_POST['name'])) {
    $response['success'] = false;
    $response['message'] = "Name is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['sundry'])) {
    $response['success'] = false;
    $response['message'] = "Sundry is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['open_debit'])) {
    $response['success'] = false;
    $response['message'] = "Open Debit is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['open_credit'])) {
    $response['success'] = false;
    $response['message'] = "Open Credit is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['value'])) {
    $response['success'] = false;
    $response['message'] = "Value is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['place'])) {
    $response['success'] = false;
    $response['message'] = "Place is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['address'])) {
    $response['success'] = false;
    $response['message'] = "Address is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['phone'])) {
    $response['success'] = false;
    $response['message'] = "Phone Number is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['tngst'])) {
    $response['success'] = false;
    $response['message'] = "TNGST Number is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['pure_debit'])) {
    $response['success'] = false;
    $response['message'] = "Pure Debit is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['pure_credit'])) {
    $response['success'] = false;
    $response['message'] = "Pure Credit is Empty";
    print_r(json_encode($response));
    return false;
}
$name = $db->escapeString($_POST['name']);
$sundry = $db->escapeString($_POST['sundry']);
$open_debit = $db->escapeString($_POST['open_debit']);
$open_credit = $db->escapeString($_POST['open_credit']);
$value = $db->escapeString($_POST['value']);
$place = $db->escapeString($_POST['place']);
$address = $db->escapeString($_POST['address']);
$phone = $db->escapeString($_POST['phone']);
$tngst = $db->escapeString($_POST['tngst']);
$pure_debit = $db->escapeString($_POST['pure_debit']);
$pure_credit = $db->escapeString($_POST['pure_credit']);


$sql = "INSERT INTO goldsmith_master (`name`,`sundry`,`open_debit`,`open_credit`,`value`,`place`,`address`,`phone`,`tngst`,`pure_debit`,`pure_credit`)VALUES('$name','$sundry','$open_debit','$open_credit','$value','$place','$address','$phone','$tngst','$pure_debit','$pure_credit')";
$db->sql($sql);
$sql = "SELECT * FROM goldsmith_master ORDER BY id DESC LIMIT 1";
$db->sql($sql);
$res = $db->getResult();
$response['success'] = true;
$response['message'] = "Dealer Goldsmith Master Added Successfully ";
$response['data'] = $res;

print_r(json_encode($response));
?>