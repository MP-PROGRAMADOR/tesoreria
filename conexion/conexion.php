<?php
$conn = new mysqli("localhost", "root", "", "tesoreria");

/* check connection */
  if (mysqli_connect_errno()) {
      printf("Conexion Fallada: %s\n", mysqli_connect_error());
      exit();
  }
  
  /* change character set to utf8 */
  if (!$conn->set_charset("utf8")) {
      printf("Error al cargar el juego de caracteres utf8: %s\n", $conn->error);
  } else {
    //  printf("Conjunto de caracteres actual: %s\n", $conn->character_set_name());
  }
  
//  $conexion->close();






?>