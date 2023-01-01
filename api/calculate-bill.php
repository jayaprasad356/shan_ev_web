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

$user_id = $db->escapeString($_POST['user_id']);
$emr_day = (isset($_POST['emr_day']) && !empty($_POST['emr_day'])) ? $db->escapeString($_POST['emr_day']) : 0;
$emr_night = (isset($_POST['emr_night']) && !empty($_POST['emr_night'])) ? $db->escapeString($_POST['emr_night']) : 0;
$gmr = (isset($_POST['gmr']) && !empty($_POST['gmr'])) ? $db->escapeString($_POST['gmr']) : 0;

$sql = "SELECT * FROM settings WHERE id =1";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num == 1){
    $day_emr_price = $res[0]['day_electricity_meter_reading'];
    $night_emr_price = $res[0]['night_electricity_meter_reading'];
    $day_gmr_price = $res[0]['day_gas_meter_reading'];
    $sql = "SELECT * FROM bills WHERE user_id= $user_id ORDER BY id DESC LIMIT 1";
    $db->sql($sql);
    $resbill = $db->getResult();
    $num = $db->numRows($resbill);
    if ($num >= 1){
        $emr_day_bill = $resbill[0]['emr_day'];
        $emr_night_bill = $resbill[0]['emr_night'];
        $gmr_bill = $resbill[0]['gmr'];
        if($emr_day !=0 && $emr_day <= $emr_day_bill){
            $response['success'] = false;
            $response['message'] = "Day Electricity Meter Reading Low";
            print_r(json_encode($response));
            return false;

        }
        if($emr_night !=0 && $emr_night <= $emr_night_bill){
            $response['success'] = false;
            $response['message'] = "Night Electricity Meter Reading Low";
            print_r(json_encode($response));
            return false;

        }
        if($day_gmr_price !=0 && $day_gmr_price <= $gmr_bill){
            $response['success'] = false;
            $response['message'] = "Gas Meter Reading Low";
            print_r(json_encode($response));
            return false;

        }
        $emr_day = $emr_day - $emr_day_bill;
        $emr_night = $emr_night - $emr_night_bill;
        $gmr = $gmr - $gmr_bill;

        
        
        
        
    }
    $day_emr=$day_emr_price*$emr_day;
    $night_emr=$night_emr_price*$emr_night;
    $day_gmr=$day_gmr_price*$gmr;
    $total=$day_emr+ $night_emr+ $day_gmr;
    $response['success'] = true;
    $response['message'] = "Bill Calculated Successfully".$emr_day_bill;
    $response['total_amount'] = $total;
    print_r(json_encode($response));
}
else{
    $response['success'] = false;
    $response['message'] = "Unit Rate Found";
    print_r(json_encode($response));

}
?>