<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'agora_francia';
$username = 'root'; // Remplacez par votre nom d'utilisateur
$password = 'root'; // Remplacez par votre mot de passe
require_once 'config.php'; // Assurez-vous que ce fichier existe et configure la connexion à la base de données
require_once 'compenant/header.php'; // Inclure le fichier header.php
require_once 'compenant/footer.php'; // Inclure le fichier footer.php

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Impossible de se connecter à la base de données : " . $e->getMessage());
}

// Vérifier si l'ID de l'article est passé en paramètre
if (isset($_GET['id'])) {
    $id_objet = $_GET['id'];

    // Récupérer les détails de l'article
    $sql = "SELECT items.id_objet, items.nom, items.description, items.prix, items.type_vente, items.photo_principale, categories.nom AS categorie_nom
            FROM items
            JOIN categories ON items.id_categorie = categories.id
            WHERE items.id_objet = :id_objet";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_objet' => $id_objet]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si l'article n'existe pas
    if (!$article) {
        die("Article introuvable.");
    }
} else {
    die("ID de l'article non spécifié.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['nom']); ?> - Agora Francia</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="wrapper">
        <?php render_header('Agora Francia'); ?>
        <section class="main-section">
            <div class="article-details">
                <h2><?php echo htmlspecialchars($article['nom']); ?></h2>
                <img src="<?php echo htmlspecialchars($article['photo_principale']); ?>" alt="<?php echo htmlspecialchars($article['nom']); ?>">
                <p><?php echo htmlspecialchars($article['description']); ?></p>
                <p>Prix: <?php echo htmlspecialchars($article['prix']); ?> €</p>
                <p>Type de vente: <?php echo htmlspecialchars($article['type_vente']); ?></p>
                <p>Catégorie: <?php echo htmlspecialchars($article['categorie_nom']); ?></p>
                <button onclick="window.location.href='ajouter_panier.php?id_item=<?php echo $article['id_objet']; ?>'">Ajouter au panier</button>
            </div>
        </section>
        <?php render_footer(); ?>
    </div>
</body>
</html>
