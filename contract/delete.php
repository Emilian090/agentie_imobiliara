<?php
require_once '../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM ContractInchiriere WHERE CodContract = $id");
    header("Location: index.php");
    exit;
} else {
    echo "ID-ul contractului nu a fost specificat.";
}
