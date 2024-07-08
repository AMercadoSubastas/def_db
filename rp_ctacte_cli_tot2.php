<?php
ob_start();
set_time_limit(0); // Para evitar el timeout
define('FPDF_FONTPATH','fpdf17/font/');

require('fpdf17/fpdf.php');
require('numaletras.php');
//Conecto con la  base de datos
require_once('Connections/amercado.php');
setlocale (LC_ALL,"spanish");
mysqli_select_db($amercado, $database_amercado);

// Leo los parámetros del formulario anterior
$cli_desde = $_POST['cli_desde'];
$cli_hasta = $_POST['cli_hasta'];
$fecha_hasta    = $_POST['fecha_hasta'];
$fecha_hasta = substr($fecha_hasta,6,4)."-".substr($fecha_hasta,3,2)."-".substr($fecha_hasta,0,2);
$fecha_h = "'".$fecha_hasta."'";
$fecha_hasta = $fecha_h;
//$cliente    = $_POST['codnum'];
$fechahoy = date('d-m-Y');


// Leo las cabeceras de facturas

mysqli_select_db($amercado, $database_amercado);
$query_cliente = "SELECT codnum, razsoc FROM entidades WHERE tipoent = 1 AND codnum between $cli_desde AND $cli_hasta ORDER BY codnum";
$cliente_q = mysqli_query($amercado, $query_cliente) or die("ERROR LEYENDO CLIENTES");
//echo "1 -";
// Inicio el pdf con los datos de cabecera
$pdf=new FPDF('P','mm','Legal');

//$pdf->AddFont('Arial','',10);

