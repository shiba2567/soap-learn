<?php
// soap-client.php
try {
    // Create SOAP client
    $client = new SoapClient('http://localhost/soap-learn/05/soap-server.php?wsdl', [
        'cache_wsdl' => WSDL_CACHE_NONE, // ปิดการแคช WSDL
        'trace' => true, // เปิดการติดตาม SOAP
        'exceptions' => true, // เปิดการโยนข้อผิดพลาด
    ]);

    /*
    echo "<pre>";
    print_r($client->__getFunctions()); // แสดงฟังก์ชันที่มีใน WSDL
    echo "</pre>";
    echo "<pre>";
    print_r($client->__getTypes()); // แสดงประเภทข้อมูลที่มีใน WSDL
    echo "</pre>";
    */
   
    // Call the service
    $result = $client->GetAsset(['assetId' => 1]); // เปลี่ยนเป็น ID ของสินทรัพย์ที่ต้องการ

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