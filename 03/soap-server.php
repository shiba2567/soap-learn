<?php
class CalculatorService {
    public function Add($request) {
        $a = $request->a;
        $b = $request->b;
        return ['result' => $a + $b];
    }
}

$options = [
    'uri' => 'http://example.com/calculator',
    'soap_version' => SOAP_1_1,
];

$server = new SoapServer("calculator.wsdl", $options);
$server->setClass('CalculatorService');
$server->handle();