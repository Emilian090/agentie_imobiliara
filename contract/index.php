<?php
include '../includes/header.php';
include '../includes/db.php';

$sql = "SELECT c.*, i.DenumireImobil FROM ContractInchiriere c
        LEFT JOIN Imobil i ON c.CodImobil = i.CodImobil";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Contracte</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    table {
      width: 90%;
      margin: 20px auto;
      border-collapse: collapse;
    }

    th, td {
      padding: 10px;
      border: 1px solid #999;
      text-align: center;
    }

    th {
      background-color: #003366;
      color: white;
    }

    h2 {
      text-align: center;
      margin-top: 30px;
    }

    .top-bar {
      display: flex;
      justify-content: flex-end;
      margin: 20px 5%;
    }

    .add-btn {
      padding: 10px 15px;
      background-color: #003366;
      color: white;
      text-decoration: none;
      font-weight: bold;
      border-radius: 5px;
      transition: background-color 0.3s;
    }

    .add-btn:hover {
      background-color: #001f3f;
    }

    .edit-btn, .delete-btn {
      color: white;
      text-decoration: none;
      font-weight: bold;
      padding: 5px 10px;
      border-radius: 5px;
    }

    .edit-btn {
      background-color: #1e90ff;
    }

    .delete-btn {
      background-color: #ff4444;
    }

    .edit-btn:hover, .delete-btn:hover {
      opacity: 0.85;
    }
  </style>
</head>
<body>

<h2>Lista Contracte de Închiriere</h2>

<div class="top-bar">
    <a href="create.php" class="add-btn">+ Adaugă Contract</a>
</div>

<table>
    <thead>
        <tr>
            <th>Cod</th>
            <th>Nume Client</th>
            <th>Imobil</th>
            <th>Data Închiriere</th>
            <th>Termen</th>
            <th>Acțiuni</th>
        </tr>
    </thead>
    <tbody>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['CodContract'] ?></td>
            <td><?= htmlspecialchars($row['NumeClient']) ?></td>
            <td><?= htmlspecialchars($row['DenumireImobil']) ?></td>
            <td><?= $row['DataInchiriere'] ?></td>
            <td><?= $row['TermenInchiriere'] ?> luni</td>
            <td>
                <a href="edit.php?id=<?= $row['CodContract'] ?>" class="edit-btn">Edit</a>
                <a href="delete.php?id=<?= $row['CodContract'] ?>" class="delete-btn" onclick="return confirm('Ștergi contractul?')">Șterge</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>
</body>
</html>
