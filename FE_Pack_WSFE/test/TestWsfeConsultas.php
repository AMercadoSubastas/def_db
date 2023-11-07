<!doctype html>
<html class="no-js" lang="es">
    <head>
        <meta charset="utf-8">
        <title>Test WebServices de AFIP :: WSAA</title>
        <link rel="stylesheet" href="css/style.css">

    </head>
    <body>
        <h1>Consultas sobre los comprobantes registrados en AFIP</h1>
        <div class="home_link"><a href="index.html" >Home</a></div>

<?php

/**
 * En el archivo php.ini se deben habilitar las siguientes extensiones
 *
 * extension=php_openssl (.dll / .so)
 * extension=php_soap    (.dll / .so)
 *
 */

//Cargando archivo de configuracion
include_once "../config.php";
include_once LIB_PATH."functions.php";


//Cargando modelos de conexion a WebService
include_once MDL_PATH."AfipWsaa.php";
include_once MDL_PATH."AfipWsfev1.php";

//Datos correspondiente a la empresa
    //CUIT (Sin guiones)
    if (!empty($_REQUEST['empresaCuit']))
        $empresaCuit = $_REQUEST['empresaCuit'];
    else
        $empresaCuit  = '20233616126';

    //El alias debe estar mencionado en el nombre de los archivos de certificados y firmas digitales
    if (!empty($_REQUEST['empresaAlias']))
        $empresaAlias = $_REQUEST['empresaAlias'];
    else
        $empresaAlias  = 'ldb';

    if (!empty($_REQUEST['PtoVta']))
        $PtoVta = $_REQUEST['PtoVta'];
    else
        $PtoVta  = '';

    if (!empty($_REQUEST['CbteNro']))
        $CbteNro = $_REQUEST['CbteNro'];
    else
        $CbteNro  = '';
    
    if (!empty($_REQUEST['detalles']))
        $detalles = $_REQUEST['detalles'];
    else
        $detalles  = false;
    
    if (!empty($_REQUEST['CbteTipo']))
        $CbteTipo = $_REQUEST['CbteTipo'];
    else
        $CbteTipo  = 0;

    if (!empty($_REQUEST['ultimo_comprobante_autorizado']))
        $ultimo_comprobante_autorizado = $_REQUEST['ultimo_comprobante_autorizado'];
    else
        $ultimo_comprobante_autorizado  = false;

?>
            <form method="GET" >
                <div class="clearfix">
                    <fieldset>
                        <legend>FECompConsultar</legend>
                        <div class="span12">
                            
                            <div class="span3">
                                <label for="empresaCuit">CUIT</label>
                                <input type="text" id="empresaCuit" name="empresaCuit" value="<?=$empresaCuit?>" size="15" />
                            </div>

                            
                            <div class="span3">
                                <label for="empresaAlias">Alias de certificados</label>
                                <input type="text" id="empresaAlias" name="empresaAlias" value="<?=$empresaAlias?>" size="15" />
                            </div>

                            <div class="span3">
                                <label for="CbteTipo">Tipo de Comprobante</label>
                                <select name="CbteTipo" id="CbteTipo">
                                    <option value="">Seleccionar</option>
                                    <option value="1" <?php echo ($CbteTipo=="1" ? " SELECTED ": ""); ?> >Factura A</option>
                                    <option value="2" <?php echo ($CbteTipo=="2" ? " SELECTED ": ""); ?> >Nota de Debito A</option>
                                    <option value="3" <?php echo ($CbteTipo=="3" ? " SELECTED ": ""); ?> >Nota de Credito A</option>
                                    <option value="6" <?php echo ($CbteTipo=="6" ? " SELECTED ": ""); ?> >Factura B</option>
                                    <option value="7" <?php echo ($CbteTipo=="7" ? " SELECTED ": ""); ?> >Nota de Debito B</option>
                                    <option value="8" <?php echo ($CbteTipo=="8" ? " SELECTED ": ""); ?> >Nota de Credito B</option>
                                </select>
                            </div>
                        </div>
                        <div class="span12">

                            <div class="span2">
                                <label for="PtoVta" >Punto de Venta</label>
                                <input type="text" id="PtoVta" name="PtoVta" value="<?=$PtoVta?>" size="4" />
                            </div>

                            <div class="span2">
                                <label for="CbteNro">Numero de Comprobante</label>
                                <input type="text" id="CbteNro" name="CbteNro" value="<?=$CbteNro?>" size="8" />
                            </div>
                            
                        </div>
                        <div class="span12">

                            <div class="span3">
                                Ver SetUp y WSAA
                                <input type="checkbox" id="detalles" name="detalles" <?php echo ($detalles ? " CHECKED" : ""); ?> />
                            </div>
                            <div class="span3">
                                Ver Ultimo Comprobante
                                <input type="checkbox" id="ultimo_comprobante_autorizado" name="ultimo_comprobante_autorizado" <?php echo ($ultimo_comprobante_autorizado ? " CHECKED" : ""); ?> />
                            </div>
                        </div>

                        <div class="span12" style="display: block;">
                            <div class="clearfix">
                                <button type="submit" >Consultar</button>
                            </div>
                        </div>
                    </fieldset>
                </div>
<?php

if ($empresaCuit && $empresaAlias)
{

    $wsaa = new AfipWsaa('wsfe',$empresaAlias);

    if ($ta = $wsaa->loginCms())
    {

        $token      = $ta['token'];
        $sign       = $ta['sign'];
        $expiration = $ta['expiration'];
        $uniqueid   = $ta['uniqueid'];

        $wsfe = new AfipWsfev1($empresaCuit,$token,$sign);
        
        if ($detalles)
        {
            echo '<h4 >Ticket de Acceso generado <b>'.SERVER_ENTORNO.'</b></h4>';
            pr($ta);
            echo '<h4>WSAA::getSetUp()</h4>';
            pr($wsaa->getSetUp());
        }

        if (intval($CbteNro))
        {
            $ret = $wsfe->FECompConsultar(intval($CbteTipo),intval($CbteNro),intval($PtoVta));
            echo "<h4>AfipWsfev1::FECompConsultar(CbteTipo=".$CbteTipo.",CbteNro=".$CbteNro.",PtoVta=".$PtoVta.")</h4>";
            if ($ret)
            {
                pr($ret);
            }
            else
            {
                echo "<h4>Errores Detectados</h4>";
                pr($wsfe->getErrLog());
            }
        }

        if ($ultimo_comprobante_autorizado) 
        {
            $ret = $wsfe->FECompUltimoAutorizado($PtoVta,$CbteTipo);
            echo "<h4>AfipWsfev1::FECompUltimoAutorizado(PtoVta=".$PtoVta.",CbteTipo=".$CbteTipo.")</h4>";
            if ($ret)
            {
                pr($ret);
            }
            else
            {
                echo "<h4>Errores Detectados</h4>";
                pr($wsfe->getErrLog());
            }
            
        }



        

    }
    else
    {
        echo "<hr/><h4>Errores en el Ticket de Acceso</h4><pre>";
        print_r($wsaa->getErrLog());
        echo "</pre>";
    }

}

?>
            </form>
        </div> <!-- #container-->
    </body>
</html>