$linea = 0;
$valor_y = 45;
$acum_total  = 0.00;
while ($row_cliente = mysqli_fetch_assoc($cliente_q)) {
    //echo "2 -";
    $pri_vez = 0;
    $cliente = $row_cliente['codnum'];
    $razsoc = $row_cliente['razsoc'];
    $fechatope = "20201231";
    $acum_cli = 0;
    $query_cabfac = sprintf("SELECT tcomp, ncomp, cliente, totbruto, nrodoc, estado, fecreg, codrem FROM cabfac WHERE cliente = %s AND fecreg BETWEEN '2020-09-01' AND $fecha_hasta ORDER BY  fecreg, cliente, nrodoc", $cliente);
    $cabecerafac = mysqli_query($amercado, $query_cabfac) or die("ERROR LEYENDO CABFAC");

    
    

    // Datos de los renglones
    $i = 0;
    $signo = 1;
    $tc = "";
    $acum_cli    = 0.00;
    $total       = 0.00;
    if ($linea > 48)
        $linea = 0;
    //$linea = 0;
    while($row_cabecerafac = mysqli_fetch_array($cabecerafac))
    {	
        //echo "3 -";
        //if($row_cabecerafac["estado"] == "A")
        //	continue;
        $pri_vez = 1;
        $tcomp      = $row_cabecerafac["tcomp"];
        $ncomp      = $row_cabecerafac["ncomp"];
        //$totneto105 = $row_cabecerafac["totneto105"];
        $totbruto   = $row_cabecerafac["totbruto"];
        //$totneto21  = $row_cabecerafac["totneto21"];
        //$totcomis   = $row_cabecerafac["totcomis"];
        $nrodoc     = $row_cabecerafac["nrodoc"];
        $estado     = $row_cabecerafac["estado"];
        $fecha      = $row_cabecerafac["fecreg"];
        $codrem      = $row_cabecerafac["codrem"];

        // Veo si son cbtes de ventas
        
        //if (($tcomp != 51 && $tcomp != 52 && $tcomp != 53 && $tcomp != 54 && $tcomp != 55 && $tcomp != 56 && $tcomp != 57 && $tcomp != 58 && $tcomp != 59 && $tcomp != 60 && $tcomp != 61 && $tcomp != 62 && $tcomp != 63 && $tcomp != 64 && $tcomp != 89 && $tcomp != 92  && $tcomp != 93 && $tcomp != 94 && $tcomp != 103 && $tcomp != 104 && $tcomp != 105))
        if ($tcomp == 98 || $tcomp == 99)
            continue;

        if ($tcomp ==  57 ||  $tcomp ==  58 || $tcomp == 61 || $tcomp == 62 || $tcomp == 93 || $tcomp == 105) {
            $tc = "NC-";
            $signo = -1;
        }

        else 
            if ($tcomp == 51 || $tcomp == 52 || $tcomp == 53 || $tcomp == 54 || $tcomp == 55 || $tcomp == 56 || $tcomp == 89 || $tcomp == 92 || $tcomp == 103 || $tcomp == 104) {
                $tc = "FC-";
                $signo = 1;
            } else 
                if ($tcomp == 59 || $tcomp == 60 || $tcomp == 63 || $tcomp == 64 || $tcomp == 94) {
                        $tc = "ND-";
                        $signo = 1;
                    }	

        $cliente = $row_cabecerafac["cliente"];
        $total   = $row_cabecerafac["totbruto"] * $signo;
        if ($tc == "FC-" ||	$tc == "ND-") {
            $debito = $total;
            $credito = 0.00;
        }
        else {
            $debito = 0.00;
            $credito = $total;
        }
            // Acumulo subtotales

        $acum_cli     = $acum_cli + $total;
        $acum_total   = $acum_total + $total;
        $total = 0;
        $debito       = number_format($debito, 2, ',','.');
        $credito       = number_format($credito, 2, ',','.');
        $df_acum_total   = number_format($acum_total, 2, ',','.');
        $df_acum_cli   = number_format($acum_cli, 2, ',','.');
        
        $fecha ="'".substr($fecha,8,2)."-".substr($fecha,5,2)."-".substr($fecha,0,4)."'";
        if ($linea < 48 && $linea != 0) {
                //$tot_cli[$j] = number_format($tot_cli[$j], 2, ',','.');
                //$porc_cli[$j] = number_format($porc_cli[$j], 2, ',','.');
                //echo "4 -";

                $pdf->SetY($valor_y);
                $pdf->Cell(1);
                $pdf->SetX(10);
                $pdf->Cell(25,6,$fecha,0,0,'L');
                $pdf->Cell(25,6,$tc.$nrodoc,0,0,'L');
                $pdf->Cell(40,6,$debito,0,0,'R');
                $pdf->Cell(40,6,$credito,0,0,'R');
                $pdf->Cell(40,6,$df_acum_cli,0,0,'R');
                $pdf->Cell(15,6,$codrem,0,0,'C');

                $valor_y = $valor_y + 6;
                $linea++;
        }
        else {
            //echo "5 -";
            $linea = 0;
            $pdf->AddPage();
            $pdf->SetMargins(0.5, 0.5 , 0.5);
            $pdf->SetFont('Arial','',11);
            $pdf->SetY(5);
            $pdf->Cell(10);
            $pdf->Cell(20,10,' ADRIAN MERCADO S.A. ',0,0,'L');
            $pdf->Cell(200);
            $pagina = $pdf->PageNo();
            $pdf->Cell(30,10,'Página : '.$pagina,0,0,'L');
            $pdf->SetY(10);
            $pdf->Cell(230);
            $pdf->Cell(40,10,'Fecha   : '.$fechahoy,0,0,'L');
            $pdf->SetY(15);
            $pdf->Cell(50);
            $pdf->Cell(20,10,utf8_decode(' Resumen de cuenta corriente de ').$razsoc,0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->SetY(25);
            $pdf->Cell(10);
            $pdf->Cell(25,8,'  Fecha   ',1,0,'L');
            $pdf->Cell(25,8,'  Comprobante',1,0,'L');
            $pdf->Cell(40,8,utf8_decode('     Débitos     '),1,0,'L');
            $pdf->Cell(40,8,utf8_decode('    Créditos    '),1,0,'L');
            $pdf->Cell(40,8,'    Saldo    ',1,0,'L');
            $pdf->Cell(15,8,' Remate    ',1,0,'L');

            $valor_y = 45;

            $pdf->SetY($valor_y);
            $pdf->Cell(1);
            $pdf->SetX(10);
            $pdf->Cell(25,6,$fecha,0,0,'L');
            $pdf->Cell(25,6,$tc.$nrodoc,0,0,'L');
            $pdf->Cell(40,6,$debito,0,0,'R');
            $pdf->Cell(40,6,$credito,0,0,'R');
            $pdf->Cell(40,6,$df_acum_cli,0,0,'R');
            $pdf->Cell(15,6,$codrem,0,0,'C');

            $valor_y = $valor_y + 6;
            $linea++;
        }
        if ($estado == 'S') {
            //VOY A BUSCAR EL RECIBO DE PAGO
            $query_detrecibo = sprintf("SELECT ncomp, tcomprel, ncomprel, netocbterel, fechahora FROM detrecibo WHERE  tcomprel = %s AND ncomprel = %s", $tcomp, $ncomp);
            $detrecibo = mysqli_query($amercado, $query_detrecibo) or die(mysqli_error($amercado));
            $row_detrecibo = mysqli_fetch_array($detrecibo);
            if ($row_detrecibo["tcomprel"] == 57 || $row_detrecibo["tcomprel"] == 58 || $row_detrecibo["tcomprel"] == 61 || $row_detrecibo["tcomprel"] == 62 || $row_detrecibo["tcomprel"] == 93 || $row_detrecibo["tcomprel"] == 105
               ) 
                $signo_recibo = 1;
            else
                $signo_recibo = -1;
            $netocbterel = $row_detrecibo["netocbterel"] * $signo_recibo;
            if ($netocbterel == 0)
                continue;
            $debito = 0.00;
            $credito = $netocbterel;
            $fecha_rem = $row_detrecibo["fechahora"];
            $acum_cli     = $acum_cli + $netocbterel;
            $acum_total   = $acum_total + $netocbterel;
            $debito       = number_format($debito, 2, ',','.');
            $credito       = number_format($credito, 2, ',','.');
            $df_acum_cli   = number_format($acum_cli, 2, ',','.');
            $fecha_rem = $row_detrecibo["fechahora"];
            $fecha_rem ="'".substr($fecha_rem,8,2)."-".substr($fecha_rem,5,2)."-".substr($fecha_rem,0,4)."'";
            $tc_recibo = $row_detrecibo["ncomp"];
            if ($linea < 48) {
                //echo "6 -";
                $pdf->SetY($valor_y);
                $pdf->Cell(1);
                $pdf->SetX(10);
                $pdf->Cell(25,6,$fecha,0,0,'L');
                $pdf->Cell(25,6,"Recibo:".$tc_recibo,0,0,'L');
                $pdf->Cell(40,6,$debito,0,0,'R');
                $pdf->Cell(40,6,$credito,0,0,'R');
                $pdf->Cell(40,6,$df_acum_cli,0,0,'R');
                $pdf->Cell(15,6,$codrem,0,0,'C');

                $valor_y = $valor_y + 6;
                $linea++;
            }
            else {
                //echo "7 -";
                $linea = 0;
                $pdf->AddPage();
                $pdf->SetMargins(0.5, 0.5 , 0.5);
                $pdf->SetFont('Arial','',11);
                $pdf->SetY(5);
                $pdf->Cell(10);
                $pdf->Cell(20,10,' ADRIAN MERCADO S.A. ',0,0,'L');
                $pdf->Cell(200);
                $pagina = $pdf->PageNo();
                $pdf->Cell(30,10,'Página : '.$pagina,0,0,'L');
                $pdf->SetY(10);
                $pdf->Cell(230);
                $pdf->Cell(40,10,'Fecha   : '.$fechahoy,0,0,'L');
                $pdf->SetY(15);
                $pdf->Cell(70);
                $pdf->Cell(20,10,utf8_decode(' Resumen de cuenta corriente de ').$razsoc,0,0,'L');
                $pdf->SetFont('Arial','B',9);
                $pdf->SetY(25);
                $pdf->Cell(10);
                $pdf->Cell(25,8,'  Fecha   ',1,0,'L');
                $pdf->Cell(25,8,'  Comprobante',1,0,'L');
                $pdf->Cell(40,8,utf8_decode('     Débitos     '),1,0,'L');
                $pdf->Cell(40,8,utf8_decode('    Créditos    '),1,0,'L');
                $pdf->Cell(40,8,'    Saldo    ',1,0,'L');
                $pdf->Cell(15,8,' Remate    ',1,0,'L');

                $valor_y = 45;

                $pdf->SetY($valor_y);
                $pdf->Cell(1);
                $pdf->SetX(10);
                $pdf->Cell(25,6,$fecha,0,0,'L');
                $pdf->Cell(25,6,"Recibo:".$tc_recibo,0,0,'L');
                $pdf->Cell(40,6,$debito,0,0,'R');
                $pdf->Cell(40,6,$credito,0,0,'R');
                $pdf->Cell(40,6,$df_acum_cli,0,0,'R');
                $pdf->Cell(15,6,$codrem,0,0,'C');

                $valor_y = $valor_y + 6;
                $linea++;
            }
        }	

    }
    //if ($acum_cli == 0)
    //        continue;
    //echo "8 -";
    if ($pri_vez == 0)
        continue;
    if ($linea < 48) {
        $pdf->SetY($valor_y);
        $pdf->Cell(100);
        $pdf->Cell(26,6,"SALDO CLIENTE:  ".$razsoc,0,0,'R');
        $df_acum_cli   = number_format($acum_cli, 2, ',','.');
        $pdf->Cell(26,6,$df_acum_cli,0,0,'R');
        $valor_y = $valor_y + 6;
        $linea++;
        $acum_cli = 0;
        //$pdf->Cell(100,6,"===========================================================================================",0,0,'C');
        $linea++;
        $valor_y = $valor_y + 6;
    }
    else {
        $linea = 0;
        $pdf->AddPage();
        $pdf->SetMargins(0.5, 0.5 , 0.5);
        $pdf->SetFont('Arial','',11);
        $pdf->SetY(5);
        $pdf->Cell(10);
        $pdf->Cell(20,10,' ADRIAN MERCADO S.A. ',0,0,'L');
        $pdf->Cell(200);
        $pagina = $pdf->PageNo();
        $pdf->Cell(30,10,'Página : '.$pagina,0,0,'L');
        $pdf->SetY(10);
        $pdf->Cell(230);
        $pdf->Cell(40,10,'Fecha   : '.$fechahoy,0,0,'L');
        $pdf->SetY(15);
        $pdf->Cell(70);
        $pdf->Cell(20,10,utf8_decode(' Resumen de cuenta corriente de ').$razsoc,0,0,'L');
        $pdf->SetFont('Arial','B',9);
        $pdf->SetY(25);
        $pdf->Cell(10);
        $pdf->Cell(25,8,'  Fecha   ',1,0,'L');
        $pdf->Cell(25,8,'  Comprobante',1,0,'L');
        $pdf->Cell(40,8,utf8_decode('     Débitos     '),1,0,'L');
        $pdf->Cell(40,8,utf8_decode('    Créditos    '),1,0,'L');
        $pdf->Cell(40,8,'    Saldo    ',1,0,'L');
        $pdf->Cell(15,8,' Remate    ',1,0,'L');

        $valor_y = 45;
        $pdf->SetY($valor_y);
        $pdf->Cell(100);
        $pdf->Cell(26,6,"SALDO CLIENTE:  ".$razsoc,0,0,'R');
        $df_acum_cli   = number_format($acum_cli, 2, ',','.');
        $pdf->Cell(26,6,$df_acum_cli,0,0,'R');
        $valor_y = $valor_y + 6;
        $linea++;
        $acum_cli = 0;
        //$pdf->Cell(100,6,"===========================================================================================",0,0,'C');
        $linea++;
        $valor_y = $valor_y + 6;
    }
}
//echo "9 -";
if ($linea < 48) {
    $df_acum_total   = number_format($acum_total, 2, ',','.');
    $pdf->SetY($valor_y + 6);
    $pdf->Cell(50);
    $pdf->Cell(26,6,'SALDO TOTAL CLIENTES:  ',0,0,'R');
    $pdf->Cell(26,6,$df_acum_total,0,0,'R');
}
else {
    $linea = 0;
    $pdf->AddPage();
    $pdf->SetMargins(0.5, 0.5 , 0.5);
    $pdf->SetFont('Arial','',11);
    $pdf->SetY(5);
    $pdf->Cell(10);
    $pdf->Cell(20,10,' ADRIAN MERCADO S.A. ',0,0,'L');
    $pdf->Cell(200);
    $pagina = $pdf->PageNo();
    $pdf->Cell(30,10,'Página : '.$pagina,0,0,'L');
    $pdf->SetY(10);
    $pdf->Cell(230);
    $pdf->Cell(40,10,'Fecha   : '.$fechahoy,0,0,'L');
    $pdf->SetY(15);
    $pdf->Cell(70);
    $pdf->Cell(20,10,utf8_decode(' Resumen de cuenta corriente de ').$razsoc,0,0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->SetY(25);
    $pdf->Cell(10);
    $pdf->Cell(25,8,'  Fecha   ',1,0,'L');
    $pdf->Cell(25,8,'  Comprobante',1,0,'L');
    $pdf->Cell(40,8,utf8_decode('     Débitos     '),1,0,'L');
    $pdf->Cell(40,8,utf8_decode('    Créditos    '),1,0,'L');
    $pdf->Cell(40,8,'    Saldo    ',1,0,'L');
    $pdf->Cell(15,8,' Remate    ',1,0,'L');
    $valor_y = 45;
    $pdf->SetY($valor_y);
    $pdf->Cell(100);

    $df_acum_total   = number_format($acum_total, 2, ',','.');
    $pdf->SetY($valor_y + 6);
    $pdf->Cell(50);
    $pdf->Cell(26,6,'SALDO TOTAL CLIENTES:  ',0,0,'R');
    $pdf->Cell(26,6,$df_acum_total,0,0,'R');
}
mysqli_close($amercado);
//echo " 10 - ".$pagina;
ob_end_clean();
$pdf->Output();
//echo "11 -";
?>