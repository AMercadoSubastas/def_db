<?php

namespace PHPMaker2024\Subastas2024;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Slim\Routing\RouteCollectorProxy;
use Slim\App;
use Closure;

// Filter for 'Last Month' (example)
function GetLastMonthFilter($FldExpression, $dbid = "")
{
    $today = getdate();
    $lastmonth = mktime(0, 0, 0, $today['mon'] - 1, 1, $today['year']);
    $val = date("Y|m", $lastmonth);
    $wrk = $FldExpression . " BETWEEN " .
        QuotedValue(DateValue("month", $val, 1, $dbid), DataType::DATE, $dbid) .
        " AND " .
        QuotedValue(DateValue("month", $val, 2, $dbid), DataType::DATE, $dbid);
    return $wrk;
}

// Filter for 'Starts With A' (example)
function GetStartsWithAFilter($FldExpression, $dbid = "")
{
    return $FldExpression . Like("'A%'", $dbid);
}

// Global user functions

// Database Connecting event
function Database_Connecting(&$info)
{
    // Example:
    //var_dump($info);
    //if ($info["id"] == "DB" && IsLocal()) { // Testing on local PC
    //    $info["host"] = "locahost";
    //    $info["user"] = "root";
    //    $info["password"] = "";
    //}
}

// Database Connected event
function Database_Connected($conn)
{
    // Example:
    //if ($conn->info["id"] == "DB") {
    //    $conn->executeQuery("Your SQL");
    //}
}

// Language Load event
function Language_Load()
{
    // Example:
    //$this->setPhrase("MyID", "MyValue"); // Refer to language file for the actual phrase id
    //$this->setPhraseClass("MyID", "fa-solid fa-xxx ew-icon"); // Refer to https://fontawesome.com/icons?d=gallery&m=free [^] for icon name
}

function MenuItem_Adding($item)
{
    //var_dump($item);
    //$item->Allowed = false; // Set to false if menu item not allowed
}

function Menu_Rendering()
{
    // Change menu items here
}

function Menu_Rendered()
{
    // Clean up here
}

// Page Loading event
function Page_Loading()
{
    //Log("Page Loading");
}

function Page_Rendering() {
    // Agregar jQuery
    echo '<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>';

    // Agregar SweetAlert
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
}

// Page Unloaded event
function Page_Unloaded()
{
    //Log("Page Unloaded");
}

// AuditTrail Inserting event
function AuditTrail_Inserting(&$rsnew)
{
    //var_dump($rsnew);
    return true;
}

// Personal Data Downloading event
function PersonalData_Downloading($row)
{
    //Log("PersonalData Downloading");
}

// Personal Data Deleted event
function PersonalData_Deleted($row)
{
    //Log("PersonalData Deleted");
}

// One Time Password Sending event
function Otp_Sending($usr, $client)
{
    // Example:
    // var_dump($usr, $client); // View user and client (Email or SMS object)
    // if (SameText(Config("TWO_FACTOR_AUTHENTICATION_TYPE"), "email")) { // Possible values, email or SMS
    //     $client->Content = ...; // Change content
    //     $client->Recipient = ...; // Change recipient
    //     // return false; // Return false to cancel
    // }
    return true;
}

// Route Action event
function Route_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
    // $app->get('/myaction2', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction2"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
}

// API Action event
function Api_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
    // $app->get('/myaction2', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction2"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
}

