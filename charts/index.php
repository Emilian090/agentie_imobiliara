<?php
include '../includes/header.php';
include '../includes/db.php';

// Obține filtrele
$inchiriate = $conn->query("SELECT COUNT(DISTINCT CodImobil) AS inchiriate FROM ContractInchiriere")->fetch_assoc()['inchiriate'];
$total = $conn->query("SELECT COUNT(*) AS total FROM Imobil")->fetch_assoc()['total'];
$disponibile = $total - $inchiriate;
$nrCamere = $_GET['nr_camere'] ?? '';
$pretMin = $_GET['pret_min'] ?? '';
$pretMax = $_GET['pret_max'] ?? '';
$etaj = $_GET['etaj'] ?? '';
$termen = $_GET['termen'] ?? '';

// Creează filtrul SQL dinamic
$where = [];
if ($nrCamere !== '') $where[] = "i.NrCamere = " . intval($nrCamere);
if ($pretMin !== '') $where[] = "i.Pret >= " . floatval($pretMin);
if ($pretMax !== '') $where[] = "i.Pret <= " . floatval($pretMax);
if ($etaj !== '') $where[] = "i.Etaj = " . intval($etaj);
if ($termen !== '') $where[] = "c.TermenInchiriere = '" . $conn->real_escape_string($termen) . "'";

$filterSql = $where ? "WHERE " . implode(" AND ", $where) : "";

$sql = "SELECT i.*, c.NumeClient, c.TermenInchiriere
        FROM Imobil i
        LEFT JOIN ContractInchiriere c ON i.CodImobil = c.CodImobil
        $filterSql";

$res = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Statistici Imobile</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    form { max-width: 900px; margin: auto; padding: 20px; }
    table { width: 90%; margin: 20px auto; border-collapse: collapse; }
    th, td { padding: 10px; border: 1px solid #999; text-align: center; }
    th { background-color: #003366; color: white; }
    input[type="number"], select { padding: 5px; margin: 5px; }
    .stats-summary { text-align: center; margin-top: 20px; font-weight: bold; }
  </style>
</head>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Canvas pentru grafic -->
<div style="max-width: 600px; margin: 40px auto;">
  <canvas id="statusChart"></canvas>
</div>

<script>
  const ctx = document.getElementById('statusChart').getContext('2d');
  const statusChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Închiriate', 'Disponibile'],
      datasets: [{
        label: 'Statut Imobile',
        data: [<?= $inchiriate ?>, <?= $disponibile ?>],
        backgroundColor: ['#003366', '#007bff'],
        borderColor: ['#fff', '#fff'],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom'
        },
        title: {
          display: true,
          text: 'Statutul Imobilelor '
        }
      }
    }
  });
</script>

<body>

<h2 style="text-align:center">Statistici și Filtrare Imobile</h2>

<form method="get">
  <label>Nr. Camere:
    <input type="number" name="nr_camere" value="<?= htmlspecialchars($nrCamere) ?>">
  </label>
  <label>Preț minim:
    <input type="number" name="pret_min" value="<?= htmlspecialchars($pretMin) ?>">
  </label>
  <label>Preț maxim:
    <input type="number" name="pret_max" value="<?= htmlspecialchars($pretMax) ?>">
  </label>
  <label>Etaj:
    <input type="number" name="etaj" value="<?= htmlspecialchars($etaj) ?>">
  </label>
  <label>Termen Închiriere:
    <select name="termen">
      <option value="">-- Toate --</option>
      <option value="6 luni" <?= $termen === "6 luni" ? "selected" : "" ?>>6 luni</option>
      <option value="12 luni" <?= $termen === "12 luni" ? "selected" : "" ?>>12 luni</option>
      <option value="18 luni" <?= $termen === "18 luni" ? "selected" : "" ?>>18 luni</option>
      <option value="24 luni" <?= $termen === "24 luni" ? "selected" : "" ?>>24 luni</option>
      <option value="30 luni" <?= $termen === "30 luni" ? "selected" : "" ?>>30 luni</option>
      <option value="36 luni" <?= $termen === "36 luni" ? "selected" : "" ?>>36 luni</option>
    </select>
  </label>
  <button type="submit">Filtrează</button>
</form>

<table>
  <thead>
    <tr>
      <th>Denumire</th>
      <th>Adresă</th>
      <th>Preț</th>
      <th>Etaj</th>
      <th>Nr. Camere</th>
      <th>Client</th>
      <th>Termen</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($res->num_rows > 0): ?>
      <?php while ($row = $res->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['DenumireImobil']) ?></td>
          <td><?= htmlspecialchars($row['AdresaImobil']) ?></td>
          <td><?= number_format($row['Pret'], 2) ?> EUR</td>
          <td><?= $row['Etaj'] ?></td>
          <td><?= $row['NrCamere'] ?></td>
          <td><?= $row['NumeClient'] ?? '—' ?></td>
          <td><?= $row['TermenInchiriere'] ?? '—' ?></td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="7">Nu au fost găsite rezultate pentru filtrele selectate.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<div class="stats-summary">
  <?php
  // Statistici sumare
  $total = $conn->query("SELECT COUNT(*) AS total FROM Imobil")->fetch_assoc()['total'];
  $inchiriate = $conn->query("SELECT COUNT(DISTINCT CodImobil) AS inchiriate FROM ContractInchiriere")->fetch_assoc()['inchiriate'];
  $disponibile = $total - $inchiriate;
  echo "Total Imobile: $total | Închiriate: $inchiriate | Disponibile: $disponibile";
  ?>
</div>

</body>
</html>
