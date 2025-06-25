<?php

require '../conexion/conexion.php';


$Id = $conn->real_escape_string($_POST['Id']);




 $sql= "DELETE FROM miembros WHERE Id=$Id";

if($conn->query($sql)){
    header('Location: ../admin/miembros.php?mensaje=eliminado');
}else{

    header('Location: ../admin/miembros.php?mensaje=error');
    
}





?>