// Container Build event
function Container_Build($builder)
{
    // Example:
    // $builder->addDefinitions([
    //    "myservice" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService();
    //    },
    //    "myservice2" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService2();
    //    }
    // ]);
}

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = addslashes($theValue);
  switch ($theType) {
	case "text":
	  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
	  break;    
	case "long":
	case "int":
	  $theValue = ($theValue != "") ? intval($theValue) : "NULL";
	  break;
	case "double":
	  $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
	  break;
	case "date":
	  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
	  break;
	case "defined":
	  $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
	  break;
  }
  return $theValue;
}

 function ValidarDuplicados($rsnew) {
 		$hostname_amercado = isset($_SERVER['DB_HOSTNAME']) ? $_SERVER['DB_HOSTNAME'] : "vm3.adrianmercado.com.ar";
		$database_amercado = isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : "am_test";
		$username_amercado = isset($_SERVER['DB_USER']) ? $_SERVER['DB_USER'] : "am_test_user";
		$password_amercado = isset($_SERVER['DB_PASSWORD']) ? $_SERVER['DB_PASSWORD'] : "IV20pRY3VkAcIcs";

		// LEO LA TABLA SERIES
	$amercado = mysqli_connect($hostname_amercado, $username_amercado, $password_amercado) or trigger_error(mysqli_error($amercado),E_USER_ERROR);

		// BUSCO LOS CAMPOS NECESARIOS PARA VALIDAR
		$cuit     = $rsnew['cuit'];  
		$tipoent  = $rsnew['tipoent'];

		// LEO LA TABLA ENTIDADES
	mysqli_select_db($amercado, $database_amercado);
	$query = sprintf("SELECT * FROM entidades WHERE entidades.cuit = $cuit AND entidades.tipoent = $tipoent");
	$Result = mysqli_query($amercado, $query) or die(mysqli_error($amercado));
	$row_Result = mysqli_fetch_assoc($Result);   
	$activo = 0;                        
	if (mysqli_num_rows($Result) > 0) {  
			 $activo = 1;
	}
	if ($activo == 1) {
		// ACA LE MANDO EL MENSAJE DE ERROR Y NO DEBE GRABAR LA ENTIDAD    
		   return 0;
	}
	return 1;                   
} 

function CopiarFecha($rsnew) {              

		// BUSCO LOS CAMPOS NECESARIOS PARA VALIDAR
		$fecha = $rsnew['fecval'];  
		return $fecha;
}

function EntiDir($rsnew) {
		$hostname_amercado = isset($_SERVER['DB_HOSTNAME']) ? $_SERVER['DB_HOSTNAME'] : "vm3.adrianmercado.com.ar";
		$database_amercado = isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : "am_test";
		$username_amercado = isset($_SERVER['DB_USER']) ? $_SERVER['DB_USER'] : "am_test_user";
		$password_amercado = isset($_SERVER['DB_PASSWORD']) ? $_SERVER['DB_PASSWORD'] : "IV20pRY3VkAcIcs";

		// LEO LA TABLA SERIES
	$amercado = mysqli_connect($hostname_amercado, $username_amercado, $password_amercado) or trigger_error(mysqli_error($amercado),E_USER_ERROR);

		// BUSCO LOS CAMPOS NECESARIOS PARA VALIDAR
		$enti    = $rsnew['cliente'];  

		// LEO LA TABLA ENTIDADES
	mysqli_select_db($amercado, $database_amercado);
	$query = sprintf("SELECT * FROM entidades WHERE entidades.codnum = $enti"); 
	$Result = mysqli_query($amercado, $query) or die(mysqli_error($amercado));
	$row_Result = mysqli_fetch_assoc($Result);   
	$dir = $row_Result['calle'];
	return $dir;
}          

function EntiDnro($rsnew) {
		$hostname_amercado = isset($_SERVER['DB_HOSTNAME']) ? $_SERVER['DB_HOSTNAME'] : "vm3.adrianmercado.com.ar";
		$database_amercado = isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : "am_test";
		$username_amercado = isset($_SERVER['DB_USER']) ? $_SERVER['DB_USER'] : "am_test_user";
		$password_amercado = isset($_SERVER['DB_PASSWORD']) ? $_SERVER['DB_PASSWORD'] : "IV20pRY3VkAcIcs";

		// LEO LA TABLA SERIES
	$amercado = mysqli_connect($hostname_amercado, $username_amercado, $password_amercado) or trigger_error(mysqli_error($amercado),E_USER_ERROR);

		// BUSCO LOS CAMPOS NECESARIOS PARA VALIDAR
		$enti    = $rsnew['cliente'];  

		// LEO LA TABLA ENTIDADES
	mysqli_select_db($amercado, $database_amercado);
	$query = sprintf("SELECT * FROM entidades WHERE entidades.codnum = $enti"); 
	$Result = mysqli_query($amercado, $query) or die(mysqli_error($amercado));
	$row_Result = mysqli_fetch_assoc($Result);   
	$dnro = $row_Result['numero'];
	return $dnro;
}          

