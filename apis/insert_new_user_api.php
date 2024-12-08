<?php
//API ตรวจสอบชื่อผู้ใช้และรหัสผ่าน และส่งกลับไปกรณีตรวจสอบ
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST"); //GET, POST, PUT,DELETE
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

//แปลง base64 ให้เป็นรูปภาพ พร้อมตั้งชื่อรูป แล้วเก็บไว้ที่uploading/user ส่วนชื่อที่เก็บไว้ใน DB
//1.ตั้งชื่อ
$img_filename = "user_" . uniqid() . "_" . time() . ".jpg";
//2.เปลี่ยน base6 เป็นรูป พร้อมกำหนดชื่อรูป แล้วเก็บไว้ที่uploading/user
file_put_contents("./../uploading/user/" . $img_filename, base64_decode($data->userImage));

//เรียกใช้ฟังชั่นดึงข้อมูลทั้งหมดจากตาราง user_tb นำผลเก็บในตัวแปร
$result = $user->insertUser($data->userFullname, $data->userBirthDate,
 $data->userName, $data->userPassword, $img_filename);
 
if($result == true){
    //บันทึกข้อมูลสําเร็จ
    $resultdata = array();
    $resultArray = array(
        "message"=>"1"
    );
    array_push($resultdata, $resultArray);
    echo json_encode($resultdata);
}else{
    //บันทึกข้อมูลไม่สําเร็จ
    $resultdata = array();
    $resultArray = array(
        "message"=>"0"
    );
    array_push($resultdata, $resultArray);
    echo json_encode($resultdata);
}