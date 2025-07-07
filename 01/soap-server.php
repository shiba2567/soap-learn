<?php

// อ่าน raw XML จาก HTTP POST
$requestXml = file_get_contents("php://input");

// ตรวจสอบ header
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $_SERVER['CONTENT_TYPE'] !== 'text/xml') {
    header("HTTP/1.1 415 Unsupported Media Type");
    exit("Unsupported request type");
}

// แปลง XML เป็น object
$xml = simplexml_load_string($requestXml);
$xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');

// ดึง method ที่ถูกเรียก
$method = $xml->xpath('//soap:Body/*')[0]->getName();
$params = $xml->xpath('//soap:Body/*')[0];

// ตัวอย่างการจัดการ Method
switch ($method) {
    case 'getHello':
        $name = (string)$params->name;
        $result = "Hello, " . $name;
        break;

    default:
        $result = "Unknown method: $method";
        break;
}

// ตอบกลับเป็น SOAP XML
header("Content-Type: text/xml; charset=utf-8");
echo '<?xml version="1.0"?>';
?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <<?php echo $method; ?>Response>
      <result><?php echo htmlspecialchars($result); ?></result>
    </<?php echo $method; ?>Response>
  </soap:Body>
</soap:Envelope>
