<?php
require_once '../includes/db.php';
include '../includes/header.php';
if (!isset($_GET['id'])) {
    die("ID-ul contractului nu este specificat.");
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numeClient = $_POST['nume_client'];
    $codImobil = $_POST['cod_imobil'];
    $dataInchiriere = $_POST['data_inchiriere'];
    $termen = $_POST['termen_inchiriere'];

    $stmt = $conn->prepare("UPDATE ContractInchiriere SET NumeClient=?, CodImobil=?, DataInchiriere=?, TermenInchiriere=? WHERE CodContract=?");
    $stmt->bind_param("sissi", $numeClient, $codImobil, $dataInchiriere, $termen, $id);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

$result = $conn->query("SELECT * FROM ContractInchiriere WHERE CodContract=$id");
$contract = $result->fetch_assoc();
?>

<h2>Editare Contract</h2>
<form method="post">
    <label>Nume Client:</label><input type="text" name="nume_client" value="<?= $contract['NumeClient'] ?>"><br>
    <label>Cod Imobil:</label><input type="number" name="cod_imobil" value="<?= $contract['CodImobil'] ?>"><br>
    <label>Data Închiriere:</label><input type="date" name="data_inchiriere" value="<?= $contract['DataInchiriere'] ?>"><br>
    <label>Termen Închiriere:</label><input type="number" name="termen_inchiriere" value="<?= $contract['TermenInchiriere'] ?>"><br>
    <button type="submit">Salvează</button>
</form>
<?php include '../includes/footer.php'; ?>
