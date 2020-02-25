<?php

$host = $_POST["db_host"];
$database = $_POST["db_name"];
$user = $_POST["db_user"];
$password = $_POST["db_password"];

$texto = $_POST["texto"];
$foto = $_POST["ruta_imagen"];
$tiempo = $_POST["tiempo"];

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data_foto = $conn->query("SELECT id FROM modal_info WHERE id = 1");

if($data_foto->num_rows == 0){
    echo "INSERT INTO modal_info(id, directorio_img, txt_info, tiempo) VALUES (1, '" . $foto ."', '" . $texto . "', " . $tiempo .")";

    $insertFoto = "INSERT INTO modal_info(id, directorio_img, txt_info, tiempo) VALUES (1, '" . $foto ."', '" . $texto . "', " . $tiempo .")";

    if (mysqli_query($conn, $insertFoto)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        echo "Error ingresando registro: " . $conn->error;
    }

}else{
    echo "UPDATE modal_info SET directorio_img = '" . $foto . "', txt_info = '" . $texto . "', tiempo = " . $tiempo ." WHERE id = 1";
    $updateFoto = "UPDATE modal_info SET directorio_img = '" . $foto . "', txt_info = '" . $texto . "', tiempo = " . $tiempo ." WHERE id = 1";

    if ($conn->query($updateFoto) === TRUE) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        echo "Error actualizando registro: " . $conn->error;
    }
}

$conn->close();




