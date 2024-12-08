<?php

class Money
{
    //ตัวแปรเก็บข้อมูลที่จะใช้ติดต่อกับ DB
    private $connDB;

    //ตัวแปรสารพัดประโยชน์
    public $message;

    //ตัวแปรที่แมพกับคอลัมใน TB ใน DB
    public $moneyId;
    public $moneyDetail;
    public $moneyDate;
    public $moneyInOut;
    public $moneyType;
    public $userId;

    //ฟังชั่นเชื่อมต่อ DB
    public function __construct($connDB)
    {
        $this->connDB = $connDB;
    }

    //ดึงข้อมูลการเงินทั้งหมดตาม userid
    public function calMonenybyUserId($userId){
        //ตัวแปรเก็บคำสั่ง SQL (ที่ล้อกับความต้องการของ API)
        $strSQL = "SELECT * FROM money_tb WHERE userId = :userId";

        //ตัวแปรเก็บค่าการใช้งานคำสั่ง SQL
        $strmt = $this->connDB->prepare($strSQL);

        //เรียกใช้คำสั่ง SQL
        $strmt->bindParam(':userId', $userId);
        $strmt->execute();

        //ส่งค่าที่ได้กลับไปยัง API เพื่อ API จะได้เอาไปใช้ส่งกลับไปยัง Client/User
        return $strmt;
    }

    public function insertMoney($moneyDetail, $moneyDate, $moneyInOut, $moneyType, $userId){
        
        //ตัวแปรเก็บคำสั่ง SQL (ที่ล้อกับความต้องการของ API)
        $strSQL = "INSERT INTO money_tb (moneyDetail, moneyDate, moneyInOut, moneyType, userId) 
        VALUES (:moneyDetail, :moneyDate, :moneyInOut, :moneyType, :userId)";

        //ตัวแปรเก็บค่าการใช้งานคำสั่ง SQL
        $strmt = $this->connDB->prepare($strSQL);

        //เรียกใช้คำสั่ง SQL
        $moneyDetail = htmlspecialchars(strip_tags($moneyDetail));
        $moneyDate = htmlspecialchars(strip_tags($moneyDate));
        $moneyInOut = htmlspecialchars(strip_tags($moneyInOut));
        $moneyType = htmlspecialchars(strip_tags($moneyType));
        $userId = htmlspecialchars(strip_tags($userId));

        $strmt = $this->connDB->prepare($strSQL);

        //เรียกใช้คำสั่ง SQL
        $strmt->bindParam(':moneyDetail', $moneyDetail);
        $strmt->bindParam(':moneyDate', $moneyDate);
        $strmt->bindParam(':moneyInOut', $moneyInOut);
        $strmt->bindParam(':moneyType', $moneyType);
        $strmt->bindParam(':userId', $userId);


        if ($strmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}