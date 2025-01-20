<?php
require 'database.php';

if (!empty($_GET['id'])) {
    $id = checkInput($_GET['id']);
}

$db = Database::connect();
$statement = $db->prepare('SELECT items.id, items.name, items.description, items.price, items.image, categories.name AS category 
FROM items LEFT JOIN categories ON items.category = categories.id WHERE items.id = ?');

$statement->execute(array($id));
$item = $statement->fetch();
Database::disconnect();
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
            <div class="col-sm-6">
                <h1><strong>Fiche produit </strong></h1>
                <br>
                <form>
                    <div class="form-group">
                        <label>Nom :</label><?php echo ' ' . $item['name']; ?>
                    </div>
                    <br>

                    <div class="form-group">
                        <label>Description :</label><?php echo ' ' . $item['description']; ?>
                    </div>
                    <br>

                    <div class="form-group">
                        <label>Prix
                            :</label><?php echo ' ' . number_format((float) $item['price'], 2, '.', '') . ' €'; ?>
                    </div>
                    <br>

                    <div class="form-group">
                        <label>Catégorie :</label><?php echo ' ' . $item['category']; ?>
                    </div>
                    <br>

                    <div class="form-group">
                        <label>Image :</label><?php echo ' ' . $item['image']; ?>
                    </div>
                </form>
                <br>
                <div class="form-actions">
                    <a href="products.php" class="btn btn-primary"><i class="fa-solid fa-circle-arrow-left"></i>
                        Retour</a>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 site">
                <div class="img-thumbnail">
                    <img src="<?php echo '../images/' . $item['image']; ?>" class="img-fluid" alt="..." />
                    <div class="price"><?php echo number_format((float) $item['price'], 2, '.', '') . ' €'; ?></div>
                    <div class="caption">
                        <h4><?php echo $item['name']; ?></h4>
                        <p>
                            <?php echo $item['description']; ?>
                        </p>
                        <a href="#" class="btn btn-order" role="button"><i class="fa-solid fa-cart-plus"></i>
                            Commander</a>
                    </div>
                </div>
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
</body>

</html>