<?php
session_start();
require_once 'config.php';
require_once 'compenant/header.php'; // Inclure le fichier header.php
require_once 'compenant/footer.php'; // Inclure le fichier footer.php

// Connexion à la base de données
$host = 'localhost';
$dbname = 'agora_francia';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Impossible de se connecter à la base de données : " . $e->getMessage());
}

// Récupération de l'ID de l'utilisateur (remplacer par l'authentification réelle)
$id_utilisateur = 1; // Changez ceci pour obtenir l'ID utilisateur authentifié

// Récupération de l'ID du panier de l'utilisateur
$sql = "SELECT id FROM paniers WHERE id_acheteur = :id_acheteur";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_acheteur' => $id_utilisateur]);

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $id_panier = $row['id'];

    // Récupération des articles dans le panier
    $sql = "SELECT items.id_objet, items.nom, items.description, items.prix, items.photo_principale 
            FROM panier_items 
            JOIN items ON panier_items.id_item = items.id_objet 
            WHERE panier_items.id_panier = :id_panier";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_panier' => $id_panier]);
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $articles = [];
}

// Suppression d'un article du panier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_item'])) {
    $id_item_to_remove = $_POST['id_item'];

    $sql = "DELETE FROM panier_items WHERE id_panier = :id_panier AND id_item = :id_item";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_panier' => $id_panier, 'id_item' => $id_item_to_remove]);

    // Rafraîchir la page après suppression
    header("Location: panier.php");
    exit;
}

if (isset($_GET['message'])) {
    echo '<p>' . htmlspecialchars($_GET['message']) . '</p>';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Panier - Agora Francia</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="wrapper">
        <?php render_header('Votre Panier'); ?>
        <section class="main-section">
            <h2>Votre Panier</h2>
            <?php if (count($articles) > 0): ?>
                <div class="articles">
                    <?php foreach ($articles as $article): ?>
                        <div class="article">
                            <img src="<?php echo htmlspecialchars($article['photo_principale']); ?>" alt="<?php echo htmlspecialchars($article['nom']); ?>">
                            <p><?php echo htmlspecialchars($article['nom']); ?></p>
                            <p><?php echo htmlspecialchars($article['description']); ?></p>
                            <p>Prix: <?php echo htmlspecialchars($article['prix']); ?> €</p>
                            <form method="post" action="">
                                <input type="hidden" name="id_item" value="<?php echo htmlspecialchars($article['id_objet']); ?>">
                                <button type="submit" name="remove_item">Enlever</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
                <form method="post" action="payer.php">
                    <button type="submit" name="validate_cart">Valider le panier</button>
                </form>
            <?php else: ?>
                <p>Votre panier est vide.</p>
            <?php endif; ?>
        </section>
        <?php render_footer(); ?>
    </div>
</body>
</html>
