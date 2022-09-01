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

if (empty($_POST['username'])) {
    $response['success'] = false;
    $response['message'] = "User Name is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['password'])) {
    $response['success'] = false;
    $response['message'] = "Password is Empty";
    print_r(json_encode($response));
    return false;
}
$username = $db->escapeString($_POST['username']);
$password = $db->escapeString($_POST['password']);
$sql = "SELECT * FROM admin WHERE username ='$username' AND password='$password'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num == 1){
    $response['success'] = true;
    $response['message'] = "Logged In Successfully";
    $response['data'] = $res;
    print_r(json_encode($response));
}
else{
    $response['success'] = false;
    $response['message'] = "Invalid Credentials";
    print_r(json_encode($response));

}
?>