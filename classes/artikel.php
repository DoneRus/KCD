<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <form action="search_results.html" method="GET">
        <input type="text" name="query" placeholder="Search here...">
        <button type="submit">Search</button>
    </form>

<?php
$user = "root";
$password = '';
$dsn = 'mysql:host=localhost;dbname=duurzaam;charset=utf8mb4';
$dbh = new PDO($dsn, $user, $password);

$sql = "SELECT * FROM artikel ORDER BY id, categorie_id, naam, prijs_ex_btw";

echo '<h1>Artikelen</h1>';
echo '<table border="1">';
echo '<tr><th>ID</th><th>categorie ID</th><th>Naam</th><th>Prijs ex btw</th></tr>';

$stmt = $dbh->prepare($sql);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['id']) . '</td>';
    echo '<td>' . htmlspecialchars($row['categorie_id']) . '</td>';
    echo '<td>' . htmlspecialchars($row['naam']) . '</td>';
    echo '<td>' . htmlspecialchars($row['prijs_ex_btw']) . '</td>';
    echo '</tr>';
}

// $sql = "DELETE FROM voorraad ";
// $stmt = $dbh->prepare($sql);
// $stmt->execute();


echo '</table>';
?>
</body>
</html>