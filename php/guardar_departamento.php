<?php


require '../conexion/conexion.php';

$nombre= $conn->real_escape_string($_POST['nombre']);
$telefono= $conn->real_escape_string($_POST['telefono']);
$correo= $conn->real_escape_string($_POST['correo']);
$institucion=$conn->real_escape_string($_POST['institucion']);

    $sql= "INSERT INTO departementos (Nombre,Telefono,Email,Institucion)
    VALUES ('$nombre','$telefono','$correo','$institucion')";
   
    if($conn->query($sql)){
        $id=$conn->insert_id;

        header('Location: ../admin/departamentos.php?mensaje=insertado'); 
    }else{
        header('Location: ../admin/departamentos.php?mensaje=error'); 
    }
    
   




