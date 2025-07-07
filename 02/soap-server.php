<?php
class HelloService {
    public function SayHello($request) {
        return ['greeting' => "Hello, {$request->name}!"];
    }
}

$options = [
    'uri' => 'http://localhost/soap-learn/02/soap-server.php',
    'soap_version' => SOAP_1_1,
];

$server = new SoapServer("hello.wsdl", $options);
$server->setClass('HelloService');
$server->handle();