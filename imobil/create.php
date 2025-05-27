<?php
require_once '../includes/db.php';
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $denumire = $_POST['denumire'];
    $adresa = $_POST['adresa'];
    $pret = $_POST['pret'];
    $etaj = $_POST['etaj'];
    $nrCamere = $_POST['nr_camere'];

    // Upload imagine
    $numeImagine = $_FILES['imagine']['name'];
    $tmpImagine = $_FILES['imagine']['tmp_name'];
    $targetDir = "../uploads/";
    $targetFile = $targetDir . basename($numeImagine);

    move_uploaded_file($tmpImagine, $targetFile);

    $stmt = $conn->prepare("INSERT INTO Imobil (DenumireImobil, AdresaImobil, Pret, Etaj, NrCamere, Imagine) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdiss", $denumire, $adresa, $pret, $etaj, $nrCamere, $numeImagine);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<h2>Adaugă Imobil</h2>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="denumire" placeholder="Denumire Imobil" required>
    <input type="text" name="adresa" placeholder="Adresă Imobil" required>
    <input type="number" step="0.01" name="pret" placeholder="Preț" required>
    <input type="number" name="etaj" placeholder="Etaj" required>
    <input type="number" name="nr_camere" placeholder="Număr Camere" required>
    <input type="file" name="imagine" accept="image/*" required>
    <input type="submit" value="Adaugă">
</form>
<?php include '../includes/footer.php'; ?>