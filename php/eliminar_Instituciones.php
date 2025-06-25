<?php

require '../conexion/conexion.php';


$Id = $conn->real_escape_string($_POST['Id']);




 $sql= "DELETE FROM instituciones WHERE Id=$Id";

if($conn->query($sql)){
    header('Location: ../admin/instituciones.php?mensaje=eliminado');
}else{

    header('Location: ../admin/instituciones.php?mensaje=error');
    
}





?>