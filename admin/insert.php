<?php
require 'database.php';

$nameError = $descriptionError = $priceError = $categoryError = $imageError = $name = $description = $price = $category = $image = "";

if (!empty($_POST)) {
    $name = checkInput($_POST['name']);
    $description = checkInput($_POST['description']);
    $price = checkInput($_POST['price']);
    $category = checkInput($_POST['category']);
    $image = checkInput($_FILES['image']['name']);
    $imagePath = '../images/' . basename($image);
    $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
    $isSuccess = true;
    $isUploadSuccess = false;

    // Validations des champs
    if (empty($name)) {
        $nameError = "Le nom du produit est requis";
        $isSuccess = false;
    }

    if (empty($description)) {
        $descriptionError = "La description est requise";
        $isSuccess = false;
    }

    if (empty($price) || !is_numeric($price) || $price <= 0) {
        $priceError = "Veuillez entrer un prix valide";
        $isSuccess = false;
    }

    if (empty($category)) {
        $categoryError = "La catégorie est requise";
        $isSuccess = false;
    }

    if (empty($image)) {
        $imageError = "Une image est requise";
        $isSuccess = false;
    } else {
        $isUploadSuccess = true;

        // Vérifications sur le fichier
        if ($imageExtension != "jpg" && $imageExtension != "jpeg" && $imageExtension != "png" && $imageExtension != "webp") {
            $imageError = "Les formats autorisés sont : .jpg, .jpeg, .png, .webp";
            $isUploadSuccess = false;
        }
        if (file_exists($imagePath)) {
            $imageError = "Le nom du fichier existe déjà";
            $isUploadSuccess = false;
        }
        if ($_FILES['image']['size'] > 500000) {
            $imageError = "Le fichier ne doit pas dépasser 500kB";
            $isUploadSuccess = false;
        }
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $imageError = "Erreur lors du téléchargement de l'image";
            $isUploadSuccess = false;
        }
        if ($isUploadSuccess) {
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                $imageError = "Erreur lors du téléchargement du fichier";
                $isUploadSuccess = false;
            }
        }
    }

    // Insertion en base de données
    if ($isSuccess && $isUploadSuccess) {
        $db = Database::connect();
        $statement = $db->prepare("INSERT INTO items (name,description,price, category, image) VALUES(?,?,?,?,?)");
        $statement->execute(array($name, $description, $price, $category, $image));
        Database::disconnect();
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
            <h1><strong>Ajouter un produit </strong></h1>
            <br>
            <form class="form" role="form" action="insert.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Nom :</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nom"
                        value="<?php echo $name; ?>">
                    <span class="help-inline"><?php echo $nameError; ?></span>
                </div>
                <br>

                <div class="form-group">
                    <label for="description">Description :</label>
                    <input type="text" class="form-control" id="description" name="description"
                        placeholder="Description" value="<?php echo $description; ?>">
                    <span class="help-inline"><?php echo $descriptionError; ?></span>
                </div>
                <br>

                <div class="form-group">
                    <label for="price">Prix (en €) :</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix"
                        value="<?php echo $price; ?>">
                    <span class="help-inline"><?php echo $priceError; ?></span>
                </div>
                <br>

                <div class="form-group">
                    <label for="category">Catégorie :</label>
                    <select class="form-control" name="category" id="category">
                        <?php
                        $db = Database::connect();
                        foreach ($db->query('SELECT * FROM categories') as $row) {
                            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';

                        }
                        Database::disconnect();

                        ?>
                    </select>
                    <span class="help-inline"><?php echo $categoryError; ?></span>
                </div>
                <br>

                <div class="form-group">
                    <label for="image">Sélectionner une image :</label>
                    <input type="file" name="image" id="image">
                </div>
                <span class="help-inline"><?php echo $imageError; ?></span>
                <div class="form-actions">
                    <br>
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i>
                        Enregistrer</button>
                    <a href="products.php" class="btn btn-danger"><i class="fa-solid fa-xmark"></i> Annuler</a>
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