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
            <h1><strong>Liste des produits </strong><a href="insert.php" class="btn btn-success"><i
                        class="fa-solid fa-plus"></i> Ajouter un produit</a></h1>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require 'database.php';
                    $db = Database::connect();
                    $statement = $db->query('SELECT items.id, items.name, items.description, items.price, categories.name AS category 
                    FROM items LEFT JOIN categories ON items.category = categories.id
                    ORDER BY items.id DESC
                    ');

                    while ($item = $statement->fetch()) {
                        echo '<tr>';
                        echo '<td>' . $item['name'] . '</td>';
                        echo '<td>' . $item['description'] . '</td>';
                        echo '<td>' . number_format((float) $item['price'], 2, '.', '') . '</td>';
                        echo '<td>' . $item['category'] . '</td>';
                        echo ' <td width=340>';
                        echo '<a class="btn btn-secondary" href="view.php?id=' . $item['id'] . '"><i class="fa-regular fa-eye"></i> Voir</a>';
                        echo ' ';
                        echo '<a class="btn btn-primary" href="update.php?id=' . $item['id'] . '"><i class="fa-solid fa-pencil"></i> Modifier</a>';
                        echo ' ';
                        echo '<a class="btn btn-danger" href="delete.php?id=' . $item['id'] . '"><i class="fa-solid fa-xmark"></i> Supprimer</a>';
                        echo '</td>';
                        echo '</tr>';
                    }

                    Database::disconnect();


                    ?>
                </tbody>
            </table>
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