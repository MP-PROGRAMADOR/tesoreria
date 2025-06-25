<?php 

require '../conexion/conexion.php';

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$departamento = $_POST['departamento'];


$sql= "UPDATE  miembros SET Nombre='$nombre', Dpto='$departamento' WHERE Id=$id";


if($conn->query($sql)){
    $id=$conn->insert_id;

    header('Location: ../admin/miembros.php?mensaje=actualizado'); 
}else{
    header('Location: ../miembros.php?mensaje=error');
}