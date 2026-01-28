<?php
// Verwerk registratie via generalrun (dbFunction)
include 'generalrun.php';
?>
<!DOCTYPE html>
<html lang="nl" class="no-js">
<head>
    <meta charset="UTF-8" />
    <title>Registreren</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous"
    >

    <link rel="icon" href="img/nficon.ico" />
</head>
<body class="bg-light">
    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-sm-10 col-md-6 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h1 class="h3 mb-4 text-center">Registreren</h1>

                        <form name="register" method="post" action="">
                            <div class="mb-3">
                                <label for="usernamesignup" class="form-label">Gebruikersnaam</label>
                                <input
                                    id="usernamesignup"
                                    name="gebruikersnaamid"
                                    type="text"
                                    class="form-control"
                                    required
                                    placeholder="Kies een gebruikersnaam"
                                >
                            </div>

                            <div class="mb-3">
                                <label for="passwordsignup" class="form-label">Wachtwoord</label>
                                <input
                                    id="passwordsignup"
                                    name="wachtwoord"
                                    type="password"
                                    class="form-control"
                                    required
                                    placeholder="Kies een sterk wachtwoord"
                                >
                            </div>

                            <div class="mb-3">
                                <label for="passwordsignup_confirm" class="form-label">Herhaal wachtwoord</label>
                                <input
                                    id="passwordsignup_confirm"
                                    name="confirm_wachtwoord"
                                    type="password"
                                    class="form-control"
                                    required
                                    placeholder="Herhaal uw wachtwoord"
                                >
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" name="register" class="btn btn-primary">
                                    Account aanmaken
                                </button>
                            </div>

                            <p class="text-center mb-0">
                                Al een account?
                                <a href="login.php">Log hier in</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"
    ></script>
</body>
</html>