function EntiPisodto($rsnew) {
		$hostname_amercado = isset($_SERVER['DB_HOSTNAME']) ? $_SERVER['DB_HOSTNAME'] : "vm3.adrianmercado.com.ar";
		$database_amercado = isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : "am_test";
		$username_amercado = isset($_SERVER['DB_USER']) ? $_SERVER['DB_USER'] : "am_test_user";
		$password_amercado = isset($_SERVER['DB_PASSWORD']) ? $_SERVER['DB_PASSWORD'] : "IV20pRY3VkAcIcs";

		// LEO LA TABLA SERIES
	$amercado = mysqli_connect($hostname_amercado, $username_amercado, $password_amercado) or trigger_error(mysqli_error($amercado),E_USER_ERROR);

		// BUSCO LOS CAMPOS NECESARIOS PARA VALIDAR
		$enti    = $rsnew['cliente'];  

		// LEO LA TABLA ENTIDADES
	mysqli_select_db($amercado, $database_amercado);
	$query = sprintf("SELECT * FROM entidades WHERE entidades.codnum = $enti"); 
	$Result = mysqli_query($amercado, $query) or die(mysqli_error($amercado));
	$row_Result = mysqli_fetch_assoc($Result);   
	$pisodto = $row_Result['pisodto'];
	return $pisodto;
}   

function EntiCodpost($rsnew) {
		$hostname_amercado = isset($_SERVER['DB_HOSTNAME']) ? $_SERVER['DB_HOSTNAME'] : "vm3.adrianmercado.com.ar";
		$database_amercado = isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : "am_test";
		$username_amercado = isset($_SERVER['DB_USER']) ? $_SERVER['DB_USER'] : "am_test_user";
		$password_amercado = isset($_SERVER['DB_PASSWORD']) ? $_SERVER['DB_PASSWORD'] : "IV20pRY3VkAcIcs";

		// LEO LA TABLA SERIES
	$amercado = mysqli_connect($hostname_amercado, $username_amercado, $password_amercado) or trigger_error(mysqli_error($amercado),E_USER_ERROR);

		// BUSCO LOS CAMPOS NECESARIOS PARA VALIDAR
		$enti    = $rsnew['cliente'];  

		// LEO LA TABLA ENTIDADES
	mysqli_select_db($amercado, $database_amercado);
	$query = sprintf("SELECT * FROM entidades WHERE entidades.codnum = $enti"); 
	$Result = mysqli_query($amercado, $query) or die(mysqli_error($amercado));
	$row_Result = mysqli_fetch_assoc($Result);   
	$codpost = $row_Result['codpost'];
	return $codpost;
}           

function EntiCodpais($rsnew) {
		$hostname_amercado = isset($_SERVER['DB_HOSTNAME']) ? $_SERVER['DB_HOSTNAME'] : "vm3.adrianmercado.com.ar";
		$database_amercado = isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : "am_test";
		$username_amercado = isset($_SERVER['DB_USER']) ? $_SERVER['DB_USER'] : "am_test_user";
		$password_amercado = isset($_SERVER['DB_PASSWORD']) ? $_SERVER['DB_PASSWORD'] : "IV20pRY3VkAcIcs";

		// LEO LA TABLA SERIES
	$amercado = mysqli_connect($hostname_amercado, $username_amercado, $password_amercado) or trigger_error(mysqli_error($amercado),E_USER_ERROR);

		// BUSCO LOS CAMPOS NECESARIOS PARA VALIDAR
		$enti    = $rsnew['cliente'];  

		// LEO LA TABLA ENTIDADES
	mysqli_select_db($amercado, $database_amercado);
	$query = sprintf("SELECT * FROM entidades WHERE entidades.codnum = $enti"); 
	$Result = mysqli_query($amercado, $query) or die(mysqli_error($amercado));
	$row_Result = mysqli_fetch_assoc($Result);   
	$codpais = $row_Result['codpais'];
	return $codpais;
}     

function EntiCodprov($rsnew) {
		$hostname_amercado = isset($_SERVER['DB_HOSTNAME']) ? $_SERVER['DB_HOSTNAME'] : "vm3.adrianmercado.com.ar";
		$database_amercado = isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : "am_test";
		$username_amercado = isset($_SERVER['DB_USER']) ? $_SERVER['DB_USER'] : "am_test_user";
		$password_amercado = isset($_SERVER['DB_PASSWORD']) ? $_SERVER['DB_PASSWORD'] : "IV20pRY3VkAcIcs";

		// LEO LA TABLA SERIES
	$amercado = mysqli_connect($hostname_amercado, $username_amercado, $password_amercado) or trigger_error(mysqli_error($amercado),E_USER_ERROR);

		// BUSCO LOS CAMPOS NECESARIOS PARA VALIDAR
		$enti    = $rsnew['cliente'];  

		// LEO LA TABLA ENTIDADES
	mysqli_select_db($amercado, $database_amercado);
	$query = sprintf("SELECT * FROM entidades WHERE entidades.codnum = $enti"); 
	$Result = mysqli_query($amercado, $query) or die(mysqli_error($amercado));
	$row_Result = mysqli_fetch_assoc($Result);   
	$codprov = $row_Result['codprov'];
	return $codprov;
}     

