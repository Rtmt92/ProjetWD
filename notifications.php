<?php
session_start();
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Traitement du formulaire de recherche
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des critères de recherche
    $search_criteria = $_POST['search_criteria'];
    
    // Traitement des critères de recherche (vous devez implémenter cette logique)
    
    // Redirection vers une page de résultats de recherche
    header("Location: search_results.php?criteria=" . urlencode($search_criteria));
    exit;
}

require_once 'config.php'; // Si nécessaire pour la configuration globale
require_once 'compenant/header.php'; // Inclure le fichier header.php
require_once 'compenant/footer.php'; // Inclure le fichier footer.php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Notifications</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="wrapper">
        <?php render_header('Notifications'); ?>
        <section class="main-section">
            <h2>Notifications</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="search_criteria">Critères de recherche :</label>
                <input type="text" id="search_criteria" name="search_criteria" placeholder="Entrez vos critères de recherche">
                <button type="submit">Rechercher</button>
            </form>
            <!-- Afficher les notifications de l'utilisateur si vous en avez -->
            <!-- Vous pouvez ajouter ici d'autres éléments de notification ou d'alerte -->
        </section>
        <?php render_footer(); ?>
    </div>
</body>
</html>
