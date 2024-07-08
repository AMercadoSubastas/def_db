<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQLI"
# HTTP="true"



  $hostname_amercado = isset($_SERVER['DB_HOSTNAME']) ? $_SERVER['DB_HOSTNAME'] : "vm3.adrianmercado.com.ar";
  $database_amercado = isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : "am_test";
  $username_amercado = isset($_SERVER['DB_USER']) ? $_SERVER['DB_USER'] : "am_test_user";
  $password_amercado = isset($_SERVER['DB_PASSWORD']) ? $_SERVER['DB_PASSWORD'] : "IV20pRY3VkAcIcs";
  
  // Crear conexión
  $amercado = new mysqli($hostname_amercado, $username_amercado, $password_amercado, $database_amercado);
  mysqli_set_charset($amercado, "utf8");





// // Verificar la conexión
// if ($amercado->connect_error) {
//     die("Error en la conexión: " . $amercado->connect_error);
// } else {
//     echo "Conexión exitosa a la base de datos";
// }


?>