function EntiCodloc($rsnew) {
		$hostname_amercado = isset($_SERVER['DB_HOSTNAME']) ? $_SERVER['DB_HOSTNAME'] : "vm3.adrianmercado.com.ar";
		$database_amercado = isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : "am_test";
		$username_amercado = isset($_SERVER['DB_USER']) ? $_SERVER['DB_USER'] : "am_test_user";
		$password_amercado = isset($_SERVER['DB_PASSWORD']) ? $_SERVER['DB_PASSWORD'] : "IV20pRY3VkAcIcs";

		// LEO LA TABLA SERIES
	$amercado = mysqli_connect($hostname_amercado, $username_amercado, $password_amercado) or trigger_error(mysqli_error($amercado),E_USER_ERROR);

		// BUSCO LOS CAMPOS NECESARIOS PARA VALIDAR
		$enti    = $rsnew['cliente'];  

		// LEO LA TABLA ENTIDADES
	mysqli_select_db($amercado, $database_amercado);
	$query = sprintf("SELECT * FROM entidades WHERE entidades.codnum = $enti"); 
	$Result = mysqli_query($amercado, $query) or die(mysqli_error($amercado));
	$row_Result = mysqli_fetch_assoc($Result);   
	$codloc = $row_Result['codloc'];
	return $codloc;
}     

function EntiTipoiva($rsnew) {
		$hostname_amercado = isset($_SERVER['DB_HOSTNAME']) ? $_SERVER['DB_HOSTNAME'] : "vm3.adrianmercado.com.ar";
		$database_amercado = isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : "am_test";
		$username_amercado = isset($_SERVER['DB_USER']) ? $_SERVER['DB_USER'] : "am_test_user";
		$password_amercado = isset($_SERVER['DB_PASSWORD']) ? $_SERVER['DB_PASSWORD'] : "IV20pRY3VkAcIcs";

		// LEO LA TABLA SERIES
	$amercado = mysqli_connect($hostname_amercado, $username_amercado, $password_amercado) or trigger_error(mysqli_error($amercado),E_USER_ERROR);

		// BUSCO LOS CAMPOS NECESARIOS PARA VALIDAR
		$enti    = $rsnew['cliente'];  

		// LEO LA TABLA ENTIDADES
	mysqli_select_db($amercado, $database_amercado);
	$query = sprintf("SELECT * FROM entidades WHERE entidades.codnum = $enti"); 
	$Result = mysqli_query($amercado, $query) or die(mysqli_error($amercado));
	$row_Result = mysqli_fetch_assoc($Result);   
	$tipoiva = $row_Result['tipoiva'];
	return $tipoiva;
}

function EntiCuit($rsnew) {        
			$hostname_amercado = isset($_SERVER['DB_HOSTNAME']) ? $_SERVER['DB_HOSTNAME'] : "vm3.adrianmercado.com.ar";
		$database_amercado = isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : "am_test";
		$username_amercado = isset($_SERVER['DB_USER']) ? $_SERVER['DB_USER'] : "am_test_user";
		$password_amercado = isset($_SERVER['DB_PASSWORD']) ? $_SERVER['DB_PASSWORD'] : "IV20pRY3VkAcIcs";

		// LEO LA TABLA SERIES
	$amercado = mysqli_connect($hostname_amercado, $username_amercado, $password_amercado) or trigger_error(mysqli_error($amercado),E_USER_ERROR);
		// BUSCO LOS CAMPOS NECESARIOS PARA VALIDAR
		$enti    = $rsnew['cliente'];  

		// LEO LA TABLA ENTIDADES
	mysqli_select_db($amercado, $database_amercado);
	$query = sprintf("SELECT * FROM entidades WHERE entidades.codnum = $enti"); 
	$Result = mysqli_query($amercado, $query) or die(mysqli_error($amercado));
	$row_Result = mysqli_fetch_assoc($Result);   
	$cuit = $row_Result['cuit'];
	return $cuit;
}          

