<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<!-- Navigatiebalk voor het admin paneel -->
    <nav class="navbar">
        <ul class="nav-links">
            <!-- Terug naar home -->
            <li><a href="index.php">Centrum Duurzaam</a></li>
        
<!-- Alle menu items beschikbaar voor geautoriseerde gebruikers -->
            <li class="dropdown">
                <!-- Naar ritten -->
                <a href="ritten.php" class="dropbtn">Ritten</a>
                <div class="dropdown-content">
                    <a href="#">Link 1</a>
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                </div>
                <li class="dropdown">
                <!-- Naar voorraadbeheer -->
                <a href="voorraad.php" class="dropbtn">Voorraad beheer</a>
                <div class="dropdown-content">
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                </div>
                <li class="dropdown">
                <!-- Admin paneel - je bent hier (enkel voor directie!) -->
                <a href="admin.php" class="dropbtn">Admin</a>
                <div class="dropdown-content">
                    <a href="#">Link 1</a>
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Admin dashboard inhoud -->
    <h1>Admin panel hier</h1>
    <!-- TODO: voeg admin features toe: statistieken, gebruikers beheer, logs, etc -->
</body>
</html>