<?php

require '../conexion/conexion.php';


$Id = $conn->real_escape_string($_POST['Id']);




 $sql= "DELETE FROM usuarios WHERE Id=$Id";

if($conn->query($sql)){
    header('Location: ../admin/usuarios.php?mensaje=eliminado');
}else{

    header('Location: ../admin/usuarios.php?mensaje=error');
    
}





?>