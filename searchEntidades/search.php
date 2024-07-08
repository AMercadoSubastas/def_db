<?php

$conn = mysqli_connect("localhost", "root", "", "amremate");
 
if($conn === false){
    die("ERROR: No podía conectar. " . mysqli_connect_error());
}
 
if(isset($_REQUEST["term"])){
    $sql = "SELECT * FROM entidades WHERE razsoc LIKE ? AND tipoent = 1";
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        $param_term = $_REQUEST["term"] . '%';
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<p>" . $row["razsoc"] . "</p>";
                }
            } else{
                echo "<p>No se encontraron coincidencias</p>";
            }
        } else{
            echo "ERROR: No se pudo ejecutar $sql. " . mysqli_error($conn);
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);