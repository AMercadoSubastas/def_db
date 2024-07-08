<?php

set_time_limit(0); // Para evitar el timeout
define('FPDF_FONTPATH','fpdf17/font/');

require('fpdf17/fpdf.php');
//require('numaletras.php');
//Conecto con la  base de datos
require('Connections/amercado.php');
//setlocale (LC_ALL,"spanish");

mysqli_select_db($amercado, $database_amercado);

// Leo los parámetros del formulario anterior
$cli_desde = $_POST['cli_desde'];
$cli_hasta = $_POST['cli_hasta'];
$fecha_hasta    = $_POST['fecha_hasta'];
$fecha_hasta = substr($fecha_hasta,6,4)."-".substr($fecha_hasta,3,2)."-".substr($fecha_hasta,0,2);
$fecha_h = "'".$fecha_hasta."'";
$fecha_hasta = $fecha_h; //$fecha_hasta." 23:59:59";

$fechahoy = date('d-m-Y');

// Leo las cabeceras de facturas

mysqli_select_db($amercado, $database_amercado);
$query_cliente = "SELECT * FROM entidades WHERE tipoent = 1 AND codnum between $cli_desde AND $cli_hasta ORDER BY codnum";//AND codnum between 1 and 14000 ORDER BY  codnum";//codnum = $cliente ";
$cliente_q = mysqli_query($amercado, $query_cliente) or die("ERROR LEYENDO ENTIDADES ");
// Inicio el pdf con los datos de cabecera
$pdf=new FPDF('P','mm','Legal');

$pdf->AddPage();
$pdf->SetMargins(0.5, 0.5 , 0.5);
$pdf->SetFont('Arial','B',10);
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
$pdf->Cell(20,10,utf8_decode(' Resúmen de saldos de cuenta corriente '),0,0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->SetY(25);
$pdf->Cell(10);
$pdf->Cell(25,8,'  Fecha   ',1,0,'L');
$pdf->Cell(25,8,'  Comprobante',1,0,'L');
$pdf->Cell(40,8,utf8_decode('     Débitos     '),1,0,'L');
$pdf->Cell(40,8,utf8_decode('    Créditos    '),1,0,'L');
$pdf->Cell(40,8,'    Saldo    ',1,0,'L');
//$pdf->Cell(15,8,' Remate    ',1,0,'L');
$linea = 0;  
$valor_y = 45;
//$pdf->AddFont('Arial','',10);
$acum_total  = 0.00;
$fecha_desde = '2020-01-01';
//$fecha_desde =  "'".$fecha_desde."'";
//$fecha_h = '2023-12-31';
//echo "FECHA DESDE = ".$fecha_desde." FECHA HASTA = ".$fecha_h." ";
while ($row_cliente = mysqli_fetch_assoc($cliente_q)) {
    $pri_vez = 0;
    $cliente = $row_cliente['codnum'];
    $razsoc = $row_cliente['razsoc'];
    $fecha_desde = '2020-01-01';
    //echo "CLIENTE = ".$cliente." RAZSOC".$razsoc." - ";
    $query_cabfac = sprintf("SELECT * FROM cabfac WHERE cliente = %s AND estado in  ('P','C')  AND fecreg BETWEEN $fecha_desde AND $fecha_h ORDER BY  codnum", $cliente);
    //echo "QUERY_CABFAC = ".$query_cabfac."  ";
    $cabecerafac = mysqli_query($amercado, $query_cabfac) or die("ERROR LEYENDO CABFAC");
    if (mysqli_num_rows($cabecerafac)==0)
        continue;
    // Datos de los renglones
    $i = 0;
    $signo = 1;
    $tc = "";
    $acum_cli    = 0.00;
    $total       = 0.00;


    $acum_cli = 0.00;
    //$linea = 0;
    while($row_cabecerafac = mysqli_fetch_array($cabecerafac, MYSQLI_BOTH))
    {	
        
        $tcomp      = $row_cabecerafac['tcomp'];
        $ncomp      = $row_cabecerafac['ncomp'];
        $totbruto   = $row_cabecerafac['totbruto'];
        
        if ($tcomp == 98 || $tcomp == 99)
            continue;

        if ($tcomp ==  119|  $tcomp ==  120 || $tcomp == 121 || $tcomp == 135 || $tcomp == 137) {
            $tc = "NC-";
            $signo = -1;
        }

        else 
            if ($tcomp == 115 || $tcomp == 116 || $tcomp == 117 || $tcomp == 125 || $tcomp == 126 || $tcomp == 127 || $tcomp == 133 || $tcomp == 134 || $tcomp == 136 || $tcomp == 142) {
                $tc = "FC-";
                $signo = 1;
            } else 
                if ($tcomp == 122 || $tcomp == 123 || $tcomp == 124 || $tcomp == 138 ) {
                        $tc = "ND-";
                        $signo = 1;
                }	

        $cliente = $row_cabecerafac['cliente'];
        $total   = $row_cabecerafac['totbruto'] * $signo;
        // Acumulo subtotales

        $acum_cli     +=  $total;
        $acum_total   +=  $total;
        $total = 0.00;
        if ($linea > 42) {
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
            $pdf->Cell(20,10,utf8_decode(' Resúmen de saldos de cuenta corriente '),0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->SetY(25);
            $pdf->Cell(10);
            $pdf->Cell(25,8,'  Fecha   ',1,0,'L');
            $pdf->Cell(25,8,'  Comprobante',1,0,'L');
            $pdf->Cell(40,8,utf8_decode('     Débitos     '),1,0,'L');
            $pdf->Cell(40,8,utf8_decode('    Créditos    '),1,0,'L');
            $pdf->Cell(40,8,'    Saldo    ',1,0,'L');
            $valor_y = 45;
        }
    } 
    if ($acum_cli == 0)
        continue;
    $pdf->SetY($valor_y);
    $pdf->Cell(100);
    $pdf->Cell(26,6,"SALDO CLIENTE:  ".$razsoc,0,0,'R');
    $df_acum_cli   = number_format($acum_cli, 2, ',','.');
    $pdf->Cell(26,6,$df_acum_cli,0,0,'R');
    $valor_y = $valor_y + 6;
    $linea++;

}
$df_acum_total   = number_format($acum_total, 2, ',','.');
		
$pdf->SetY($valor_y);
$pdf->Cell(128);
$pdf->Cell(26,6,'SALDO TOTAL:  ',0,0,'R');
$pdf->Cell(26,6,$df_acum_total,0,0,'R');

mysqli_close($amercado);
$pdf->Output();

?>