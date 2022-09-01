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

if (empty($_POST['id'])) {
    $response['success'] = false;
    $response['message'] = "Id is Empty";
    print_r(json_encode($response));
    return false;
}
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
$ID = $db->escapeString($_POST['id']);
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

$sql = "SELECT * FROM goldsmithmaster WHERE id = '" . $ID . "'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);

if($num==1){
    
        $sql = "UPDATE goldsmith_master SET name='$name',sundry='$sundry',open_debit='$open_debit',open_credit='$open_credit',value='$value',place='$place',address='$address',phone='$phone',tngst='$tngst',pure_debit='$pure_debit',pure_credit='$pure_credit' WHERE id=$ID";
        $db->sql($sql);
        $sql = "SELECT * FROM goldsmith_master ORDER BY id DESC LIMIT 1";
        $db->sql($sql);
        $res = $db->getResult();
        $response['success'] = true;
        $response['message'] = "Dealer Goldsmith Master Updated Successfully ";
        $response['data'] = $res;
}
else{
    $response['success'] = false;
    $response['message'] = "Dealer Goldsmith Master Not Found";
}
print_r(json_encode($response));
?>