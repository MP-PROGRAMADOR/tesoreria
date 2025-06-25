<?php

require '../conexion/conexion.php';


$Id = $conn->real_escape_string($_POST['Id']);




 $sql= "DELETE FROM departementos WHERE Id=$Id";

if($conn->query($sql)){
    header('Location: ../admin/departamentos.php?mensaje=eliminado');
}else{

    header('Location: ../admin/departamentos.php?mensaje=error');
    
}





?>