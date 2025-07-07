<?php
// soap-client.php

try {
    // Create SOAP client
    $client = new SoapClient('http://localhost/soap-learn/04/soap-server.php?wsdl', [
        'cache_wsdl' => WSDL_CACHE_NONE, // ปิดการแคช WSDL
        'trace' => true, // เปิดการติดตาม SOAP
        'exceptions' => true, // เปิดการโยนข้อผิดพลาด
    ]);
    
    // Call the service
    $result = $client->SayHello(['name' => 'จีรวัฒน์']);

    echo "Result: " . $result->greeting;

    echo "<br>";
    // Call the Add method
    $addResult = $client->Add(['a' => 5, 'b' => 10]);
    echo "\nAddition Result: " . $addResult->result;

} catch (SoapFault $e) {
    echo "SOAP Error: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>