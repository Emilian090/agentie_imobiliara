<?php
require_once 'includes/db.php';
require_once 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Imobile Închiriate</title>
  <link rel="stylesheet" href="css/style.css">
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
  </style>
</head>
<body>

<h2>Imobile incluse în contracte de închiriere</h2>

<table>
  <thead>
    <tr>
      <th>Cod Contract</th>
      <th>Nume Client</th>
      <th>Denumire Imobil</th>
      <th>Adresă</th>
      <th>Data Închiriere</th>
      <th>Termen</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sql = "SELECT c.CodContract, c.NumeClient, c.DataInchiriere, c.TermenInchiriere,
                   i.DenumireImobil, i.AdresaImobil
            FROM ContractInchiriere c
            JOIN Imobil i ON c.CodImobil = i.CodImobil";
    $res = $conn->query($sql);
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['CodContract']}</td>
                    <td>{$row['NumeClient']}</td>
                    <td>{$row['DenumireImobil']}</td>
                    <td>{$row['AdresaImobil']}</td>
                    <td>{$row['DataInchiriere']}</td>
                    <td>{$row['TermenInchiriere']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>Nu există contracte înregistrate.</td></tr>";
    }
    ?>
  </tbody>
</table>

</body>
</html>
