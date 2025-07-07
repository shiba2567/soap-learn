<?php
// connnect database mysql

$con = mysqli_connect("localhost", "root", "", "soap_xml");

class SoapService {
    public function GetAsset($request) {
        global $con;

        $assetId = $request->assetId;

        // ค้นหาข้อมูลสินทรัพย์จากฐานข้อมูล
        $query = "SELECT * FROM assets WHERE id = '$assetId'";
        $result = mysqli_query($con, $query);

        if ($result) {
            $asset = mysqli_fetch_assoc($result);
            if (!$asset) {
                return ['error' => 'ไม่พบสินทรัพย์'];
            }
            // ส่งผลลัพธ์กลับในรูปแบบที่ต้องการ
            foreach ($asset as $key => $value) {
                $asset[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); // ป้องกัน XSS
            }
            // แปลงข้อมูลเป็นรูปแบบที่ SOAP ต้องการ
            $asset = (object) $asset; // แปลงเป็น object เพื่อให้ SOAP
            // ส่งผลลัพธ์กลับ
            
            return ['assetDetail' => $asset];
        } else {
            return ['error' => 'ไม่พบสินทรัพย์'];
        }
    }
}

$server = new SoapServer("asset.wsdl"); // โหลด WSDL
$server->setClass("SoapService");         // ผูกกับ class
$server->handle();                        // ประมวลผล
