<?php
// soap-client.php
try {
    // Create SOAP client
    $client = new SoapClient('http://localhost/soap-learn/07/soap-server.php?wsdl', [
        'cache_wsdl' => WSDL_CACHE_NONE, // ปิดการแคช WSDL
        'trace' => true, // เปิดการติดตาม SOAP
        'exceptions' => true, // เปิดการโยนข้อผิดพลาด
    ]);

    // Call the service
    $result = $client->GetAssets(); // เรียกใช้ GetAssets แทน GetAsset เพื่อดึงข้อมูลสินทรัพย์ทั้งหมด



    if (isset($result->error)) {
        throw new Exception($result->error);
    }


    echo "<h2>Asset List:</h2>";
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

    echo "call GetAssets successfully.<br>";
    // Call the  GetAsset method
    $assetId = 2; // เปลี่ยนเป็น ID ของสินทรัพย์
    $assetResult = $client->GetAsset(['assetId' => $assetId]);
    if (isset($assetResult->error)) {
        throw new Exception($assetResult->error);
    }
    echo "<h2>Asset Detail for ID $assetId:</h2>";
    if (isset($assetResult->assetDetail)) {
        echo "Asset ID: " . htmlspecialchars($assetResult->assetDetail->id, ENT_QUOTES, 'UTF-8') . "<br>";
        echo "Name: " . htmlspecialchars($assetResult->assetDetail->name, ENT_QUOTES, 'UTF-8') . "<br>";
        echo "Description: " . htmlspecialchars($assetResult->assetDetail->description, ENT_QUOTES, 'UTF-8') . "<br>";
    } else {
        echo "No asset found with ID $assetId.";
    }

} catch (SoapFault $e) {
    echo "SOAP Error: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
