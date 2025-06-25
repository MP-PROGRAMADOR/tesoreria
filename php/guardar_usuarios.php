<?php


require '../conexion/conexion.php';

$nombre= $conn->real_escape_string($_POST['nombre']);
$password= $conn->real_escape_string($_POST['password']);
$departamento= $conn->real_escape_string($_POST['departamento']);
$Tipo_Usuario= $conn->real_escape_string($_POST['Tipo_Usuario']);


$imagen=addslashes(file_get_contents($_FILES['archivo']['tmp_name']));

$passwordHash = password_hash($password, PASSWORD_DEFAULT);


$sql= "INSERT INTO usuarios (Nombre,Pass,Foto,Dpto,Tipo_Usuario)
    VALUES ('$nombre','$passwordHash','$imagen',$departamento,'$Tipo_Usuario')";
   
if($conn->query($sql)){
        $id=$conn->insert_id;

        //guardando la foto
//     $id_insert= $conn->insert_id;
//    if($_FILES["archivo"]["error"]>0){

//     echo ' Error al cargar archivo';


//    } else{

//     $permitidos= array("image/gif", "image/png", "image/jpg");
//     $limite_kb= 200;

//     if(in_array($_FILES['archivo']["type"], $permitidos) && $_FILES["archivo"]["size"] <= $limite_kb * 1024){

//         $ruta = 'files/'.$id_insert.'/';
//         $archivo = $ruta.$_FILES["archivo"]["name"];
//         if(!file_exists($ruta)){
//             mkdir($ruta);    
//         }

//         if(!file_exists($archivo)){
//         $resultado= @move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo);

//         if($resultado){
          
//             header('Location: ../admin/usuarios.php?mensaje=insertado'); 
//         }else{
//             echo "Archivo no Guardado";
//         }

//         }else{
//             echo 'este archivo ya existe';
//         }

//     }else{
//         echo "archivo no permitido o excede el tamaño permitido";
//     }

//    }

header('Location: ../admin/usuarios.php?mensaje=insertado');

    }else{
        header('Location: ../admin/usuarios.php?mensaje=error'); 
    }
    
   




