<?php
class SoapService {
    public function SayHello($request) {
        return ['greeting' => "Hello, {$request->name}!"];
    }

      public function Add($request) {
        $a = $request->a;
        $b = $request->b;
        return ['result' => $a + $b];
    }
}

$server = new SoapServer("service.wsdl"); // โหลด WSDL
$server->setClass("SoapService");         // ผูกกับ class
$server->handle();                        // ประมวลผล
