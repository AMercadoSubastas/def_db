<?php

class BejermanClient {
    private $url;
    private $token;

    public function __construct($url) {
        $this->url = $url;
    }

    public function login($usuario, $clave, $codEmpresa, $ptoTrabajo, $codSucursal = '') {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:loc="http://localhost:57213/">
    <soapenv:Header/>
    <soapenv:Body>
        <loc:EFlexSDK_WSRegistro>
            <loc:xUsuario>' . $usuario . '</loc:xUsuario>
            <loc:xClave>' . $clave . '</loc:xClave>
            <loc:xCodEmpresa>' . $codEmpresa . '</loc:xCodEmpresa>
            <loc:xPtoTrabajo>' . $ptoTrabajo . '</loc:xPtoTrabajo>
            <loc:xCodSucursal>' . $codSucursal . '</loc:xCodSucursal>
        </loc:EFlexSDK_WSRegistro>
    </soapenv:Body>
</soapenv:Envelope>';

        $response = $this->sendRequest($xml, 'http://localhost:57213/IEFlexSDK_Service/EFlexSDK_WSRegistro');
        $xml_response = new SimpleXMLElement($response);
        $xml_response->registerXPathNamespace('s', 'http://schemas.xmlsoap.org/soap/envelope/');
        $xml_response->registerXPathNamespace('a', 'http://schemas.datacontract.org/2004/07/SB.NET.eFlex.SDKWS');
        $this->token = (string)$xml_response->xpath('//a:Token')[0];
    }

    public function sendRequest($xml, $soapAction) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: text/xml',
            'SOAPAction: "' . $soapAction . '"'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $response;
    }

    public function ejecutar($circuito, $operacion, $parametrosJson, $parametros = []) {
        $parametrosXml = '';
        foreach ($parametros as $parametro) {
            $parametrosXml .= '<arr:anyType>' . $parametro . '</arr:anyType>';
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:arr="http://schemas.microsoft.com/2003/10/Serialization/Arrays" xmlns:sb="http://schemas.datacontract.org/2004/07/SB.NET.eFlex.SDKWS" xmlns:loc="http://localhost:57213/" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
    <soapenv:Header/>
    <soapenv:Body>
        <loc:EFlexSDK_WSEjecutar>
            <loc:xRequest>
                <sb:Circuito>' . $circuito . '</sb:Circuito>
                <sb:Operacion>' . $operacion . '</sb:Operacion>
                <sb:Parametros>' . $parametrosXml . '</sb:Parametros>
                <sb:ParametrosJson>' . htmlspecialchars(json_encode($parametrosJson)) . '</sb:ParametrosJson>
                <sb:Token>' . $this->token . '</sb:Token>
            </loc:xRequest>
        </loc:EFlexSDK_WSEjecutar>
    </soapenv:Body>
</soapenv:Envelope>';

        return $this->sendRequest($xml, 'http://localhost:57213/IEFlexSDK_Service/EFlexSDK_WSEjecutar');
    }
}

// Uso de la clase
$bejermanClient = new BejermanClient('http://45.173.2.84/Bejerman-SDK-WS/EFlexSDK_Service.svc');
$bejermanClient->login('IMPC', 'AmS#23+$', 'AMS', 'IMP');


?>
