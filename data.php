<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Cache-Control: no-cache, no-store, must-revalidate");

$file = "data_sensor.json";


/* =========================
   GET DATA
========================= */

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    if (!file_exists($file)) {

        echo json_encode([
            "status" => "error",
            "message" => "data_sensor.json tidak ditemukan"
        ]);

        exit;
    }

    echo file_get_contents($file);

    exit;
}


/* =========================
   POST DATA
========================= */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $oldData = [];

    if (file_exists($file)) {

        $oldData =
            json_decode(
                file_get_contents($file),
                true
            );

        if (!is_array($oldData)) {
            $oldData = [];
        }

    }


    /* PIN */

    $pin_failed =
        isset($_POST["pin_failed"])
            ? intval($_POST["pin_failed"])
            : ($oldData["pin_failed"] ?? 0);


    /* MPU6050 */

    $accel_x =
        isset($_POST["accel_x"])
            ? floatval($_POST["accel_x"])
            : ($oldData["accel_x"] ?? 0.0);

    $accel_y =
        isset($_POST["accel_y"])
            ? floatval($_POST["accel_y"])
            : ($oldData["accel_y"] ?? 0.0);

    $accel_z =
        isset($_POST["accel_z"])
            ? floatval($_POST["accel_z"])
            : ($oldData["accel_z"] ?? 1.0);


    /* STATUS */

    $solenoid_open =
        isset($_POST["solenoid_open"])
            ? filter_var(
                $_POST["solenoid_open"],
                FILTER_VALIDATE_BOOLEAN
            )
            : ($oldData["solenoid_open"] ?? false);


    $door_open =
        isset($_POST["door_open"])
            ? filter_var(
                $_POST["door_open"],
                FILTER_VALIDATE_BOOLEAN
            )
            : ($oldData["door_open"] ?? false);


    $motion_detected =
        isset($_POST["motion_detected"])
            ? filter_var(
                $_POST["motion_detected"],
                FILTER_VALIDATE_BOOLEAN
            )
            : ($oldData["motion_detected"] ?? false);


    $buzzer_active =
        isset($_POST["buzzer_active"])
            ? filter_var(
                $_POST["buzzer_active"],
                FILTER_VALIDATE_BOOLEAN
            )
            : ($oldData["buzzer_active"] ?? false);


    $led_red_active =
        isset($_POST["led_red_active"])
            ? filter_var(
                $_POST["led_red_active"],
                FILTER_VALIDATE_BOOLEAN
            )
            : ($oldData["led_red_active"] ?? false);


    /* CAMERA */

    $cam_status =
        $_POST["cam_status"]
        ?? ($oldData["cam_status"] ?? "READY");


    $last_capture_time =
        $_POST["last_capture_time"]
        ?? ($oldData["last_capture_time"] ?? "Belum Ada Tangkapan");


    $image_url =
        $_POST["image_url"]
        ?? ($oldData["image_url"] ?? "");


    /* DATA FINAL */

    $data = [

        "solenoid_open" => $solenoid_open,

        "door_open" => $door_open,

        "pin_failed" => $pin_failed,

        "motion_detected" => $motion_detected,

        "accel_x" => $accel_x,

        "accel_y" => $accel_y,

        "accel_z" => $accel_z,

        "cam_status" => $cam_status,

        "last_capture_time" => $last_capture_time,

        "image_url" => $image_url,

        "buzzer_active" => $buzzer_active,

        "led_red_active" => $led_red_active

    ];


    $result =
        file_put_contents(
            $file,
            json_encode(
                $data,
                JSON_PRETTY_PRINT |
                JSON_UNESCAPED_SLASHES
            )
        );


    if ($result !== false) {

        echo json_encode([
            "status" => "success",
            "message" => "Data berhasil diperbarui",
            "data" => $data
        ]);

    } else {

        http_response_code(500);

        echo json_encode([
            "status" => "error",
            "message" => "Gagal menulis data_sensor.json"
        ]);

    }

    exit;
}


/* METHOD TIDAK DIDUKUNG */

http_response_code(405);

echo json_encode([
    "status" => "error",
    "message" => "Method tidak didukung"
]);

?>
