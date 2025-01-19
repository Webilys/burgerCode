<?php
require 'database.php';

if (!empty($_GET['id'])) {
    $id = checkInput($_GET['id']);
}

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
    $isUploadSuccess = true;

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
        $isImageUpdated = false;
    } else {
        $isImageUpdated = true;

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
    if (($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated)) {
        $db = Database::connect();
        if ($isImageUpdated) {
            $statement = $db->prepare("UPDATE items set name = ?, description = ?, price = ?, category = ?, image = ? WHERE id = ?");
            $statement->execute(array($name, $description, $price, $category, $image, $id));
        } else {
            $statement = $db->prepare("UPDATE items set name = ?, description = ?, price = ?, category = ? WHERE id = ?");
            $statement->execute(array($name, $description, $price, $category, $id));
        }

        Database::disconnect();
        header("Location: index.php");
        exit;
    } else if ($isImageUpdated && !$isUploadSuccess) {
        $db = Database::connect();
        $statement = $db->prepare("SELECT image FROM items WHERE id = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $image = $item['image'];
        Database::disconnect();
    }

} else {
    $db = Database::connect();

    $statement = $db->prepare('SELECT * FROM items WHERE id = ?');
    $statement->execute(array($id));
    $item = $statement->fetch();

    $name = $item['name'];
    $description = $item['description'];
    $price = $item['price'];
    $category = $item['category'];
    $image = $item['image'];

    Database::disconnect();
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
    <title>Burger Code</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <h1 class="text-logo"><span class="bi-shop"></span> Burger Code <span class="bi-shop"></span></h1>
    <div class="container admin">
        <div class="row">
            <div class="col-sm-6">


                <h1><strong>Modifier un item </strong></h1>
                <br>
                <form class="form" role="form" action="<?php echo 'update.php?id=' . $id; ?>" method="post"
                    enctype="multipart/form-data">
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
                                if ($row['id'] == $category) {

                                    echo '<option selected="selected" value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                } else {
                                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                }
                            }
                            Database::disconnect();

                            ?>
                        </select>
                        <span class="help-inline"><?php echo $categoryError; ?></span>
                    </div>
                    <br>

                    <div class="form-group">
                        <label>Image : </label>
                        <p><?php echo $image; ?></p>
                        <label for="image">Sélectionner une image :</label>
                        <input type="file" name="image" id="image">
                    </div>
                    <span class="help-inline"><?php echo $imageError; ?></span>
                    <div class="form-actions">
                        <br>
                        <button type="submit" class="btn btn-success"><span
                                class="glyphicon glyphicon-pencil"></span>Modifier</button>
                        <a href="index.php" class="btn btn-primary"><span
                                class="glyphicon glyphicon-arrow-left"></span>Retour</a>
                    </div>
                </form>
            </div>
            <div class="col-md-6 col-lg-4 site">
                <div class="img-thumbnail">
                    <img src="<?php echo '../images/' . $image; ?>" class="img-fluid" alt="..." />
                    <div class="price"><?php echo number_format((float) $price, 2, '.', '') . ' €'; ?></div>
                    <div class="caption">
                        <h4><?php echo $name; ?></h4>
                        <p>
                            <?php echo $description; ?>
                        </p>
                        <a href="#" class="btn btn-order" role="button"><span class="bi-cart-fill"></span> Commander</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>