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
if (empty($_POST['category_id'])) {
    $response['success'] = false;
    $response['message'] = "Category Id is Empty";
    print_r(json_encode($response));
    return false;
}
$category_id = $db->escapeString($_POST['category_id']);

$sql = "SELECT p.*,p.id AS id,s.name AS subcategory_name,c.name AS category_name,g.name AS goldsmith_name FROM `products` p,`categories`c,`subcategories` s,`goldsmith_master` g WHERE p.subcategory_id=s.id AND p.category_id=c.id AND p.goldsmith_id=g.id  AND p.category_id = $category_id";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    
    foreach ($res as $row) {
        $temp['id'] = $row['id'];
        $temp['category_name'] = $row['category_name'];
        $temp['subcategory_name'] = $row['subcategory_name'];
        $temp['goldsmith_name'] = $row['goldsmith_name'];
        $temp['huid_number'] = $row['huid_number'];
        $temp['gross_weight'] = $row['gross_weight'];
        $temp['stone_weight'] = $row['stone_weight'];
        $temp['size'] = $row['size'];
        $temp['image'] = DOMAIN_URL . $row['image'];
        $temp['status'] = $row['status'];
        $rows[] = $temp;
        
    }

    $response['success'] = true;
    $response['message'] = "Products listed Successfully";
    $response['data'] = $rows;
    print_r(json_encode($response));

}else{
    $response['success'] = false;
    $response['message'] = "No Products Found";
    print_r(json_encode($response));

}

?>