function BuscoUltimoSerie($rsnew) {
				$hostname_amercado = isset($_SERVER['DB_HOSTNAME']) ? $_SERVER['DB_HOSTNAME'] : "vm3.adrianmercado.com.ar";
		$database_amercado = isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : "am_test";
		$username_amercado = isset($_SERVER['DB_USER']) ? $_SERVER['DB_USER'] : "am_test_user";
		$password_amercado = isset($_SERVER['DB_PASSWORD']) ? $_SERVER['DB_PASSWORD'] : "IV20pRY3VkAcIcs";

		// LEO LA TABLA SERIES
	$amercado = mysqli_connect($hostname_amercado, $username_amercado, $password_amercado) or trigger_error(mysqli_error($amercado),E_USER_ERROR);
		// BUSCO LOS CAMPOS NECESARIOS PARA VALIDAR
		$serie    = $rsnew['serie'];  

		// LEO LA TABLA SERIES
	mysqli_select_db($amercado, $database_amercado);
	$query = sprintf("SELECT * FROM series WHERE series.codnum = $serie"); 
	$Result = mysqli_query($amercado, $query) or die(mysqli_error($amercado));
	$row_Result = mysqli_fetch_assoc($Result);   
	$nroact = $row_Result['nroact'];
	return $nroact + 1;
}

function CambioUltimoSerie($rsnew) {
		$hostname_amercado = isset($_SERVER['DB_HOSTNAME']) ? $_SERVER['DB_HOSTNAME'] : "vm3.adrianmercado.com.ar";
		$database_amercado = isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : "am_test";
		$username_amercado = isset($_SERVER['DB_USER']) ? $_SERVER['DB_USER'] : "am_test_user";
		$password_amercado = isset($_SERVER['DB_PASSWORD']) ? $_SERVER['DB_PASSWORD'] : "IV20pRY3VkAcIcs";

		// LEO LA TABLA SERIES
	$amercado = mysqli_connect($hostname_amercado, $username_amercado, $password_amercado) or trigger_error(mysqli_error($amercado),E_USER_ERROR);

		// BUSCO LOS CAMPOS NECESARIOS PARA VALIDAR
		$serie    = $rsnew['serie'];  

		// LEO LA TABLA SERIES
	mysqli_select_db($amercado, $database_amercado);
	$query = sprintf("SELECT * FROM series WHERE series.codnum = $serie"); 
	$Result = mysqli_query($amercado, $query) or die(mysqli_error($amercado));
	$row_Result = mysqli_fetch_assoc($Result);   
	$nroact = $row_Result['nroact'] + 1;
	// ACTUALIZO EL ULTIMO NRO DE LA serie
	$query2 = sprintf("UPDATE SERIES SET nroact = $nroact WHERE series.codnum = $serie");
	$Result2 = mysqli_query($amercado, $query2) or die(mysqli_error($amercado));
}

function CambioClienteRemate($rsnew) {
		$hostname_amercado = isset($_SERVER['DB_HOSTNAME']) ? $_SERVER['DB_HOSTNAME'] : "vm3.adrianmercado.com.ar";
		$database_amercado = isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : "am_test";
		$username_amercado = isset($_SERVER['DB_USER']) ? $_SERVER['DB_USER'] : "am_test_user";
		$password_amercado = isset($_SERVER['DB_PASSWORD']) ? $_SERVER['DB_PASSWORD'] : "IV20pRY3VkAcIcs";

		// LEO LA TABLA SERIES
	$amercado = mysqli_connect($hostname_amercado, $username_amercado, $password_amercado) or trigger_error(mysqli_error($amercado),E_USER_ERROR);

		// BUSCO LOS CAMPOS NECESARIOS PARA VALIDAR
		$ncomp    = $rsnew['id'];
		$cliente  = $rsnew['vendedor'];

		// LEO LA TABLA SERIES
	mysqli_select_db($amercado, $database_amercado);

	// ACTUALIZO EL CLIENTE DEL REMATE
	$query2 = sprintf("UPDATE REMATES SET codcli = $cliente WHERE remates.ncomp = $ncomp");
	$Result2 = mysqli_query($amercado, $query2) or die("NO PUEDO REGRABAR EL REMATE ".$query2." - ");
}

