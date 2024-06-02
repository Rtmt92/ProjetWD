<?php
require_once 'config.php'; // Si nécessaire pour la configuration globale
require_once 'compenant/header.php'; // Inclure le fichier header.php
require_once 'compenant/footer.php'; // Inclure le fichier footer.php
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation - Agora Francia</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="wrapper">
        <?php render_header('Agora Francia'); ?>
        <section class="main-section">
            <h2>Confirmation d'achat</h2>
            <?php if (isset($_GET['message'])): ?>
                <p><?php echo htmlspecialchars($_GET['message']); ?></p>
            <?php else: ?>
                <p>Votre achat a été réalisé avec succès.</p>
            <?php endif; ?>
            <button onclick="window.location.href='index.php'">Retour à l'accueil</button>
        </section>
        <?php render_footer(); ?>
    </div>
</body>
</html>
