<?php 

require '../conexion/conexion.php';

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$password = $_POST['password'];
$departamento = $_POST['departamento'];
$imagen=addslashes(file_get_contents($_FILES['archivo']['tmp_name']));



$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$sql= "UPDATE  usuarios SET Nombre='$nombre', Pass='$passwordHash',Foto='$imagen', Dpto='$departamento' WHERE Id=$id";


if($conn->query($sql)){
    $id=$conn->insert_id;

    header('Location: ../admin/usuarios.php?mensaje=actualizado'); 
}else{
    header('Location: ../usuarios.php?mensaje=error');
}