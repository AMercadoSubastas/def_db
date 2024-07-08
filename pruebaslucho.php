<?php

include('bejerman-xml/api-bejerman/BejermanClient.php');
include('Connections/amercado.php');

$query_localidad = sprintf("SELECT * FROM localidades WHERE codnum = '2313'");
$localidad = mysqli_query($amercado,$query_localidad) or die(mysqli_error($amercado));
$row_localidad = mysqli_fetch_assoc($localidad);
echo $row_localidad['descripcion'];

$parametrosJson =   ["{\"Comprobante_Tipo\": \"FC\",
    \"Comprobante_Letra\": \"A\",
    \"Comprobante_PtoVenta\": \"$mascara2\",
    \"Comprobante_Numero\": \"$num_fac\",
    \"Comprobante_LoteHasta\": \" \",
    \"Comprobante_FechaEmision\": \"$fechaEmision\",
    \"Cliente_Codigo\": \"@@@#@@\",
    \"Cliente_RazonSocial\": \"$clienteRS\",
    \"Cliente_SitIVA\": \"1\",
    \"Cliente_TipoDocumento\": 1,
    \"Cliente_NroDocumento\": \"$DocNro\",
    \"Cliente_Direccion\": \"$direcc_cliente\",
    \"Cliente_Localidad\": \"CABA\",
    \"Cliente_CodigoPostal\": \"1100\",
    \"Cliente_Provincia\": \"001\",
    \"Cliente_Email\": \"noreply@juanperezsa.com.ar\",
    \"Cliente_CodigoClase\": \"23\",
    \"Cliente_CodigoClase2\": \"0001\",
    \"Vendedor_Codigo\": \"0001\",
    \"Comprobante_CondVenta\": \"02\",
    \"Comprobante_FechaVencimiento\": \"2023-12-01T00:00:00\",
    \"Comprobante_ImporteTotal\": 121000.00,
    \"Comprobante_Moneda\": \"1\",
    \"Comprobante_TipoCambio\": \"UNI\",
    \"Comprobante_CotizacionCambio\": 1,
    \"Comprobante_ListaPrecios\": \"02\",

    \"Comprobante_Items\":
        [{
            \"Comprobante_Tipo\": \"FC\",
            \"Comprobante_Letra\": \"A\",
            \"Comprobante_PtoVenta\": \"00001\",
            \"Comprobante_Numero\": \"00000004\",
            \"Comprobante_LoteHasta\": \" \",
            \"Comprobante_FechaEmision\": \"2023-12-01T16:42:39.44\",
            \"Cliente_Codigo\": \"@@@#@@\",
            \"Item_Tipo\":\"A\",
            \"Item_CodigoArticulo\": \"29\",
            \"Item_CantidadUM1\": 1,
            \"Item_CantidadUM2\": 0,
            \"Item_DescripArticulo\": null,
            \"Item_PrecioUnitario\": 121000.00,
            \"Item_TasaIVAInscrip\": 21,
            \"Item_TasaIVANoInscrip\": 0,
            \"Item_ImporteIVAInscrip\": 21000.00,
            \"Item_ImporteIVANoInscrip\": 0,
            \"Item_ImporteTotal\": 100000.00,
            \"Item_ImporteDescComercial\": 0,
            \"Item_ImporteDescFinanciero\": 0,
            \"Item_ImporteDescGeneral\": 0,
            \"Item_ImporteIVANoGravado\": 0,
            \"Item_TipoIVA\": \"1\",
            \"Item_ImporteDescPorLinea\": 0,
            \"Item_Deposito\": \"02\",
            \"Item_Partida\": \" \",
            \"Item_TasaDescPorItem\": 0,
            \"Item_Importe\": 121000.00,
            \"Item_Proveedor_Codigo\": \"000001\",
            \"Item_FechaEntrega\": \"2023-12-01T16:42:39.44\",
        }],

        \"Comprobante_MediosPago\": null,
        \"Comprobante_DatosAdicionales\": null,
        \"Comprobante_RelacionComprobante\": null }",
        "N",
        "R"];


$response = $bejermanClient->ejecutar('VENTAS', 'IngresarComprobanteJSON', $parametrosJson);

echo $response;