<?php
// ใช่ติดต่อกับฐานข้อมูล
class ConnectDB
{
    // ตัวแปรตัวแรกใช้เก็บการติดต่อ DB
    public $connDB;

    // ตัวแปรตัวที่สองใช้เก็บข้อมูลของ DB ที่จะทำงานด้วย
    private $host = "localhost"; // 127.0.0.1 IP Address,Domain Name
    private $dbname = "money_tracking_db";
    private $username = "root";
    private $password = "";

    //ฟังชั่นเชื่อมต่อ DB
    public function getConnectionDB()
    {
        $this->connDB = null;
        try {
            $this->connDB = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, 
                                    $this->username, 
                                    $this->password);
            $this->connDB->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->connDB;
    }
}