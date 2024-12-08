<?php
//API ดึงข้อมูลอุณหภูมิแอร์ทั้งหมด และส่งกลับไป
//ประกาศ header
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET"); //GET, POST, PUT,DELETE
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

//เรียกไฟล์ที่จะทำงานร่วมกับ API เช่น ไฟล์ connectDB.php,ไฟล์ใน models ต่างๆ
require_once './../connectDB.php';
require_once './../models/money.php';
//ตัวแปรที่เก็บข้อมูลrquestตากฝั่งclient
$data = json_decode(file_get_contents("php://input"));

//สร้าง object ที่ทำงานร่วมกับคลาสจากไฟล์ connectDB.php,ไฟล์ใน models ต่างๆ
$connectDB = new ConnectDB();
$money = new Money($connectDB->getConnectionDB());

//เรียกใช้ฟังชั่นดึงข้อมูลทั้งหมดจากตาราง roomtemp_tb นำผลเก็บในตัวแปร
$result = $money->insertMoney($data->moneyDetail, $data->moneyDate, 
$data->moneyInOut, $data->moneyType, $data->userId);

if ($result == true) {
    //บันทึกข้อมูลสําเร็จ
    $resultdata = array();
    $resultArray = array(
        "message" => "1"
    );
    array_push($resultdata, $resultArray);
    echo json_encode($resultdata);
} else {
    //บันทึกข้อมูลไม่สําเร็จ
    $resultdata = array();
    $resultArray = array(
        "message" => "0"
    );
    array_push($resultdata, $resultArray);
    echo json_encode($resultdata);
}