function BuscoFechaRemate($rsnew) {
		$hostname_amercado = isset($_SERVER['DB_HOSTNAME']) ? $_SERVER['DB_HOSTNAME'] : "vm3.adrianmercado.com.ar";
		$database_amercado = isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : "am_test";
		$username_amercado = isset($_SERVER['DB_USER']) ? $_SERVER['DB_USER'] : "am_test_user";
		$password_amercado = isset($_SERVER['DB_PASSWORD']) ? $_SERVER['DB_PASSWORD'] : "IV20pRY3VkAcIcs";

		// LEO LA TABLA SERIES
	$amercado = mysqli_connect($hostname_amercado, $username_amercado, $password_amercado) or trigger_error(mysqli_error($amercado),E_USER_ERROR);

		// BUSCO LOS CAMPOS NECESARIOS PARA VALIDAR
		$remate    = $rsnew['ncomp'];  

		// LEO LA TABLA SERIES
	mysqli_select_db($amercado, $database_amercado);
	$query = sprintf("SELECT * FROM remates WHERE remates.ncomp = $remate"); 
	$Result = mysqli_query($amercado, $query) or die(mysqli_error($amercado));
	$row_Result = mysqli_fetch_assoc($Result);   
	$fecharem = $row_Result['fecreal'];
	return $fecharem;
}

function FechaTopeRemate($rsnew) {
		$hostname_amercado = isset($_SERVER['DB_HOSTNAME']) ? $_SERVER['DB_HOSTNAME'] : "vm3.adrianmercado.com.ar";
		$database_amercado = isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : "am_test";
		$username_amercado = isset($_SERVER['DB_USER']) ? $_SERVER['DB_USER'] : "am_test_user";
		$password_amercado = isset($_SERVER['DB_PASSWORD']) ? $_SERVER['DB_PASSWORD'] : "IV20pRY3VkAcIcs";

		// LEO LA TABLA SERIES
	$amercado = mysqli_connect($hostname_amercado, $username_amercado, $password_amercado) or trigger_error(mysqli_error($amercado),E_USER_ERROR);

		// BUSCO LOS CAMPOS NECESARIOS PARA VALIDAR
		$remate    = $rsnew['ncomp'];  

		// LEO LA TABLA SERIES
	mysqli_select_db($amercado, $database_amercado);
	$query = sprintf("SELECT * FROM remates WHERE remates.ncomp = $remate"); 
	$Result = mysqli_query($amercado, $query) or die(mysqli_error($amercado));
	$row_Result = mysqli_fetch_assoc($Result);   
	$fecharem = $row_Result['fecreal'];
	$month = date('m');
	$year = date('Y');
	$ult_dia = date("d",(mktime(0,0,0,$month+1,1,$year)-1));
	//echo "A VERRRRR    = ".$ult_dia."    ";
	$ult_dia_mes = date('Y-m')."-".$ult_dia;
	$FechaTope = $ult_dia_mes; 
	return $FechaTope;
}

function ArmoNrodoc($rsnew) {
				$hostname_amercado = isset($_SERVER['DB_HOSTNAME']) ? $_SERVER['DB_HOSTNAME'] : "vm3.adrianmercado.com.ar";
		$database_amercado = isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : "am_test";
		$username_amercado = isset($_SERVER['DB_USER']) ? $_SERVER['DB_USER'] : "am_test_user";
		$password_amercado = isset($_SERVER['DB_PASSWORD']) ? $_SERVER['DB_PASSWORD'] : "IV20pRY3VkAcIcs";

		// LEO LA TABLA SERIES
	$amercado = mysqli_connect($hostname_amercado, $username_amercado, $password_amercado) or trigger_error(mysqli_error($amercado),E_USER_ERROR);
		// BUSCO LOS CAMPOS NECESARIOS PARA VALIDAR
		$serie    = $rsnew['serie'];
		$numero   = $rsnew['ncomp'];

		// LEO LA TABLA SERIES
	mysqli_select_db($amercado, $database_amercado);
	$query = sprintf("SELECT * FROM series WHERE series.codnum = $serie"); 
	$Result = mysqli_query($amercado, $query) or die(mysqli_error($amercado));
	$row_Result = mysqli_fetch_assoc($Result);   
	$mascara = $row_Result['mascara'];
	//ARMO EL NRODOC CON LA mascara Y EL NUMERO
	 if ($numero <10) {
	 	$mascara=$mascara."-"."0000000".$numero ;
	 }
	 if ($numero >9 && $numero <=99) {
	 	$mascara=$mascara."-"."000000".$numero;
	 }
	 if ($numero >99 && $numero <=999) {
	 	$mascara=$mascara."-"."00000".$numero;
	 }
	 if ($numero >999 && $numero <=9999) {
	 	$mascara=$mascara."-"."0000".$numero;
	 }
	 if ($numero >9999 && $numero <99999) {
	 	$mascara=$mascara."-"."000".$numero;
	 }
	 return $mascara;
}

