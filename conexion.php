<?php
$conn = new mysqli("localhost", "root", "", "steven_academy");
if($conn->connect_error){
    die("Error de conexión: " . $conn->connect_error);
}
?>