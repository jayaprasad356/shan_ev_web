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


if (empty($_POST['email'])) {
    $response['success'] = false;
    $response['message'] = "Email Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['password'])) {
    $response['success'] = false;
    $response['message'] = "Password is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['property_type'])) {
    $response['success'] = false;
    $response['message'] = "Type of Property is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['bedrooms_count'])) {
    $response['success'] = false;
    $response['message'] = "Number Of Bedrooms is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['evc_code'])) {
    $response['success'] = false;
    $response['message'] = "EVC Code is Empty";
    print_r(json_encode($response));
    return false;
}
$email = $db->escapeString($_POST['email']);
$password = $db->escapeString($_POST['password']);
$property_type = $db->escapeString($_POST['property_type']);
$bedrooms_count = $db->escapeString($_POST['bedrooms_count']);
$evc_code = $db->escapeString($_POST['evc_code']);

$sql = "SELECT * FROM users WHERE email='$email'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    $response['success'] = false;
    $response['message'] ="Email Id Already Exists";
    print_r(json_encode($response));
    return false;
}

$sql = "SELECT * FROM evc_codes WHERE evc_code='$evc_code'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num == 0) {
    $response['success'] = false;
    $response['message'] ="EVC Code Invalid";
    print_r(json_encode($response));
    return false;
}
$wallet = $res[0]['amount'];
$sql = "INSERT INTO users (`email`,`password`,`property_type`,`bedrooms_count`,`wallet`)VALUES('$email','$password','$property_type','$bedrooms_count',$wallet)";
$db->sql($sql);
$sql = "SELECT * FROM users WHERE email = '$email'";
$db->sql($sql);
$res = $db->getResult();
$response['success'] = true;
$response['message'] = "Registered  Successfully";
$response['data'] = $res;
print_r(json_encode($response));
?>