function LiqCalcTotRemate($rsnew) {
	$totremate = 0.00;
return $totremate;
}

function LiqCalcTotNeto105($rsnew) {
	$totneto105 = 0.00;
return $totneto105;
}

function LiqCalcTotNeto21($rsnew) {
	$totneto21 = 0.00;
return $totneto21;
}

function LiqCalcTotIva105($rsnew) {
	$totiva105 = 0.00;
return $totiva105;
}

function LiqCalcTotIva21($rsnew) {
	$totiva21 = 0.00;
return $totiva21;
}

function LiqCalcSubTot105($rsnew) {
	$subtot105 = 0.00;
return $subtot105;
}

function LiqCalcSubTot21($rsnew) {
	$subtot21 = 0.00;
return $subtot21;
}

function LiqCalcTotAcuenta($rsnew) {
	$totacuenta = 0.00;
return $totacuenta;
}

function LiqCalcTotGastos($rsnew) {
	$totgastos = 0.00;
return $totgastos;
}

function LiqCalcTotVarios($rsnew) {
	$totvarios = 0.00;
return $totvarios;
}

function LiqCalcSaldoafav($rsnew) {
	$saldoafav = 0.00;
return $saldoafav;
}

function BuscoSecuenciaLotes($rsnew) {
		$hostname_amercado = isset($_SERVER['DB_HOSTNAME']) ? $_SERVER['DB_HOSTNAME'] : "vm3.adrianmercado.com.ar";
		$database_amercado = isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : "am_test";
		$username_amercado = isset($_SERVER['DB_USER']) ? $_SERVER['DB_USER'] : "am_test_user";
		$password_amercado = isset($_SERVER['DB_PASSWORD']) ? $_SERVER['DB_PASSWORD'] : "IV20pRY3VkAcIcs";

		// LEO LA TABLA SERIES
	$amercado = mysqli_connect($hostname_amercado, $username_amercado, $password_amercado) or trigger_error(mysqli_error($amercado),E_USER_ERROR);
		$remate = $rsnew['codrem'];
		// LEO LA TABLA LOTES
		$i = 0;

	// VERIFICO QUE NO EXISTA ESTA SECUENCIA POR SI BORRARON ALGUN LOTE
	mysqli_select_db($amercado, $database_amercado);
	$query = sprintf("SELECT * FROM lotes WHERE lotes.codrem = $remate order by codrem, secuencia");
	$Result = mysqli_query($amercado, $query) or die(mysqli_error($amercado));
	//$row_Result = mysqli_fetch_assoc($Result);
	while($row_Result = mysqli_fetch_array($Result)) {   
		$i = $row_Result['secuencia'] + 1;
	}
	return $i;
}

function BuscoNuevoRemate($rsnew) {
		$hostname_amercado = isset($_SERVER['DB_HOSTNAME']) ? $_SERVER['DB_HOSTNAME'] : "vm3.adrianmercado.com.ar";
		$database_amercado = isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : "am_test";
		$username_amercado = isset($_SERVER['DB_USER']) ? $_SERVER['DB_USER'] : "am_test_user";
		$password_amercado = isset($_SERVER['DB_PASSWORD']) ? $_SERVER['DB_PASSWORD'] : "IV20pRY3VkAcIcs";

		// LEO LA TABLA SERIES
	$amercado = mysqli_connect($hostname_amercado, $username_amercado, $password_amercado) or trigger_error(mysqli_error($amercado),E_USER_ERROR);

				// BUSCO LOS CAMPOS NECESARIOS PARA VALIDAR
		$serie_remate    = 4;
		// LEO SERIES PARA SACAR EL ULTIMO NRO
	mysqli_select_db($amercado, $database_amercado);
	$query_series = sprintf("SELECT * FROM series WHERE series.codnum = $serie_remate");
	$Result_series = mysqli_query($amercado, $query_series) or die(mysqli_error($amercado));
	$row_Result_series = mysqli_fetch_assoc($Result_series);   
	$remate = $row_Result_series['nroact'];
	$remate += 1;
	$actualizar = "UPDATE `series` SET `nroact`='$remate' WHERE series.codnum = $serie_remate";
	$resultado = mysqli_query($amercado, $actualizar);
	return $remate;
}

