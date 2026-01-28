<?php
// Verwerk login via database-functies
include 'generalrun.php';
?>
<!DOCTYPE html>
<html lang="nl" class="no-js">
<head>
    <meta charset="UTF-8" />
    <title>Inloggen</title>
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
                        <h1 class="h3 mb-4 text-center">Inloggen</h1>

                        <form name="login" method="post" action="">
                            <div class="mb-3">
                                <label for="emailsignup" class="form-label">Gebruikersnaam</label>
                                <input
                                    id="emailsignup"
                                    name="gebruikersnaamid"
                                    type="text"
                                    class="form-control"
                                    required
                                    placeholder="Vul uw gebruikersnaam in"
                                >
                            </div>

                            <div class="mb-3">
                                <label for="wachtwoord" class="form-label">Wachtwoord</label>
                                <input
                                    id="wachtwoord"
                                    name="wachtwoord"
                                    type="password"
                                    class="form-control"
                                    required
                                    placeholder="Vul uw wachtwoord in"
                                >
                            </div>

                            <div class="mb-3 form-check">
                                <input
                                    type="checkbox"
                                    class="form-check-input"
                                    name="loginkeeping"
                                    id="loginkeeping"
                                    value="loginkeeping"
                                >
                                <label class="form-check-label" for="loginkeeping">
                                    Ingelogd blijven
                                </label>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" name="login" class="btn btn-primary">
                                    Inloggen
                                </button>
                            </div>

                            <p class="text-center mb-0">
                                Nog geen account?
                                <a href="register.php">Registreer nu</a>
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