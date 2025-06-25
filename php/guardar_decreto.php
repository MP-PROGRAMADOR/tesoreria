<?php


require '../conexion/conexion.php';
$directorio = "../documentos/decretos/";
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
$entradaDoc = $conn->real_escape_string($_POST['entradaDoc']);
$fechaRegistro = date("Y-m-d H:i:s");
$persFisic = $conn->real_escape_string($_POST['persFisic34']);
$persFisic2 = $conn->real_escape_string($_POST['persFisic']);
// $_POST['miembro'] = "";

//mio
$miembro= $_POST['miembro'];


// foreach($miembro as $llave => $valor){

//     echo $valor . "<br>";

// }


// echo $persFisic2;

// exit();


$descripcion;
$archivo;




// $sql = "INSERT INTO decretos (Descripcion,Fecha,Archivo,DocEntrada)
//     VALUES ('$descripcion','$fechaRegistro','$archivo','$entradaDoc')";
// $conn->query($sql);
// $idDecreto = mysqli_insert_id($conn);

if ($persFisic!="") {
    $sql = "INSERT INTO decretos (Descripcion,Fecha,Archivo,DocEntrada)
    VALUES ('$descripcion','$fechaRegistro','$archivo','$entradaDoc')";
    $conn->query($sql);
    $idDecreto = mysqli_insert_id($conn);

    $queryPF = "INSERT INTO personafisica SET NombreCompleto='$persFisic', Decreto='$idDecreto'";
    $resultPF = mysqli_query($conn, $queryPF);

    if ($resultPF) {
        header('Location: ../users/decretos.php?mensaje=insertado');
    } else {
        header('Location: ../users/decretos.php?mensaje=error');
    }
} else if ($miembro!="") {

    foreach($miembro as $llave => $valor){

        $sql = "INSERT INTO decretos (Descripcion,Fecha,Archivo,DocEntrada)
        VALUES ('$descripcion','$fechaRegistro','$archivo','$entradaDoc')";
        $conn->query($sql);
        $idDecreto = mysqli_insert_id($conn);

        /////////////////////////////////////////////////
        $q = "INSERT INTO destino (Miembro, Decreto) VALUES ('$valor','$idDecreto')";
        $qDestino =  mysqli_query($conn, $q);

        if ($qDestino) {
            header('Location: ../users/decretos.php?mensaje=insertado');
        } else {
            header('Location: ../users/decretos.php?mensaje=error');
        }
        
    } 

    // $sql = "INSERT INTO decretos (Descripcion,Fecha,Archivo,DocEntrada)
    // VALUES ('$descripcion','$fechaRegistro','$archivo','$entradaDoc')";
    // $conn->query($sql);
    // $idDecreto = mysqli_insert_id($conn);

    // $arregloMiembro = $_POST['miembro'];
    // $num = count($arregloMiembro);
    // echo $num . "</br>";
    // print_r("Valores: <br>");

    // for ($i = 0; $i < $num; $i++) {
    //     $q = "INSERT INTO destino (Miembro, Decreto) VALUES ('$arregloMiembro[$i]','$idDecreto')";
    //     $qDestino =  mysqli_query($conn, $q);

    //     if ($qDestino) {
    //         header('Location: ../users/decretos.php?mensaje=insertado');
    //     } else {
    //         header('Location: ../users/decretos.php?mensaje=error');
    //     }
    // }
}else if($persFisic2!=""){

    $sql = "INSERT INTO decretos (Descripcion,Fecha,Archivo,DocEntrada)
    VALUES ('$descripcion','$fechaRegistro','$archivo','$entradaDoc')";
    $conn->query($sql);
    $idDecreto = mysqli_insert_id($conn);

    $queryPF = "INSERT INTO personafisica SET NombreCompleto='$persFisic2', Decreto='$idDecreto'";
    $resultPF = mysqli_query($conn, $queryPF);


    foreach($miembro as $llave => $valor){

        $sql = "INSERT INTO decretos (Descripcion,Fecha,Archivo,DocEntrada)
        VALUES ('$descripcion','$fechaRegistro','$archivo','$entradaDoc')";
        $conn->query($sql);
        $idDecreto = mysqli_insert_id($conn);

        /////////////////////////////////////////////////
        $q = "INSERT INTO destino (Miembro, Decreto) VALUES ('$valor','$idDecreto')";
        $qDestino =  mysqli_query($conn, $q);

        if ($qDestino) {
            header('Location: ../users/decretos.php?mensaje=insertado');
        } else {
            header('Location: ../users/decretos.php?mensaje=error');
        }

    }


        
}else {
    echo " /Nada ha sido seleccionado";
}
