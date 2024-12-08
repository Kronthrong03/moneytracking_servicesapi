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

//สร้าง object ที่ทำงานร่วมกับคลาสจากไฟล์ connectDB.php,ไฟล์ใน models ต่างๆ
$connectDB = new ConnectDB();
$money = new Money($connectDB->getConnectionDB());
//ตัวแปรที่เก็บข้อมูลrquestตากฝั่งclient
$data = json_decode(file_get_contents("php://input"));
//เรียกใช้ฟังชั่นดึงข้อมูลทั้งหมดจากตาราง roomtemp_tb นำผลเก็บในตัวแปร
$result = $money->calMonenybyUserId($data->userId);

//นำข้อมูลแปลงเป็น json
//โดยจะตรวจสอบก่อนว่ามีข้อมูลในresultหรือไม่
if( $result->rowCount() > 0 ){
    //มีข้อมูล
    //สร้างตัวแปรเก็บข้อมูลจากresultเพื่อเตรียมไปทำjson
    $resultdata = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $resultArray = array(
            "message"=>"1",
            "moneyId"=>strval($moneyId),
            "moneyDetail"=>$moneyDetail,
            "moneyDate"=>$moneyDate,
            "moneyInOut"=>strval($moneyInOut),
            "moneyType"=>strval($moneyType),
            "userId"=>strval($userId)
        );

        array_push($resultdata, $resultArray);
    }
    //  แปลง resultdata เป็นjson
    echo json_encode($resultdata);
}
else{
    //ไม่มีข้อมูล
    $resultdata = array();
    $resultArray = array(
        "message"=>"0"
    );
    array_push($resultdata, $resultArray);
    echo json_encode($resultdata);
}