function SeparoNroLote($rsnew) {
		$codintlote   = $rsnew['codintlote'];
		$partes = preg_split("/(,?\s+)|((?<=[a-z])(?=\d))|((?<=\d)(?=[a-z]))/i", $codintlote);
		$numero = $partes[1];
		$letra  = $partes[2];
	return $numero;
}

function SeparoLetraLote($rsnew) {
		$codintlote   = $rsnew['codintlote'];
		$partes = preg_split("/(,?\s+)|((?<=[a-z])(?=\d))|((?<=\d)(?=[a-z]))/i", $codintlote);
		$numero = $partes[1];
		$letra  = $partes[2];
	return $letra;
}

function cogerUsuario(){
    session_start();
    $cod_usuario = $_SESSION['id'];
    return $cod_usuario;
}

// Add listeners
AddListener(DatabaseConnectingEvent::NAME, fn(DatabaseConnectingEvent $event) => Database_Connecting($event));
AddListener(DatabaseConnectedEvent::NAME, fn(DatabaseConnectedEvent $event) => Database_Connected($event->getConnection()));
AddListener(LanguageLoadEvent::NAME, fn(LanguageLoadEvent $event) => Closure::fromCallable(PROJECT_NAMESPACE . "Language_Load")->bindTo($event->getLanguage())());
AddListener(MenuItemAddingEvent::NAME, fn(MenuItemAddingEvent $event) => Closure::fromCallable(PROJECT_NAMESPACE . "MenuItem_Adding")->bindTo($event->getMenu())($event->getMenuItem()));
AddListener(MenuRenderingEvent::NAME, fn(MenuRenderingEvent $event) => Closure::fromCallable(PROJECT_NAMESPACE . "Menu_Rendering")->bindTo($event->getMenu())($event->getMenu()));
AddListener(MenuRenderedEvent::NAME, fn(MenuRenderedEvent $event) => Closure::fromCallable(PROJECT_NAMESPACE . "Menu_Rendered")->bindTo($event->getMenu())($event->getMenu()));
AddListener(PageLoadingEvent::NAME, fn(PageLoadingEvent $event) => Closure::fromCallable(PROJECT_NAMESPACE . "Page_Loading")->bindTo($event->getPage())());
AddListener(PageRenderingEvent::NAME, fn(PageRenderingEvent $event) => Closure::fromCallable(PROJECT_NAMESPACE . "Page_Rendering")->bindTo($event->getPage())());
AddListener(PageUnloadedEvent::NAME, fn(PageUnloadedEvent $event) => Closure::fromCallable(PROJECT_NAMESPACE . "Page_Unloaded")->bindTo($event->getPage())());
AddListener(RouteActionEvent::NAME, fn(RouteActionEvent $event) => Route_Action($event->getApp()));
AddListener(ApiActionEvent::NAME, fn(ApiActionEvent $event) => Api_Action($event->getApp()));
AddListener(ContainerBuildEvent::NAME, fn(ContainerBuildEvent $event) => Container_Build($event->getBuilder()));

// Dompdf
AddListener(ConfigurationEvent::NAME, function (ConfigurationEvent $event) {
    $event->import([
        "PDF_BACKEND" => "CPDF",
        "PDF_STYLESHEET_FILENAME" => "css/ewpdf.css", // Export PDF CSS styles
        "PDF_MEMORY_LIMIT" => "128M", // Memory limit
        "PDF_TIME_LIMIT" => 120, // Time limit
        "PDF_MAX_IMAGE_WIDTH" => 650, // Make sure image width not larger than page width or "infinite table loop" error
        "PDF_MAX_IMAGE_HEIGHT" => 900, // Make sure image height not larger than page height or "infinite table loop" error
        "PDF_IMAGE_SCALE_FACTOR" => 1.53, // Scale factor
    ]);
});

// PhpSpreadsheet
AddListener(ConfigurationEvent::NAME, function (ConfigurationEvent $event) {
    $event->import([
        "USE_PHPEXCEL" => true,
        "EXPORT_EXCEL_FORMAT" => "Excel5",
    ]);
});
