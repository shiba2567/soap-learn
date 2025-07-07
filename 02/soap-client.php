<?php
// soap-client.php

try {
    // Create SOAP client
    $client = new SoapClient('http://localhost/soap-learn/02/soap-server.php?wsdl', [
        'cache_wsdl' => WSDL_CACHE_NONE, // ปิดการแคช WSDL
        'trace' => true, // เปิดการติดตาม SOAP
        'exceptions' => true, // เปิดการโยนข้อผิดพลาด
    ]);
    
    // Call the service
    $result = $client->SayHello(['name' => 'จีรวัฒน์']);

    echo "Result: " . $result->greeting;

} catch (SoapFault $e) {
    echo "SOAP Error: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>