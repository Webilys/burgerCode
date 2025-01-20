<?php
require 'database.php';

if (!empty($_GET['id'])) {
    $id = checkInput($_GET['id']);
}

if (!empty($_POST)) {
    $id = checkInput($_POST['id']);
    $db = Database::connect();
    $statement = $db->prepare("DELETE FROM items WHERE id = ?");
    $statement->execute(array($id));
    Database::disconnect();
    header("Location: products.php");
    exit;
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
            <h1><strong>Supprimer un produit </strong></h1>
            <br>
            <form class="form" role="form" action="delete.php" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <p class="alert alert-warning">Êtes-vous sûr(e) de vouloir supprimer ce produit ?</p>
                <div class="form-actions">
                    <br>
                    <button type="submit" class="btn btn-warning">Oui</button>
                    <a href="products.php" class="btn btn-secondary">Non</a>
                </div>
            </form>
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
</body>

</html>