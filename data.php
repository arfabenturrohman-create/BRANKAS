<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$json_file = 'data_sensor.json';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (file_exists($json_file)) {
        echo file_get_contents($json_file);
    } else {
        echo json_encode(["status" => "error", "message" => "File data_sensor.json tidak ditemukan"]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pin_failed   = isset($_POST['pin_failed'])   ? intval($_POST['pin_failed']) : 0;
    $mpu_x        = isset($_POST['mpu_x'])        ? floatval($_POST['mpu_x'])   : 0.0;
    $mpu_y        = isset($_POST['mpu_y'])        ? floatval($_POST['mpu_y'])   : 0.0;
    $door_status  = isset($_POST['door_status'])  ? $_POST['door_status']       : "TERKUNCI";
    $alarm_status = isset($_POST['alarm_status']) ? $_POST['alarm_status']      : "OFF";

    $data = [
        "pin_failed"   => $pin_failed,
        "mpu_x"        => $mpu_x,
        "mpu_y"        => $mpu_y,
        "door_status"  => $door_status,
        "alarm_status" => $alarm_status
    ];

    if (file_put_contents($json_file, json_encode($data, JSON_PRETTY_PRINT))) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
    exit;
}
?>