<?php
require_once '../includes/db.php';
include '../includes/header.php';
if (!isset($_GET['id'])) {
    die("ID-ul imobilului nu este specificat.");
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $denumire = $_POST['denumire'];
    $adresa = $_POST['adresa'];
    $pret = $_POST['pret'];
    $etaj = $_POST['etaj'];
    $nrCamere = $_POST['nr_camere'];

    $stmt = $conn->prepare("UPDATE Imobil SET DenumireImobil=?, AdresaImobil=?, Pret=?, Etaj=?, NrCamere=? WHERE CodImobil=?");
    $stmt->bind_param("ssdiii", $denumire, $adresa, $pret, $etaj, $nrCamere, $id);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

$result = $conn->query("SELECT * FROM Imobil WHERE CodImobil=$id");
$imobil = $result->fetch_assoc();
?>

<h2>Editare Imobil</h2>
<form method="post">
    <label>Denumire:</label><input type="text" name="denumire" value="<?= $imobil['DenumireImobil'] ?>"><br>
    <label>Adresa:</label><input type="text" name="adresa" value="<?= $imobil['AdresaImobil'] ?>"><br>
    <label>Pret:</label><input type="number" step="0.01" name="pret" value="<?= $imobil['Pret'] ?>"><br>
    <label>Etaj:</label><input type="number" name="etaj" value="<?= $imobil['Etaj'] ?>"><br>
    <label>Nr. Camere:</label><input type="number" name="nr_camere" value="<?= $imobil['NrCamere'] ?>"><br>
    <button type="submit">Salvează</button>
</form>
