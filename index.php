<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<!-- Navigatie balk aan de bovenkant -->
    <nav class="navbar">
        <ul class="nav-links">
            <!-- Logo/home link -->
            <li><a href="index.php">Centrum Duurzaam</a></li>
        
<!-- Dropdown menu's voor de hoofd functies -->
            <li class="dropdown">
                <!-- Ritten sectie met submenu -->
                <a href="ritten.php" class="dropbtn">Ritten</a>
                <div class="dropdown-content">
                    <a href="#">Link 1</a>
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                </div>
                <li class="dropdown">
                <!-- Voorraadbeheer sectie -->
                <a href="voorraad.php" class="dropbtn">Voorraad beheer</a>
                <div class="dropdown-content">
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                </div>
                <li class="dropdown">
                <!-- Admin paneel (alleen voor directie) -->
                <a href="admin.php" class="dropbtn">Admin</a>
                <div class="dropdown-content">
                    <a href="#">Link 1</a>
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                </div>
            </li>
        </ul>
    </nav>

<!-- Hoofd content pagina - 3 boxes met de meest gebruikte functies -->
    <div class="page-container">
        <!-- Welkomst sectie bovenaan -->
        <div class="welcome-section">
            <h1>Welkom bij Centrum Duurzaam</h1>
            <p>Beheer je ritten, voorraden en administratie op één plek. Kies hieronder wat je wilt doen:</p>
        </div>

        <!-- De 3 main boxes die naar andere pagina's linken -->
        <div class="boxes-container">
            <!-- Box 1: Ritten management -->
            <a href="ritten.php" class="box">
                <div class="box-content">
                    <div class="box-title">Ritten</div>
                    <div class="box-description">Ritten plannen, verwijderen en afvinken</div>
                </div>
            </a>
            <!-- Box 2: Voorraadbeheer -->
            <a href="voorraad.php" class="box">
                <div class="box-content">
                    <div class="box-title">Voorraad beheer</div>
                    <div class="box-description">Voorraden checken en bijhouden</div>
                </div>
            </a>
            <!-- Box 3: Admin paneel -->
            <a href="admin.php" class="box">
                <div class="box-content">
                    <div class="box-title">Admin paneel</div>
                    <div class="box-description">Een dashboard waar alleen de directie heen kan</div>
                </div>
            </a>
        </div>
    </div>

</body>
</html>
