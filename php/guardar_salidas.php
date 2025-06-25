<?php


require '../conexion/conexion.php';
session_start();

$usuario = $_SESSION['codigo'];

$directorio = "../documentos/salidas/";
$archivo = $directorio . basename($_FILES["archivo"]["name"]);
$tipoArchivo = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));

//Validar que es imagen

//validar tamaño imagen
$size = $_FILES["archivo"]["size"];
if ($size > 1000000) {
    echo "El Documento pesa mas de 1000000KB";
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


$qLastID = "SELECT MAX(salidas.Id) AS Codigo FROM salidas";
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
$entrada = $conn->real_escape_string($_POST['selEntrada']);
$numRegistro = $idLast . "-" . $YearActual;
$fechaRegistro = date("Y-m-d");

if ($persFisic != "") {
    $sqlEntrda = "INSERT INTO salidas (NumRegistro,FechaRegistro,TipoDoc,Archivo, Descripcion, PalabrasClaves, FechaFirma, Importe, Entrada, Referencia, Usuario)
   VALUES ('$numRegistro','$fechaRegistro','$TipoDoc','$archivo','$descripcion','$palabrasClaves','$fechaFirma','$importe', '$entrada','$ref','$usuario')";
    $resultado = mysqli_query($conn, $sqlEntrda);

    $idSalida = mysqli_insert_id($conn);

    $queryPF = "INSERT INTO personafisica SET NombreCompleto='$persFisic', Salida='$idSalida'";
    $resultPF = mysqli_query($conn, $queryPF);

    if ($resultPF) {
        header('Location: ../users/salidas.php?mensaje=insertado');
    } else {
        header('Location: ../users/salidas.php?mensaje=error');
    }
} else if ($institucion != "") {
    $sqlEntrda = "INSERT INTO salidas (NumRegistro,FechaRegistro,TipoDoc,Archivo, Descripcion, PalabrasClaves, FechaFirma, Importe, Entrada, Referencia, Usuario)
    VALUES ('$numRegistro','$fechaRegistro','$TipoDoc','$archivo','$descripcion','$palabrasClaves','$fechaFirma','$importe', '$entrada', '$ref','$usuario')";
    $resultado = mysqli_query($conn, $sqlEntrda);

    $idSalida = mysqli_insert_id($conn);

    $queryPJ = "INSERT INTO ir SET Salida='$idSalida', Seccion='$institucion'";
    $resultPJ = mysqli_query($conn, $queryPJ);

    if ($resultPJ) {
        header('Location: ../users/salidas.php?mensaje=insertado');
    } else {
        header('Location: ../users/salidas.php?mensaje=error');
    }
} else if ($_POST['instiDepart'] != "") {
    $arregloSeccion = $_POST['instiDepart'];
    $num = count($arregloSeccion);

    $sqlEntrda = "INSERT INTO salidas (NumRegistro,FechaRegistro,TipoDoc,Archivo, Descripcion, PalabrasClaves, FechaFirma, Importe, Entrada, Referencia, Usuario)
    VALUES ('$numRegistro','$fechaRegistro','$TipoDoc','$archivo','$descripcion','$palabrasClaves','$fechaFirma','$importe', '$entrada', '$ref','$usuario')";
        $resultado = mysqli_query($conn, $sqlEntrda);
        $idSalidas = mysqli_insert_id($conn);

    for ($i = 0; $i < $num; $i++) { 
        
        $queryPJVarias = "INSERT INTO ir (Salida, Seccion) VALUES ('$idSalidas','$arregloSeccion[$i]')";
        $resultPJV = mysqli_query($conn, $queryPJVarias);

        if ($resultPJV) {
            header('Location: ../users/salidas.php?mensaje=insertado');
        } else {
            header('Location: ../users/salidas.php?mensaje=error');
        }
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
