<?php
include '../includes/header.php';
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nume = $_POST['nume'];
    $imobil = $_POST['cod_imobil'];
    $data = $_POST['data'];
    $termen = $_POST['termen'];
    $sql = "INSERT INTO ContractInchiriere (NumeClient, CodImobil, DataInchiriere, TermenInchiriere) 
            VALUES ('$nume', '$imobil', '$data', '$termen')";
    $conn->query($sql);
    header('Location: index.php');
}
$imobile = $conn->query("SELECT * FROM Imobil");
?>

<h2>Adaugă Contract de Închiriere</h2>
<form method="post">
    <input type="text" name="nume" placeholder="Nume Client" required>
    <select name="cod_imobil" required>
        <?php while($r = $imobile->fetch_assoc()): ?>
        <option value="<?= $r['CodImobil'] ?>"><?= $r['DenumireImobil'] ?></option>
        <?php endwhile; ?>
    </select>
    <input type="date" name="data" required>
    <input type="number" name="termen" placeholder="Termen (luni)" required>
    <input type="submit" value="Salvează">
</form>

<?php include '../includes/footer.php'; ?>
