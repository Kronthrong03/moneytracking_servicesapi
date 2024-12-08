<?php

class User {
    //ตัวแปรเก็บข้อมูลที่จะใช้ติดต่อกับ DB
    private $connDB;

    //ตัวแปรสารพัดประโยชน์
    public $message;

    //ตัวแปรที่แมพกับคอลัมใน TB ใน DB
    public $userId;
    public $userFullname;
    public $userBirthDate;
    public $userName;
    public $userPassword;
    public $userImage;

    //ฟังชั่นเชื่อมต่อ DB
    public function __construct($connDB)
    {
        $this->connDB = $connDB;
    }

    //ฟังชั้นตรวจสอบชื่อผ฿้ใช้รหัสผ่าน
    public function checkLoginUser($userName, $userPassword){
        $strSQL = "SELECT * FROM user_tb WHERE userName = :userName AND userPassword = :userPassword";

        $userPassword = htmlspecialchars(strip_tags($userPassword));
        $userName = htmlspecialchars(strip_tags($userName));

        $stmt = $this->connDB->prepare($strSQL);

        $stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':userPassword', $userPassword);

        $stmt->execute();

        return $stmt;
    }

    //ฟังชันเพิ่มข้อมูลผู้ใช้ใหม่
    public function insertUser($userFullname, $userBirthDate, $userName, $userPassword, $userImage){
        $strSQL = "INSERT INTO user_tb(userFullname, userBirthDate, userName, userPassword, userImage) 
        VALUES(:userFullname, :userBirthDate, :userName, :userPassword, :userImage)";

        $userFullname = htmlspecialchars(strip_tags($userFullname));
        $userBirthDate = htmlspecialchars(strip_tags($userBirthDate));
        $userName = htmlspecialchars(strip_tags($userName));
        $userPassword = htmlspecialchars(strip_tags($userPassword));
        $userImage = htmlspecialchars(strip_tags($userImage));

        $stmt = $this->connDB->prepare($strSQL);

        $stmt->bindParam(':userFullname', $userFullname);
        $stmt->bindParam(':userBirthDate', $userBirthDate);
        $stmt->bindParam(':userName', $userName);        
        $stmt->bindParam(':userPassword', $userPassword);
        $stmt->bindParam(':userImage', $userImage);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}