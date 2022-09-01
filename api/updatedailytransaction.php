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

if (empty($_POST['goldsmith_master_id'])) {
    $response['success'] = false;
    $response['message'] = "Goldsmith Master Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['date'])) {
    $response['success'] = false;
    $response['message'] = "Date is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['type'])) {
    $response['success'] = false;
    $response['message'] = "Type is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['category'])) {
    $response['success'] = false;
    $response['message'] = "Category is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['weight'])) {
    $response['success'] = false;
    $response['message'] = "Weight is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['stone_weight'])) {
    $response['success'] = false;
    $response['message'] = "Stone Weight is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['wastage'])) {
    $response['success'] = false;
    $response['message'] = "Wastage is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['touch'])) {
    $response['success'] = false;
    $response['message'] = "Touch is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['rate'])) {
    $response['success'] = false;
    $response['message'] = "Rate is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['gst'])) {
    $response['success'] = false;
    $response['message'] = "GST is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['amount'])) {
    $response['success'] = false;
    $response['message'] = "Amount is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['mc'])) {
    $response['success'] = false;
    $response['message'] = "MC is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['purity'])) {
    $response['success'] = false;
    $response['message'] = "Purity is Empty";
    print_r(json_encode($response));
    return false;
}
$goldsmith_master_id = $db->escapeString($_POST['goldsmith_master_id']);
$date = $db->escapeString($_POST['date']);
$type = $db->escapeString($_POST['type']);
$category = $db->escapeString($_POST['category']);
$weight = $db->escapeString($_POST['weight']);
$stone_weight = $db->escapeString($_POST['stone_weight']);
$wastage = $db->escapeString($_POST['wastage']);
$touch = $db->escapeString($_POST['touch']);
$rate = $db->escapeString($_POST['rate']);
$gst = $db->escapeString($_POST['gst']);
$amount = $db->escapeString($_POST['amount']);
$mc = $db->escapeString($_POST['mc']);
$purity = $db->escapeString($_POST['purity']);

$sql = "SELECT * FROM daily_transaction WHERE id = '" . $ID . "'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);

if($num==1){
    
        $sql = "UPDATE daily_transaction SET goldsmith_master_id='$goldsmith_master_id',date='$date',type='$type',category='$category',weight='$weight',stone_weight='$stone_weight',wastage='$wastage',touch='$touch',rate='$rate',gst='$gst',amount='$amount',mc='$mc',purity='$purity' WHERE id=$ID";
        $db->sql($sql);
        $sql = "SELECT * FROM daily_transaction ORDER BY id DESC LIMIT 1";
        $db->sql($sql);
        $res = $db->getResult();
        $response['success'] = true;
        $response['message'] = "Daily Transaction Updated Successfully ";
        $response['data'] = $res;
}
else{
    $response['success'] = false;
    $response['message'] = "Data Not Found";
}
print_r(json_encode($response));
?>