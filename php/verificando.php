
<?php
require '../conexion/conexion.php';

$nombre_usuario =$conn->real_escape_string($_POST['nombre_usuario']) ;
$password =$conn->real_escape_string($_POST['password']) ;

$consulta= "SELECT * FROM usuarios WHERE Nombre='$nombre_usuario'";

$resultado= mysqli_query($conn, $consulta);
$contador=mysqli_num_rows($resultado);

// echo $contador;
//  exit();

if($contador >0){

    while ($row_usuarios = $resultado->fetch_assoc()) { 

        if(password_verify($password, $row_usuarios['Pass'])){
        
        $tipo_user=$row_usuarios['Tipo_Usuario'];

        if($tipo_user="ADMINISTRADOR"){

        
            header('Location: ../admin/index.php');

        }
        elseif($tipo_user="USUARIO"){

            session_start();

            $_SESSION['Nombre']=$_POST['Nombre'];
            header('Location:users/index.php');

        }
        
           
        
        
        }else{
            echo "la contraseña es incorecta";
        }
        
        
        
        }

}else{
    echo "este usuario no existe";
}


?>