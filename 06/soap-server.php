<?php
// connnect database mysql

$con = mysqli_connect("localhost", "root", "", "soap_xml");

class SoapService {
    public function GetAssets($request) {
        global $con;

        // set utf8 encoding
        mysqli_set_charset($con, 'utf8');

        // ค้นหาข้อมูลสินทรัพย์จากฐานข้อมูล
        $query = "SELECT * FROM assets";
        $result = mysqli_query($con, $query);

        if ($result) {
            $assets = [];
            while ($asset = mysqli_fetch_assoc($result)) {
                $assets[] = $asset;
            }
            // ป้องกัน XSS โดยการแปลงข้อมูล
            foreach ($assets as &$asset) {
                foreach ($asset as $key => $value) {
                    //$asset[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); // ป้องกัน XSS
                }
               
            }
            
            // แปลงข้อมูลเป็นรูปแบบที่ SOAP ต้องการ
            $assets = array_map(function($asset) {
                return (object) $asset; // แปลงเป็น object เพื่อให้ SOAP สามารถจัดการได้
            }, $assets);

           return ['assetDetails' => $assets];
        } else {
            return ['error' => 'ไม่พบสินทรัพย์'];
        }
    }
}

$server = new SoapServer("assets.wsdl"); // โหลด WSDL
$server->setClass("SoapService");         // ผูกกับ class
$server->handle();                        // ประมวลผล
