<?php
ob_start();
set_time_limit(0); // Para evitar el timeout
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors','Yes');
require_once('fpdf17/fpdf.php');
require_once('numaletras.php');
//Conecto con la  base de datos
require_once('Connections/amercado.php');
//header('Content-Type: text/html; charset=UTF-8');


mysqli_select_db($amercado, $database_amercado);

// Leo los parametros del formulario anterior
$fecha_desde = $_POST['fecha_desde'];
$fecha_hasta = $_POST['fecha_hasta'];
$f_desde = $fecha_desde;
$f_hasta = $fecha_hasta;
$anio = "";
$mes = "";
$anio = substr($fecha_desde,6,4);
$mes = substr($fecha_desde,3,2);

$fecha_desde = "'".substr($fecha_desde,6,4)."-".substr($fecha_desde,3,2)."-".substr($fecha_desde,0,2)."'";
$fecha_hasta = "'".substr($fecha_hasta,6,4)."-".substr($fecha_hasta,3,2)."-".substr($fecha_hasta,0,2)."'";



$fechahoy = date("d-m-Y");
// ACA INICIO LOS CAMPOS QUE NECESITO PARA GENERAR EL TXT =========================
$csv_end = "  
";  
$csv_sep = ";";  
//$csv_file = "\LIBROS DE IVA PARA EXCEL\IVA_VENTAS".$fecha_hasta.".txt";  
$csv_file = "MEDIOSPRECIBOS".$mes.$anio.".csv";  

$csv="";  
// ACA ARMO EL RENGLON DE TITULOS : ===============================================
$csv.="Fecha recibo".$csv_sep."Nro de recibo".$csv_sep."Importe".$csv_sep."Razón Social".$csv_sep."CUIT".$csv_sep."Fecha Factura".$csv_sep."Nro de factura".$csv_sep."Monto de factura".$csv_sep."Medio de pago".$csv_sep."Nro del MP".$csv_sep."Fecha pago".$csv_sep."Importe del MP".$csv_sep."Id Subasta".$csv_end; 
  

