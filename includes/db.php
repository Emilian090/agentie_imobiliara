
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "Imobiliar";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}
?>
