<?php 

require '../conexion/conexion.php';

$cod = $conn->real_escape_string($_POST['cod']);
$TipoDoc = $conn->real_escape_string($_POST['TipoDoc']);
$descripcion = $conn->real_escape_string($_POST['descripcion']);
$palabrasClaves = $conn->real_escape_string($_POST['palabrasClaves']);
$fechaFirma = $conn->real_escape_string($_POST['fechaFirma']);
$importe = $conn->real_escape_string($_POST['importe']);
$ref = $conn->real_escape_string($_POST['ref']);





$sql= "UPDATE  entradas SET TipoDoc='$TipoDoc', PalabrasClaves='$palabrasClaves', FechaFirma='$fechaFirma', Importe='$importe', Referencia='$ref' WHERE Id=$cod";


if($conn->query($sql)){
    // $id=$conn->insert_id;

    header('Location: ../users/entradas.php?mensaje=actualizado'); 
}else{
    header('Location: ../users/entradas.php?mensaje=error');
}