// Inicio el pdf con los datos de cabecera

	

	$tipoenti=1;
	
	// Leo los clientes
	$query_entidades = sprintf("SELECT * FROM entidades WHERE  tipoent = %s ORDER BY tipoent, codnum", $tipoenti);
	$enti = mysqli_query($amercado, $query_entidades) or die(mysqli_error($amercado));

	$ni_idea = 0.0;
	$cant_reng = 0;
	$cant_cli = 0;
	$cant_cabfac = 0;
	$cant_cabrecibos = 0;
	$cant_cartvalores = 0;
	$total_facturas = 0.0;
	$total_recibos = 0.0;
	$total_cli = 0.0;
	$total = 0.0;
	$tot_gral_chq_terceros = 0.0;
	$tot_gral_depositos    = 0.0;
	$tot_gral_efvo         = 0.0; 
	$tot_gral_dolares      = 0.0;
	$tot_gral_retiva       = 0.0;
	$tot_gral_retibrutos   = 0.0;
	$tot_gral_retganan     = 0.0; 
	$tot_gral_retsuss      = 0.0;
	$tot_gral_retenciones  = 0.0;
    $tot_gral_otrosmedios  = 0.0;
	$tot_gral_saldoafav    = 0.0;
	$tot_gral_devsaldoafav = 0.0;
	while($row_entidades = mysqli_fetch_array($enti)) {
			$cant_cli++;
			$CUIT      = $row_entidades["cuit"];
			$razsoc    = $row_entidades["razsoc"];
			$cliente1   = $row_entidades["codnum"];

		
			// PRIMERO LEO LOS RECIBOS POR CLIENTE
			$query_cabrecibos = sprintf("SELECT * FROM cabrecibo WHERE  cliente = $cliente1 AND fecha BETWEEN %s AND %s ORDER BY cliente, fecha",$fecha_desde, $fecha_hasta);
			$cabrecibos = mysqli_query($amercado, $query_cabrecibos) or die(mysqli_error($amercado));  
			
			$totalRows_cabrecibos = mysqli_num_rows($cabrecibos);
			if ($totalRows_cabrecibos == 0)
					continue;
	
			$tot_chq_terceros = 0.0;
			$tot_depositos    = 0.0;
			$tot_efvo         = 0.0; 
			$tot_dolares      = 0.0;
			$tot_retiva       = 0.0;
			$tot_retibrutos   = 0.0;
			$tot_retganan     = 0.0; 
			$tot_retsuss      = 0.0;
            $tot_otrosmedios  = 0.0;
			$tot_saldoafav    = 0.0;
			$tot_devsaldoafav = 0.0;
	
   
	
			while($row_cabrecibos = mysqli_fetch_array($cabrecibos))	{	
		
	
					$cant_cabrecibos++;
	
					$tcomprec      = $row_cabrecibos["tcomp"];
					$serierec      = $row_cabrecibos["serie"];
					$ncomprec      = $row_cabrecibos["ncomp"];
					$totbrutorec   = $row_cabrecibos["imptot"];
					$fecharec      = $row_cabrecibos["fecha"];
					
					//======================================================================
	
					
					$total_recibos += $totbrutorec;
					//$valor_y += 6;
					//$cant_reng +=1;	
					//LEO DETRECIBO PARA VER LAS FACTURAS RELACIONADAS
					$query_detrecibos = sprintf("SELECT * FROM detrecibo WHERE  tcomp = $tcomprec AND ncomp = $ncomprec");
					$detrecibos = mysqli_query($amercado, $query_detrecibos) or die(mysqli_error($amercado));
					while($row_detrecibos = mysqli_fetch_array($detrecibos)) {
						$nrodocfac = $row_detrecibos["nrodoc"];
						$tcomprel  = $row_detrecibos["tcomprel"];
						$ncomprel  = $row_detrecibos["ncomprel"];
					
						//LEO LA FACTURA PARA SABER EL BRUTO
						$query_cabfac2 = sprintf("SELECT * FROM cabfac WHERE tcomp = '$tcomprel' AND ncomp = '$ncomprel' AND nrodoc = '$nrodocfac' ");
						$cabecerafac2 = mysqli_query($amercado, $query_cabfac2) or die("ERROR LEYENDO LA FACTURA RELACIONADA AL RECIBO"); 
						$row_cabecerafac2 = mysqli_fetch_assoc($cabecerafac2);
						$importe_factura = $row_cabecerafac2["totbruto"];
						$fecha_factura = $row_cabecerafac2["fecreg"];
						$id_subasta = $row_cabecerafac2["codrem"];
						$fechafac =  substr($fecha_factura,8,2)."-".substr($fecha_factura,5,2)."-".substr($fecha_factura,0,4);

						
						
						$total_facturas += $importe_factura;
						$imp_factura = number_format($importe_factura, 2, ',','.');
						
						
					}
					// LEO CARTVALORES PARA EL RECIBO RELACIONADO

					$query_medios = "SELECT * FROM cartvalores WHERE tcomprel = $tcomprec AND serierel = $serierec AND ncomprel = $ncomprec";
					$medios = mysqli_query($amercado, $query_medios) or die(mysqli_error($amercado));
			
					//$totalRows_medios = mysqli_num_rows($medios);

					while($row_medios = mysqli_fetch_array($medios))	{

							$tcomp_medpag      = $row_medios["tcomp"];
							$query_tipo_comprobante = "SELECT * FROM tipcomp WHERE codnum=$tcomp_medpag";
							$tipo_comprobante = mysqli_query($amercado, $query_tipo_comprobante) or die("ERROR LEYENDO TIPCOMP ");
							$row_tipo_comprobante = mysqli_fetch_assoc($tipo_comprobante);
							$t_cbte_desc = $row_tipo_comprobante["descripcion"];
						
							$serie_medpag      = $row_medios["serie"];
							$ncomp_medpag      = $row_medios["ncomp"];
							$t_cbte_nro        = $row_medios["codchq"];
							$t_cbte_fecha      = $row_medios["fechapago"];
							$t_cbte_importe    = $row_medios["importe"];
							$cant_cartvalores++;

							switch($tcomp_medpag) {
								case 8:
									$tot_chq_terceros += $row_medios["importe"];
									$tot_gral_chq_terceros += $row_medios["importe"];
									break;
								case 9:
									$tot_depositos    += $row_medios["importe"];
									$tot_gral_depositos    += $row_medios["importe"];
									break;
								case 12:
									$tot_efvo         += $row_medios["importe"];
									$tot_gral_efvo         += $row_medios["importe"];
									break;
								case 13:
									$tot_dolares      += $row_medios["importe"];
									$tot_gral_dolares      += $row_medios["importe"];
									break;
								case 40:
								case 68:
									$tot_retiva       += $row_medios["importe"];
									$tot_gral_retiva       += $row_medios["importe"];
									$tot_gral_retenciones +=  $row_medios["importe"];
									break;
								case 41:
								case 69:
								case 70:
								case 71:
								case 72:
								case 73:
								case 74:
								case 75:
								case 76:
								case 77:
								case 78:
								case 79:
								case 80:
								case 81:
								case 82:
								case 83:
								case 84:
								case 85:
                                case 90:
                                case 96:
									$tot_retibrutos   += $row_medios["importe"];
									$tot_gral_retibrutos   += $row_medios["importe"];
									$tot_gral_retenciones +=  $row_medios["importe"];
									break;
								case 42:
								case 66:
									$tot_retganan     += $row_medios["importe"];
									$tot_gral_retganan     += $row_medios["importe"];
									$tot_gral_retenciones +=  $row_medios["importe"];
									break;
								case 43:
								case 67:
									$tot_retsuss      += $row_medios["importe"];
									$tot_gral_retsuss      += $row_medios["importe"];
									$tot_gral_retenciones +=  $row_medios["importe"];
									break;
								case 98:
									$tot_saldoafav -= $row_medios["importe"];
									$tot_gral_saldoafav -= $row_medios["importe"];
									break;
								case 91:
									$tot_devsaldoafav += $row_medios["importe"];
									$tot_gral_devsaldoafav += $row_medios["importe"];
									break;
								default:
									$tot_otrosmedios += $row_medios["importe"];
                                    $tot_gral_otrosmedios += $row_medios["importe"];
									break;
			
							}
							// Imprimo los renglones DESDE ACA ARMO EL TXT
							//$csv.="Fecha recibo".$csv_sep."Nro de recibo".$csv_sep."Importe".$csv_sep."Razón Social".$csv_sep."CUIT".$csv_sep."Fecha Factura".$csv_sep."Nro de factura".$csv_sep."Monto de factura".$csv_sep."Medio de pago".$csv_sep."Nro del MP".$csv_sep."Fecha pago".$csv_sep."Importe del MP".$csv_sep."Id Subasta".$csv_end; 
						$totbrutorec = str_replace(".",",",$totbrutorec);
						$importe_factura = str_replace(".",",",$importe_factura);
						$t_cbte_importe = str_replace(".",",",$t_cbte_importe);
						$csv.=$fecharec.$csv_sep.$ncomprec.$csv_sep.$totbrutorec.$csv_sep.$razsoc.$csv_sep.$CUIT.$csv_sep.$fechafac.$csv_sep.$nrodocfac.$csv_sep.$importe_factura.$csv_sep.$t_cbte_desc.$csv_sep.$t_cbte_nro.$csv_sep.$t_cbte_fecha.$csv_sep.$t_cbte_importe.$csv_sep.$id_subasta.$csv_end;
					}

			}
	
	
			

	}
