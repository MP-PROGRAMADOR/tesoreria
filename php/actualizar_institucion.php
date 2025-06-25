<?php 

require '../conexion/conexion.php';

$id = $_POST['id'];
$nombre = $_POST['nombre'];




$sql= "UPDATE  instituciones SET Nombre='$nombre' WHERE Id=$id";


if($conn->query($sql)){
    $id=$conn->insert_id;

    header('Location: ../admin/instituciones.php?mensaje=actualizado'); 
}else{
    header('Location: ../categorias.php?mensaje=error');
}