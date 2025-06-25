<?php 

require '../conexion/conexion.php';

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$institucion = $_POST['institucion'];




$sql= "UPDATE  departementos SET Nombre='$nombre', Telefono='$telefono', Email='$correo', Institucion='$institucion' WHERE Id=$id";


if($conn->query($sql)){
    $id=$conn->insert_id;

    header('Location: ../admin/departamentos.php?mensaje=actualizado'); 
}else{
    header('Location: ../departamentos.php?mensaje=error');
}