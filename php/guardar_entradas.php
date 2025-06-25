<?php


require '../conexion/conexion.php';
session_start();

$usuario = $_SESSION['codigo'];

$directorio = "../documentos/entradas/";
$archivo = $directorio . basename($_FILES["archivo"]["name"]);
$tipoArchivo = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));

//Validar que es imagen

//validar tamaño imagen
$size = $_FILES["archivo"]["size"];
if ($size < 0) {
    echo "Elija un documento";
} else {
    //validar tipo de imagen
    if ($tipoArchivo == "pdf" || $tipoArchivo == "docx") {
        // se validó el archivo correctamente
        if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo)) {
            echo " El archivo se subio correctamente";
        } else {
            echo "Hubo un error al subir el archivo";
        }
    } else {
        echo "Solo se admiten archivos pdf/docx";
    }
}


$qLastID = "SELECT MAX(entradas.Id) AS Codigo FROM entradas";
$ResultId = mysqli_query($conn, $qLastID);
$arrayId = mysqli_fetch_array($ResultId);
$datoId = $arrayId['Codigo'];
$idLast = $datoId + 1;
$YearActual = date('Y');

$TipoDoc = $conn->real_escape_string($_POST['TipoDoc']);
$descripcion = $conn->real_escape_string($_POST['descripcion']);
$palabrasClaves = $conn->real_escape_string($_POST['palabrasClaves']);
$fechaFirma = $conn->real_escape_string($_POST['fechaFirma']);
$importe = $conn->real_escape_string($_POST['importe']);
$archivo = $conn->real_escape_string($_FILES["archivo"]["name"]);
$institucion = $conn->real_escape_string($_POST['institucion']);
$ref = $conn->real_escape_string($_POST['ref']);
$persFisic = $conn->real_escape_string($_POST['persFisic']);
$numRegistro = $idLast . "-" . $YearActual;
$fechaRegistro = date("Y-m-d");

if ($persFisic != "") {
    $sqlEntrda = "INSERT INTO entradas (NumRegistro,FechaRegistro,TipoDoc,Archivo, Descripcion, PalabrasClaves, FechaFirma, Importe, Referencia, Usuario)
   VALUES ('$numRegistro','$fechaRegistro','$TipoDoc','$archivo','$descripcion','$palabrasClaves','$fechaFirma','$importe','$ref','$usuario')";
    $resultado = mysqli_query($conn, $sqlEntrda);

    $idEntrada = mysqli_insert_id($conn);

    $queryPF = "INSERT INTO personafisica SET NombreCompleto='$persFisic', Entrada='$idEntrada'";
    $resultPF = mysqli_query($conn, $queryPF);

    if ($resultPF) {
        header('Location: ../users/entradas.php?mensaje=insertado');
    } else {
        header('Location: ../users/entradas.php?mensaje=error');
    }
} else if ($institucion != "") {
    $sqlEntrda = "INSERT INTO entradas (NumRegistro,FechaRegistro,TipoDoc,Archivo, Descripcion, PalabrasClaves, FechaFirma, Importe, Referencia, Usuario)
    VALUES ('$numRegistro','$fechaRegistro','$TipoDoc','$archivo','$descripcion','$palabrasClaves','$fechaFirma','$importe','$ref','$usuario')";
    $resultado = mysqli_query($conn, $sqlEntrda);

    $idEntrada = mysqli_insert_id($conn);

    $queryPJ = "INSERT INTO proviene SET Entrada='$idEntrada', Seccion='$institucion'"; 
    $resultPJ = mysqli_query($conn, $queryPJ);

    if ($resultPJ) {
        header('Location: ../users/entradas.php?mensaje=insertado');
    } else {
        header('Location: ../users/entradas.php?mensaje=error');
    }
} else {
    echo "No he recibido nada";
}

// $sql = "INSERT INTO entradas (NumRegistro,FechaRegistro,TipoDoc,Archivo, Descripcion, PalabrasClaves, FechaFirma, Importe, Procedencia, Usuario)
//     VALUES ('$numRegistro','$fechaRegistro','$TipoDoc','$archivo','$descripcion','$palabrasClaves','$fechaFirma','$importe','$institucion','$usuario')";

// if ($conn->query($sql)) {
//     $id = $conn->insert_id;

//     header('Location: ../users/entradas.php?mensaje=insertado');
// } else {
//     header('Location: ../users/entradas.php?mensaje=error');
// }
