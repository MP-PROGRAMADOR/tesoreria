<?php 

require '../conexion/conexion.php';

$cod = $conn->real_escape_string($_POST['cod']);
$TipoDoc = $conn->real_escape_string($_POST['TipoDoc']);
$descripcion = $conn->real_escape_string($_POST['descripcion']);
$palabrasClaves = $conn->real_escape_string($_POST['palabrasClaves']);
$fechaFirma = $conn->real_escape_string($_POST['fechaFirma']);
$importe = $conn->real_escape_string($_POST['importe']);
$ref = $conn->real_escape_string($_POST['ref']);
$entrada = $conn->real_escape_string($_POST['selEntrada']);





$sql= "UPDATE  salidas SET TipoDoc='$TipoDoc', PalabrasClaves='$palabrasClaves', FechaFirma='$fechaFirma', Importe='$importe', Referencia='$ref', Entrada='$entrada' WHERE Id=$cod";


if($conn->query($sql)){
    // $id=$conn->insert_id;

    header('Location: ../users/salidas.php?mensaje=actualizado'); 
}else{
    header('Location: ../users/salidas.php?mensaje=error');
}