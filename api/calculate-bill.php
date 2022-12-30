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

$user_id = $db->escapeString($_POST['user_id']);
$emr_day = $db->escapeString($_POST['emr_day']);
$emr_night = $db->escapeString($_POST['emr_night']);
$gmr = $db->escapeString($_POST['gmr']);
$sql = "SELECT * FROM settings WHERE id =1";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num == 1){
    $day_emr=$res[0]['day_electricity_meter_reading']*$emr_day;
    $night_emr=$res[0]['night_electricity_meter_reading']*$emr_night;
    $day_gmr=$res[0]['day_gas_meter_reading']*$gmr;
    $total=$day_emr+ $night_emr+ $day_gmr;
    $response['success'] = true;
    $response['message'] = "Bill Calculated Successfully";
    $response['total_amount'] = $total;
    print_r(json_encode($response));
}
else{
    $response['success'] = false;
    $response['message'] = "Unit Rate Found";
    print_r(json_encode($response));

}
?>