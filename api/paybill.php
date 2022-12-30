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


if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "User Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['date'])) {
    $response['success'] = false;
    $response['message'] = "Date is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['emr_day'])) {
    $response['success'] = false;
    $response['message'] = "EMR Day is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['emr_night'])) {
    $response['success'] = false;
    $response['message'] = "EMR Night is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['gmr'])) {
    $response['success'] = false;
    $response['message'] = "GMR is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['total'])) {
    $response['success'] = false;
    $response['message'] = "Total is Empty";
    print_r(json_encode($response));
    return false;
}

$user_id = $db->escapeString($_POST['user_id']);
$date = $db->escapeString($_POST['date']);
$emr_day = $db->escapeString($_POST['emr_day']);
$emr_night = $db->escapeString($_POST['emr_night']);
$gmr = $db->escapeString($_POST['gmr']);
$total = $db->escapeString($_POST['total']);
$sql = "SELECT * FROM users WHERE id =$user_id";
$db->sql($sql);
$res = $db->getResult();
if ($total > $res[0]['wallet'] ){
    $response['success'] = true;
    $response['message'] = "Your Wallet Balance is Low";
    print_r(json_encode($response));
}
else{
    $sql = "INSERT INTO bills (user_id,date,emr_day,emr_night,gmr,total) VALUES ('$user_id','$date','$emr_day','$emr_night','$gmr','$total')";
    $db->sql($sql);
    $sql = "UPDATE users SET wallet=wallet-$total WHERE id=$user_id";
    $db->sql($sql);
    $sql = "SELECT * FROM bills WHERE user_id=" . $user_id;
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "Bill Paid Successfully";
    $response['data'] = $res;
    print_r(json_encode($response));

}
?>