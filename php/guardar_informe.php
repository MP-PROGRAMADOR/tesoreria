<?php


require '../conexion/conexion.php';
$directorio = "../documentos/informes/";
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


$descripcion = $conn->real_escape_string($_POST['descripcion']);
$archivo = $conn->real_escape_string($_FILES["archivo"]["name"]);
$dpto = $conn->real_escape_string($_POST['dpto']);
$decreto = $conn->real_escape_string($_POST['decreto']);
// $fechaRegistro = date("Y-m-d H:i:s");

$sql = "INSERT INTO informe (Estado,Descripcion,Archivo,Dpto,Decreto)
    VALUES ('','$descripcion','$archivo','$dpto','$decreto')";
$conn->query($sql);

if($conn->query($sql)){
    $id=$conn->insert_id;

    header('Location: ../users/informes.php?mensaje=insertado'); 
}else{
    header('Location: ../users/informes.php?mensaje=error'); 
}

