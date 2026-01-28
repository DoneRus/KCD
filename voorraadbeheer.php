<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
</html>
<?php
$user = "root";
$password = '';
$dsn = 'mysql:host=localhost;dbname=duurzaam;charset=utf8mb4';
$dbh = new PDO($dsn, $user, $password);

$sql = "SELECT * FROM voorraad ORDER BY id, artikel_id, locatie, aantal, status_id, ingeboekt_op";

echo '<h1>Voorraadbeheer</h1>';
echo '<table border="1">';
echo '<tr><th>ID</th><th>Artikel ID</th><th>Locatie</th><th>Aantal</th><th>Status ID</th><th>Ingeboekt Op</th></tr>';

$stmt = $dbh->prepare($sql);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td table class="table table-striped>' . htmlspecialchars($row['id']) . '</td>';
    echo '<td>' . htmlspecialchars($row['artikel_id']) . '</td>';
    echo '<td>' . htmlspecialchars($row['locatie']) . '</td>';
    echo '<td>' . htmlspecialchars($row['aantal']) . '</td>';
    echo '<td>' . htmlspecialchars($row['status_id']) . '</td>';
    echo '<td /table class="table table-striped>' . htmlspecialchars($row['ingeboekt_op']) . '</td>';
    echo '</tr>';
}

echo '</table>';