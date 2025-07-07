<?php
// soap-client.php
try {
    // Create SOAP client
    $client = new SoapClient('http://localhost/soap-learn/06/soap-server.php?wsdl', [
        'cache_wsdl' => WSDL_CACHE_NONE, // ปิดการแคช WSDL
        'trace' => true, // เปิดการติดตาม SOAP
        'exceptions' => true, // เปิดการโยนข้อผิดพลาด
    ]);

    // Call the service
    $result = $client->GetAssets(); // เรียกใช้ GetAssets แทน GetAsset เพื่อดึงข้อมูลสินทรัพย์ทั้งหมด



    if (isset($result->error)) {
        throw new Exception($result->error);
    }


    if (isset($result->assetDetails)) {
        foreach ($result->assetDetails->asset as $asset) {
        
            echo "Asset ID: " . htmlspecialchars($asset->id, ENT_QUOTES, 'UTF-8') . "<br>";
            echo "Name: " . htmlspecialchars($asset->name, ENT_QUOTES, 'UTF-8') . "<br>";
            echo "Description: " . htmlspecialchars($asset->description, ENT_QUOTES, 'UTF-8') . "<br>";
            echo "-------------------------<br>";
        }
    } else {
        echo "No assets found.";
    }
} catch (SoapFault $e) {
    echo "SOAP Error: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
