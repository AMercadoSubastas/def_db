<?php

// URL del servicio SOAP
$url = 'http://45.173.2.84/Bejerman-SDK-WS/EFlexSDK_Service.svc';

// Datos de la solicitud SOAP en formato XML
$xml = '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:loc="http://localhost:57213/">
    <soapenv:Header/>
    <soapenv:Body>
        <loc:EFlexSDK_WSRegistro>
            <loc:xUsuario>IMPC</loc:xUsuario>
            <loc:xClave>AmS#23+$</loc:xClave>
            <loc:xCodEmpresa>AMS</loc:xCodEmpresa>
            <loc:xPtoTrabajo>IMP</loc:xPtoTrabajo>
            <loc:xCodSucursal/>
        </loc:EFlexSDK_WSRegistro>
    </soapenv:Body>
</soapenv:Envelope>';

// Configurar la solicitud cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: text/xml',
    'SOAPAction: "http://localhost:57213/IEFlexSDK_Service/EFlexSDK_WSRegistro"'
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

// Ejecutar la solicitud cURL
$response = curl_exec($ch);

// Verificar si hubo algún error
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    // Manejar la respuesta
    echo $response;
    // Aquí podrías extraer el token de la respuesta XML
    $xml_response = new SimpleXMLElement($response);
    $xml_response->registerXPathNamespace('s', 'http://schemas.xmlsoap.org/soap/envelope/');
    $xml_response->registerXPathNamespace('a', 'http://schemas.datacontract.org/2004/07/SB.NET.eFlex.SDKWS');
    $token = (string)$xml_response->xpath('//a:Token')[0];
    // echo 'Token: ' . $token;
}

// Datos de la solicitud SOAP en formato XML con el token
$xml1 = '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:arr="http://schemas.microsoft.com/2003/10/Serialization/Arrays" xmlns:sb="http://schemas.datacontract.org/2004/07/SB.NET.eFlex.SDKWS" xmlns:loc="http://localhost:57213/" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
    <soapenv:Header/>
    <soapenv:Body>
        <loc:EFlexSDK_WSEjecutar>
            <loc:xRequest>
                <sb:Circuito>VENTAS</sb:Circuito>
                <sb:Operacion>IngresarComprobanteJSON</sb:Operacion>
                <sb:Parametros>
                    <arr:anyType/>
                </sb:Parametros>
                <sb:ParametrosJson>["{\"Comprobante_Tipo\": \"FC\",\"Comprobante_Letra\": \"A\",\"Comprobante_PtoVenta\": \"00001\",\"Comprobante_Numero\": \"00000004\",\"Comprobante_LoteHasta\": \" \",\"Comprobante_FechaEmision\": \"2023-12-01T16:42:39.44\",\"Cliente_Codigo\": \"@@@#@@\",\"Cliente_RazonSocial\": \"JUAN PEREZ S.A.\",\"Cliente_SitIVA\": \"1\",\"Cliente_TipoDocumento\": 1,\"Cliente_NroDocumento\": \"30553512146\",\"Cliente_Direccion\": \"AV SAN JUAN 100\",\"Cliente_Localidad\": \"CABA\",\"Cliente_CodigoPostal\": \"1100\",\"Cliente_Provincia\": \"001\",\"Cliente_Email\": \"noreply@juanperezsa.com.ar\",\"Cliente_CodigoClase\": \"23\",\"Cliente_CodigoClase2\": \"0001\",\"Vendedor_Codigo\": \"0001\",\"Comprobante_CondVenta\": \"02\",\"Comprobante_FechaVencimiento\": \"2023-12-01T00:00:00\",\"Comprobante_ImporteTotal\": 121000.00,\"Comprobante_Moneda\": \"1\",\"Comprobante_TipoCambio\": \"UNI\",\"Comprobante_CotizacionCambio\": 1,\"Comprobante_ListaPrecios\": \"02\",\"Comprobante_Items\": [{\"Comprobante_Tipo\": \"FC\",\"Comprobante_Letra\": \"A\",\"Comprobante_PtoVenta\": \"00001\",\"Comprobante_Numero\": \"00000004\",\"Comprobante_LoteHasta\": \" \",\"Comprobante_FechaEmision\": \"2023-12-01T16:42:39.44\",\"Cliente_Codigo\": \"@@@#@@\",\"Item_Tipo\":\"A\",\"Item_CodigoArticulo\": \"29\",\"Item_CantidadUM1\": 1,\"Item_CantidadUM2\": 0,\"Item_DescripArticulo\": null,\"Item_PrecioUnitario\": 121000.00,\"Item_TasaIVAInscrip\": 21,\"Item_TasaIVANoInscrip\": 0,\"Item_ImporteIVAInscrip\": 21000.00,\"Item_ImporteIVANoInscrip\": 0,\"Item_ImporteTotal\": 100000.00,\"Item_ImporteDescComercial\": 0,\"Item_ImporteDescFinanciero\": 0,\"Item_ImporteDescGeneral\": 0,\"Item_ImporteIVANoGravado\": 0,\"Item_TipoIVA\": \"1\",\"Item_ImporteDescPorLinea\": 0,\"Item_Deposito\": \"02\",\"Item_Partida\": \" \",\"Item_TasaDescPorItem\": 0,\"Item_Importe\": 121000.00,\"Item_Proveedor_Codigo\": \"000001\",\"Item_FechaEntrega\": \"2023-12-01T16:42:39.44\",}],\"Comprobante_MediosPago\": null,\"Comprobante_DatosAdicionales\": null,\"Comprobante_RelacionComprobante\": null }","N","R"]</sb:ParametrosJson>
                <sb:Token>' . $token . '</sb:Token>
            </loc:xRequest>
        </loc:EFlexSDK_WSEjecutar>
    </soapenv:Body>
</soapenv:Envelope>';


// Configurar la solicitud cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: text/xml',
    'SOAPAction: "http://localhost:57213/IEFlexSDK_Service/EFlexSDK_WSEjecutar"'
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

// Ejecutar la solicitud cURL
$response = curl_exec($ch);

// Verificar si hubo algún error
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    // Manejar la respuesta
    echo $response;
}

// Cerrar la conexión cURL
curl_close($ch);

?>