<?php
require_once '../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM Imobil WHERE CodImobil = $id");
    header("Location: index.php");
    exit;
} else {
    echo "ID-ul imobilului nu a fost specificat.";
}
