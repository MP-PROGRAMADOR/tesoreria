

<?php 

require '../conexion/conexion.php';

$id = $_POST['id'];

$q = "DELETE FROM instituciones WHERE Id = $id";
$resul = mysqli_query($conn, $q);


// if ($conn->query($sql)) {
//      $id = $conn->insert_id;
  
//      header('Location: ../campus.php');
// } else {
//     header('Location: ../campus.php');
// }
