<?php

require_once('Connections/amercado.php'); 


// Verificar si se recibió un valor en la consulta
if(isset($_GET['valor'])) {
    // Obtener el valor seleccionado
    $valor = $_GET['valor'];
    $cliente = $_GET['cliente'];
    
    if ($valor == 1) {
        
        $tcompro = 115;
        $serie = 52;
    }
    if ($valor == 2) {
        
        $tcompro = 122;
        $serie = 52;
    }

// Hago la consulta acá

    $consultaCbte = "SELECT * FROM cabfac WHERE tcomp = '$tcompro' AND serie = '$serie' AND cliente = '$cliente' AND estado = 'P';";
    $query = mysqli_query($amercado, $consultaCbte);


    if (mysqli_num_rows($query) > 0) {
        $opciones = array();
        // Iterar sobre los resultados y agregar opciones
        while ($fila = mysqli_fetch_assoc($query)) {
            $valor = $fila['nrodoc']; // Me muestra el string
            $texto = $fila['totimp']; // Me muestra el importe total

            preg_match('/(\d+)$/', $valor, $matches);
            $numero = ltrim($matches[0], '0'); // Borro los caracteres y ceros

            // Agregar la opción al array de opciones
            $opciones[] = array("valor" => $numero, "texto" => $valor." / ".$texto, "importe" => $texto);
        }
        // Devolver los datos como respuesta en formato JSON
        echo json_encode($opciones);
    } 
}


// REEMISION DE RECIBOS


if(isset($_GET['recibotcomp'])) {
    
    // Obtener el valor seleccionado
    $tcompro = $_GET['recibotcomp'];

    $series = $_GET['serie'];

    

    // Hacer la consulta SQL
    $consultaCbte = "SELECT * FROM detrecibo WHERE tcomp = $tcompro AND serie = $series ORDER BY ncomp DESC;";
    

    // Ejecutar la consulta SQL
    $query = mysqli_query($amercado, $consultaCbte);

    if (mysqli_num_rows($query) > 0) {
        $opciones = array();
        // Iterar sobre los resultados y agregar opciones
        while ($fila = mysqli_fetch_assoc($query)) {
            $ncomp = $fila['ncomp'];
            $nrodoc = $fila['nrodoc']; // Me muestra el string
            $ncomprel = $fila['ncomprel']; // Me muestra el importe total


            // Agregar la opción al array de opciones
            $opciones[] = array("valor" => $ncomp, "texto" => $ncomprel . " - " . $ncomp . " - " . $nrodoc);
        }
        // Devolver los datos como respuesta en formato JSON
        echo trim(json_encode($opciones));
    }
}

 
if(isset($_REQUEST["term"])){
    $sql = "SELECT * FROM entidades WHERE razsoc LIKE ? and activo = 1 and tipoent = 1";
    if($stmt = mysqli_prepare($amercado, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        $param_term = $_REQUEST["term"] . '%';
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            $counter = 0; // Contador para mantener el número de resultados mostrados
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<p>" . $row["cuit"] . " | " . $row["razsoc"] . " | ". $row["codnum"] ."</p>";
                    $counter++;
                    if($counter >= 10){ // Salir del bucle después de mostrar 10 resultados
                        break;
                    }
                }
            } else{
                echo "<p>No se encontraron coincidencias</p>";
            }
        } else{
            echo "ERROR: No se pudo ejecutar $sql. " . mysqli_error($amercado);
        }
    }
    mysqli_stmt_close($stmt);
}




if(isset($_REQUEST["clienteB"])){
    $sql = "SELECT * FROM entidades WHERE razsoc LIKE ? and activo = 1 and tipoent = 1 and (tipoiva = 4 OR tipoiva = 6 OR tipoiva = 5 OR tipoiva = 7);";
    if($stmt = mysqli_prepare($amercado, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        $param_term = $_REQUEST["clienteB"] . '%';
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            $counter = 0; // Contador para mantener el número de resultados mostrados
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<p>" . $row["cuit"] . " | " . $row["razsoc"] . " | ". $row["codnum"] . "</p>";
                    $counter++;
                    if($counter >= 10){ // Salir del bucle después de mostrar 10 resultados
                        break;
                    }
                }
            } else{
                echo "<p>No se encontraron coincidencias</p>";
            }
        } else{
            echo "ERROR: No se pudo ejecutar $sql. " . mysqli_error($amercado);
        }
    }
    mysqli_stmt_close($stmt);
}


if(isset($_REQUEST["clienteA"])){
    $sql = "SELECT * FROM entidades WHERE razsoc LIKE ? and activo = 1 and tipoent = 1 AND (tipoiva = 1 OR tipoiva = 3);";
    if($stmt = mysqli_prepare($amercado, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        $param_term = $_REQUEST["clienteA"] . '%';
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            $counter = 0; // Contador para mantener el número de resultados mostrados
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<p>" . $row["cuit"] . " | " . $row["razsoc"] . "</p>";
                    $counter++;
                    if($counter >= 10){ // Salir del bucle después de mostrar 10 resultados
                        break;
                    }
                }
            } else{
                echo "<p>No se encontraron coincidencias</p>";
            }
        } else{
            echo "ERROR: No se pudo ejecutar $sql. " . mysqli_error($amercado);
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($amercado);