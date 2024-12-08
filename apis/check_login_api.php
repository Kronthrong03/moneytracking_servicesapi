<?php
//API ตรวจสอบชื่อผู้ใช้และรหัสผ่าน และส่งกลับไปกรณีตรวจสอบ
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET"); //GET, POST, PUT,DELETE
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

//เรียกไฟล์ที่จะทำงานร่วมกับ API เช่น ไฟล์ connectDB.php,ไฟล์ใน models ต่างๆ
require_once './../connectDB.php';
require_once './../models/user.php';

//สร้าง object ที่ทำงานร่วมกับคลาสจากไฟล์ connectDB.php,ไฟล์ใน models ต่างๆ
$connectDB = new ConnectDB();
$user = new User($connectDB->getConnectionDB());
//ตัวแปรที่เก็บข้อมูลrquestตากฝั่งclient
$data = json_decode(file_get_contents("php://input"));

$result = $user->checkLoginUser($data->userName, $data->userPassword);
if( $result->rowCount() > 0 ){
    //มีข้อมูล
    $resultdata = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $resultArray = array(
            "message"=>"1",
            "userId"=>strval($userId),
            "userFullname"=>$userFullname,
            "userBirthDate"=>$userBirthDate,
            "userName"=>$userName,
            "userPassword"=>$userPassword,
            "userImage"=>$userImage
        );

        array_push($resultdata, $resultArray);
    }

    //  แปลง resultdata เป็นjson
    echo json_encode($resultdata);
}else{
    //ไม่มีข้อมูล
    $resultdata = array();
    $resultArray = array(
        "message"=>"0"
    );
    array_push($resultdata, $resultArray);
    echo json_encode($resultdata);
}