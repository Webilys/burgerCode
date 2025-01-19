<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Burger Code</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
  <link href="http://fonts.googleapis.com/css?family=Holtwood+One+SC" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="css/styles.css" />
</head>

<body>
  <div class="container site">
    <h1 class="text-logo">
      <span class="bi-shop"></span> Burger Code <span class="bi-shop"></span>
    </h1>
    <?php
    require 'admin/database.php';

    echo '<nav>
<ul class="nav nav-pills" role="tablist">';

    $db = Database::connect();
    $statement = $db->query('SELECT * FROM categories');
    $categories = $statement->fetchAll();

    foreach ($categories as $category) {
      $id = 'category-' . $category['id']; // Utiliser un préfixe pour éviter les conflits d'ID
      if ($category['id'] == 1) {
        echo '<li class="nav-item" role="presentation">
      <a class="nav-link active" data-bs-toggle="pill" href="#' . $id . '" role="tab">' . $category['name'] . '</a>
    </li>';
      } else {
        echo '<li class="nav-item" role="presentation">
      <a class="nav-link" data-bs-toggle="pill" href="#' . $id . '" role="tab">' . $category['name'] . '</a>
    </li>';
      }
    }

    echo '</ul>
</nav>';

    echo '<div class="tab-content">';

    foreach ($categories as $category) {
      $id = 'category-' . $category['id']; // Associer l'ID correspondant à l'onglet
      if ($category['id'] == 1) {
        echo '<div class="tab-pane fade show active" id="' . $id . '" role="tabpanel">';
      } else {
        echo '<div class="tab-pane fade" id="' . $id . '" role="tabpanel">';
      }

      echo '<div class="row">';
      $statement = $db->prepare('SELECT * FROM items WHERE items.category = ?');
      $statement->execute(array($category['id']));

      while ($item = $statement->fetch()) {
        echo '<div class="col-sm-6 col-md-4">
    <div class="img-thumbnail">
    <img src="images/' . $item['image'] . '" alt="...">
    <div class="price">' . number_format($item['price'], 2, '.', '') . ' €</div>
    <div class="caption">
    <h4>' . $item['name'] . '</h4>
    <p>' . $item['description'] . '</p>
    <a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Commander</a>
    </div>
    </div>
    </div>';
      }

      echo '</div>'; // Ferme la div .row
      echo '</div>'; // Ferme la div .tab-pane
    }

    Database::disconnect();
    echo '</div>'; // Ferme la div .tab-content
    ?>


  </div>
</body>

</html>