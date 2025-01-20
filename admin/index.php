<?php
$userName = $userPassword = "";
$userNameTrue = 'priscillaAdmin';
$userPasswordTrue = 'Yoann110712@$';
$verificationId = false;
$userNameError = $userPasswordError = "";

if (!empty($_POST)) {
    $userName = checkInput($_POST['userName']);
    $userPassword = checkInput($_POST['userPassword']);
    $isSuccess = true;

    // Vérification des identifiants
    if ($userName === $userNameTrue && $userPassword === $userPasswordTrue) {
        $verificationId = true;
    } else {
        $userPasswordError = "Identifiant ou mot de passe incorrect.";
        $isSuccess = false;
    }

    // Validation des champs
    if (empty($userName)) {
        $userNameError = "Veuillez saisir votre identifiant.";
        $isSuccess = false;
    }

    if (empty($userPassword)) {
        $userPasswordError = "Veuillez saisir votre mot de passe.";
        $isSuccess = false;
    }

    // Redirection si les identifiants sont corrects
    if ($isSuccess && $verificationId) {
        header("Location: products.php");
        exit;
    }
}

function checkInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Burger Code</title>
    <link rel="icon" href="../images/burger-code-icon.png">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Holtwood+One+SC&display=swap');
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

    <link rel="stylesheet" href="../css/index.css">
</head>

<body>
    <a href="../index.php">
        <h1 class="text-logo">
            <i class="fa-solid fa-burger"></i> Burger Code <i class="fa-solid fa-burger"></i></span>
        </h1>
    </a>
    <div class="container admin">
        <div class="row">
            <h1><strong>Se connecter</strong></h1>
            <div class="login-box">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="userName">Identifiant</label>
                        <input type="text" name="userName" id="userName" class="form-control" value="" />

                        <span class="text-danger"><?= $userNameError; ?></span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="userPassword">Mot de passe</label>
                        <div class="input-group">
                            <input type="password" name="userPassword" id="userPassword" class="form-control" />
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <span class="text-danger"><?= $userPasswordError; ?></span>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Se connecter</button>
                </form>
            </div>
        </div>
    </div>

    <footer>
        <div class="container copyright">
            <br>
            <p class="copyright-text">©2025 - Burger Code - Made with <i class="fa-solid fa-heart"></i> by <a
                    href="https://webilys.fr" target="_blank">Webilys</a> - Tous droits réservés.</p>
            <br>
        </div>
    </footer>
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('userPassword');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
        });
    </script>
</body>

</html>