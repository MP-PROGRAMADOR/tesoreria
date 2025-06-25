<?php


require '../conexion/conexion.php';

$nombre= $conn->real_escape_string($_POST['nombre']);
$nombre_corto= $conn->real_escape_string($_POST['nombre_corto']);

    $sql= "INSERT INTO instituciones (Nombre,Nombre_Corto)
    VALUES ('$nombre','$nombre_corto')";
   
    if($conn->query($sql)){
        $id=$conn->insert_id;

        header('Location: ../admin/instituciones.php?mensaje=insertado'); 
    }else{
        header('Location: ../admin/instituciones.php?mensaje=error'); 
    }
    
   




