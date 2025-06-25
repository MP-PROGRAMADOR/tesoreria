<?php


require '../conexion/conexion.php';

$nombre= $conn->real_escape_string($_POST['nombre']);
$departamento= $conn->real_escape_string($_POST['departamento']);

$sql= "INSERT INTO miembros (Nombre,Dpto)
    VALUES ('$nombre','$departamento')";
   
if($conn->query($sql)){
        $id=$conn->insert_id;

        header('Location: ../admin/miembros.php?mensaje=insertado'); 
    }else{
        header('Location: ../admin/miembros.php?mensaje=error'); 
    }
    
   




