<?php

require_once 'bejerman-xml/api-bejerman/BejermanClient.php';

$conexion = new mysqli("vm3.adrianmercado.com.ar", "remate_user", "gsmzlxersgYuWhR", "amremate");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$limit = 1;
$offset = 2161;
$tcomp = 125;
$serie = 52;

$query = "SELECT * FROM cabfac WHERE tcomp = $tcomp AND serie = 52 LIMIT $limit OFFSET $offset";
$resultado = $conexion->query($query);

if ($resultado->num_rows > 0) {
    while ($row_factura = $resultado->fetch_assoc()) {
        
        $cliente_query = sprintf("SELECT * FROM entidades WHERE codnum = '%s'", $row_factura['cliente']);
        $cliente_array = $conexion->query($cliente_query);
        $row_cliente = $cliente_array->fetch_assoc();

        // Datos  cliente y factura
        $fechaEmision = $row_factura['fecdoc'];

        $beCliente = str_pad($row_cliente['codnum'], 6, '0', STR_PAD_LEFT);
        $beRazsocial = $row_cliente['razsoc'];
        $beClienteTipoIva = $row_cliente['tipoiva'];
        $clienteNroDocumento = $row_cliente['cuit'];
        $beCuit = str_replace('-', '', $clienteNroDocumento);
        $beMail = $row_cliente['mailcont'];
        $beDirec = $row_cliente['calle'] . ' ' . $row_cliente['numero'];
        $bePostal = $row_cliente['codpost'];
        
        // Consulta provincia y localidad
        $prov_query = sprintf("SELECT * FROM provincias WHERE codnum = '%d'", $row_cliente['codprov']);
        $prov_array = $conexion->query($prov_query);
        $row_prov = $prov_array->fetch_assoc();
        $beProv = $row_prov['codbejerman'];
        
        $loc_query = sprintf("SELECT descripcion FROM localidades WHERE codnum = '%d'", $row_cliente['codloc']);
        $loc_array = $conexion->query($loc_query);
        $row_loc = $loc_array->fetch_assoc();
        $beLoc = $row_loc['descripcion'];

        // Datos de la factura
        $comprobante_Tipo = "FC";
        $comprobante_Letra = "A";
        $ptoVenta = "00002"; // Punto de venta
        $beRemate = $row_factura['codrem'];
        $totNetoItem = $row_factura['totneto21'];
        $tazaIvaTotal = $row_factura['totbruto'];
        $tazaIva = $row_factura['totiva21'];
        $ncomp = $row_factura['ncomp'];
        $numero_factura = str_pad($ncomp, 8, '0', STR_PAD_LEFT);
        $tcomp = $row_factura['tcomp'];
        $serie = $row_factura['serie'];
        // CAE
        $beCae = $row_factura['CAE'];
        $beVenciCae = $row_factura['CAEFchVto'];

        // Artículos o conceptos de la factura
        $items_query = sprintf("SELECT * FROM detfac WHERE ncomp = $ncomp AND tcomp = $tcomp and serie = $serie");
        $items_array = $conexion->query($items_query);
        $items = [];

        if ($row_factura['totcomis'] != 0.00){
            $totalesNoGravadosComis = $row_factura['totcomis'] * 1.21;

            $item = [
                "Comprobante_Tipo" => $comprobante_Tipo,
                "Comprobante_Letra" => $comprobante_Letra,
                "Comprobante_PtoVenta" => $ptoVenta,
                "Comprobante_Numero" => $numero_factura,
                "Comprobante_LoteHasta" => " ",
                "Comprobante_FechaEmision" => $fechaEmision,
                "Cliente_Codigo" => $beCliente,
                "Item_Tipo" => "A",
                "Item_CodigoArticulo" => 5, // Código del artículo
                "Item_CantidadUM1" => 1, // Cantidad del ítem
                "Item_CantidadUM2" => 0,
                "Item_DescripArticulo" => "Uso de Plataforma", // Descripción del ítem
                "Item_PrecioUnitario" => $totalesNoGravadosComis, // Precio unitario
                "Item_TasaIVAInscrip" => 0, // Tasa de IVA inscripto
                "Item_TasaIVANoInscrip" => 0,
                "Item_ImporteIVAInscrip" => 0, // Importe de IVA inscripto
                "Item_ImporteIVANoInscrip" => 0,
                "Item_ImporteTotal" => $totalesNoGravadosComis, // Importe total del ítem
                "Item_ImporteDescComercial" => 0,
                "Item_ImporteDescFinanciero" => 0,
                "Item_ImporteDescGeneral" => 0,
                "Item_ImporteIVANoGravado" => 0,
                "Item_TipoIVA" => "1",
                "Item_ImporteDescPorLinea" => 0,
                "Item_Deposito" => "00",
                "Item_Partida" => " ",
                "Item_TasaDescPorItem" => 0,
                "Item_Importe" => $totalesNoGravadosComis
            ];

            // Añadir cada ítem al array de ítems
            array_push($items, $item);
        }

        if ($row_factura['totimp'] != 0.00) {
            $totalesNoGravadosGs = $row_factura['totimp'] * 1.21;
    
            $item = [
                "Comprobante_Tipo" => $comprobante_Tipo,
                "Comprobante_Letra" => $comprobante_Letra,
                "Comprobante_PtoVenta" => $ptoVenta,
                "Comprobante_Numero" => $numero_factura,
                "Comprobante_LoteHasta" => " ",
                "Comprobante_FechaEmision" => $fechaEmision,
                "Cliente_Codigo" => $beCliente,
                "Item_Tipo" => "A",
                "Item_CodigoArticulo" => 7, // Código del artículo
                "Item_CantidadUM1" => 1, // Cantidad del ítem
                "Item_CantidadUM2" => 0,
                "Item_DescripArticulo" => "Gastos Administrativos", // Descripción del ítem
                "Item_PrecioUnitario" => $totalesNoGravadosGs, // Precio unitario
                "Item_TasaIVAInscrip" => 0, // Tasa de IVA inscripto
                "Item_TasaIVANoInscrip" => 0,
                "Item_ImporteIVAInscrip" => 0, // Importe de IVA inscripto
                "Item_ImporteIVANoInscrip" => 0,
                "Item_ImporteTotal" => $totalesNoGravadosGs, // Importe total del ítem
                "Item_ImporteDescComercial" => 0,
                "Item_ImporteDescFinanciero" => 0,
                "Item_ImporteDescGeneral" => 0,
                "Item_ImporteIVANoGravado" => 0,
                "Item_TipoIVA" => "1",
                "Item_ImporteDescPorLinea" => 0,
                "Item_Deposito" => "00",
                "Item_Partida" => " ",
                "Item_TasaDescPorItem" => 0,
                "Item_Importe" => $totalesNoGravadosGs
            ];

            // Añadir cada ítem al array de ítems
            array_push($items, $item);
        }


        if ($items_array->num_rows > 0) {
            while ($row_item = $items_array->fetch_assoc()) {

                $ivas = $row_item['porciva'];

                if (!$row_item['concafac'] == null || !$row_item['concafac'] == 0) {

                    // Si 'concafac' no es null, ejecuta esta parte
                    $codigoArticulo = $row_item['concafac'];
                    $concepto_query = "SELECT * FROM concafactven WHERE nroconc = $codigoArticulo";
                    $concepto_array = $conexion->query($concepto_query);
                    $row_concepto = $concepto_array->fetch_assoc();
                    
                    $ivas = $row_concepto['porcentaje'];
                     
                
                } else {
                
                    // Si 'concafac' es null, entonces realiza esta otra lógica
                    $codigoArticulo = $row_item['porciva'];
                    
                    // Compara correctamente el valor de $codigoArticulo para asignar el código correcto
                    if ($codigoArticulo == 21) {
                        $codigoArticulo = 102;
                    } else {
                        $codigoArticulo = 101;
                    }
                }
            
                $importeIva = $row_item['neto'] * $ivas / 100;
                $precio_unit = $row_item['neto'] + $importeIva;


                // Construir el array de ítems basado en los datos obtenidos de `detfac`
                $item = [
                    "Comprobante_Tipo" => $comprobante_Tipo,
                    "Comprobante_Letra" => $comprobante_Letra,
                    "Comprobante_PtoVenta" => $ptoVenta,
                    "Comprobante_Numero" => $numero_factura,
                    "Comprobante_LoteHasta" => " ",
                    "Comprobante_FechaEmision" => $fechaEmision,
                    "Cliente_Codigo" => $beCliente,
                    "Item_Tipo" => "A",
                    "Item_CodigoArticulo" => $codigoArticulo, // Código del artículo
                    "Item_CantidadUM1" => 1, // Cantidad del ítem
                    "Item_CantidadUM2" => 0,
                    "Item_DescripArticulo" => $row_item['descrip'], // Descripción del ítem
                    "Item_PrecioUnitario" => $precio_unit, // Precio unitario
                    "Item_TasaIVAInscrip" => $ivas, // Tasa de IVA inscripto
                    "Item_TasaIVANoInscrip" => 0,
                    "Item_ImporteIVAInscrip" => $importeIva, // Importe de IVA inscripto
                    "Item_ImporteIVANoInscrip" => 0,
                    "Item_ImporteTotal" => $row_item['neto'], // Importe total del ítem
                    "Item_ImporteDescComercial" => 0,
                    "Item_ImporteDescFinanciero" => 0,
                    "Item_ImporteDescGeneral" => 0,
                    "Item_ImporteIVANoGravado" => 0,
                    "Item_TipoIVA" => "1",
                    "Item_ImporteDescPorLinea" => 0,
                    "Item_Deposito" => "00",
                    "Item_Partida" => " ",
                    "Item_TasaDescPorItem" => 0,
                    "Item_Importe" => $precio_unit
                ];

                // Añadir cada ítem al array de ítems
                array_push($items, $item);
            }
        }
        // Aquí agregamos un loop para procesar los renglones de los ítems de la factura, similar a tu código original
        // El array $items debe ser llenado según las especificaciones

        // Parametros de la factura para Bejerman
        $parametros = [
            "Comprobante_Tipo" => "FC",
            "Comprobante_Letra" => "A",
            "Comprobante_PtoVenta" => $ptoVenta,
            "Comprobante_Numero" => $numero_factura,
            "Comprobante_FechaEmision" => $fechaEmision,
            "Cliente_Codigo" => $beCliente,
            "Cliente_RazonSocial" => $beRazsocial,
            "Cliente_SitIVA" => $beClienteTipoIva,
            "Cliente_TipoDocumento" => 1,
            "Cliente_NroDocumento" => $beCuit,
            "Cliente_Direccion" => $beDirec,
            "Cliente_Localidad" => $beLoc,
            "Cliente_CodigoPostal" => $bePostal,
            "Cliente_Provincia" => $beProv,
            "Cliente_Email" => $beMail,
            "Vendedor_Codigo" => "0001",
			"Comprobante_CondVenta" => "02",
            "Comprobante_ImporteTotal" => $tazaIvaTotal,
            "Comprobante_Moneda" => "1",
            "Comprobante_Proyecto" => $beRemate,
            "Comprobante_TipoCambio" => "UNI",
            "Comprobante_CotizacionCambio" => 1,
			"Comprobante_ListaPrecios" => "02",
            "Comprobante_NumeroCAI" => $beCae,
            "Comprobante_FechaVencimientoCAI" => $beVenciCae,
            "Comprobante_Items" => $items
        ];

        // Convertir a JSON y preparar el request a Bejerman
        $jsonParametros = json_encode($parametros, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                
        $parametrosJson = [
            $jsonParametros,
            "N",
            "R"
        ];

        // Enviar los datos a Bejerman
        $response = $bejermanClient->ejecutar('VENTAS', 'IngresarComprobanteJSON', $parametrosJson);

        // Verificar respuesta
        $codnum =  $row_factura['codnum'];
        if (strpos($response, 'OK') !== false) {
            $query_update = "UPDATE cabfac SET bejerman = 1 WHERE codnum = $codnum";
            $conexion->query($query_update);
            echo "OK";
        } else {
            $query_update = "UPDATE cabfac SET bejerman = 0 WHERE codnum = $codnum";
            $conexion->query($query_update);
            echo "Error o no se encontró 'OK' en la respuesta: " . $response;
        }
        echo " Ncomp = " . $ncomp . " ||| ";
    }
} else {
    echo "No se encontraron facturas.";
}

// Cerrar la conexión
$conexion->close();
?>
