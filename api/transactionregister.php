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
    $response['message'] = "User Name is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['type'])) {
    $response['success'] = false;
    $response['message'] = "type is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['category'])) {
    $response['success'] = false;
    $response['message'] = "Category is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['place'])) {
    $response['success'] = false;
    $response['message'] = "Place is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['date'])) {
    $response['success'] = false;
    $response['message'] = "Date is Empty";
    print_r(json_encode($response));
    return false;
}
$name = $db->escapeString($_POST['name']);
$type = $db->escapeString($_POST['type']);
$category = $db->escapeString($_POST['category']);
$place = $db->escapeString($_POST['place']);
$date = $db->escapeString($_POST['date']);
$sql = "SELECT * FROM `daily_transaction` WHERE name ='$name',type='$type',category='$category',place='$place',date='$date'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num == 1){
    $response['success'] = true;
    $response['message'] = "Dailytransaction Retrieved Successfully";
    $response['data'] = $res;
    print_r(json_encode($response));
}
else{
    $response['success'] = false;
    $response['message'] = "No Data Found";
    print_r(json_encode($response));

}
?>