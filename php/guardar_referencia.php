<?php


require '../conexion/conexion.php';

$nombre= $conn->real_escape_string($_POST['nombre']);
$codigo= $conn->real_escape_string($_POST['codigo']);

$sql= "INSERT INTO referencias (Nombre,Codigo)
    VALUES ('$nombre','$codigo')";
   
if($conn->query($sql)){
        $id=$conn->insert_id;

        header('Location: ../admin/referencias.php?mensaje=insertado'); 
    }else{
        header('Location: ../admin/referencias.php?mensaje=error'); 
    }
    
   




