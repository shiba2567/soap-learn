<?php
// soap-client.php
try {
    // Create SOAP client
    $client = new SoapClient('http://localhost/soap-learn/05/soap-server.php?wsdl', [
        'cache_wsdl' => WSDL_CACHE_NONE, // ปิดการแคช WSDL
        'trace' => true, // เปิดการติดตาม SOAP
        'exceptions' => true, // เปิดการโยนข้อผิดพลาด
    ]);

    // Call the service
    $result = $client->GetAsset(['assetId' => 2]); // เปลี่ยนเป็น ID ของสินทรัพย์ที่ต้องการ

    if (isset($result->error)) {
        throw new Exception($result->error);
    }
    echo "Result: " . $result->assetDetail->name;

} catch (SoapFault $e) {
    echo "SOAP Error: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>