// ACA GRABO EL ARCHIVO TXT ====================================================
if (!$handle = fopen($csv_file, "w")) {  
    echo "No se puede abrir el archivo";  
    exit;  
}  
if (fwrite($handle, utf8_decode($csv)) === FALSE) {  
    echo "No se puede grabar el archivo";  
    exit;  
}  
fclose($handle);  

$file = $csv_file;
header("Content-disposition: attachment; filename=$file");
header("Content-type: application/octet-stream");
readfile($file);

if (!isset($file) || empty($file)) {
    exit();
}
$root = "C:\\LOTES WEB";
$file = basename($file);
$path = $root.$file;
$type = '';
 
if (is_file($path)) {
    $size = filesize($path);
    if (function_exists('mime_content_type')) {
        $type = mime_content_type($path);
    } else if (function_exists('finfo_file')) {
                $info = finfo_open(FILEINFO_MIME);
                $type = finfo_file($info, $path);
                finfo_close($info);
            }
    if ($type == '') {
        $type = "application/force-download";
    }
     // Define los headers
     header("Content-Type: $type");
     header("Content-Disposition: attachment; filename=$file");
     header("Content-Transfer-Encoding: binary");
     header("Content-Length: " . $size);
     // Descargar el archivo
     readfile($path);
} else {
    //die("El archivo no existe.");
}

mysqli_close($amercado);
ob_end_clean();
?>  
