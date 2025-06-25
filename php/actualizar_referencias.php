<?php 

require '../conexion/conexion.php';

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$codigo = $_POST['codigo'];


$sql= "UPDATE  referencias SET Nombre='$nombre', Codigo='$codigo' WHERE Id=$id";


if($conn->query($sql)){
    $id=$conn->insert_id;

    header('Location: ../admin/referencias.php?mensaje=actualizado'); 
}else{
    header('Location: ../admin/referencias.php?mensaje=error');
}