<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Navigatie balk aan de bovenkant (Bootstrap) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Kringloop centrum</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ritten.php">Ritten</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="voorraad.php">Voorraad beheer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Admin</a>
                    </li>
                </ul>
                <a href="login.php" class="btn btn-outline-light rounded-pill">Aanmelden</a>
            </div>
        </div>
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

    <!-- Bootstrap JS (Popper + Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
