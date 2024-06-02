<?php
function render_header($title) {
    echo '
    <header>
        <h1>' . htmlspecialchars($title) . '</h1>
        <div class="logo">
            <div class="cart"></div>
            <div class="text">AGORA test head</div>
        </div>
    </header>
    <nav class="navigation">
        <button onclick="window.location.href=\'index.php\'">Accueil</button>
        <a href="tout_parcourir.php"><button>Tout Parcourir</button></a>
        <button onclick="window.location.href=\'notifications.php\'">Notifications</button>
        <button>Panier</button>
        <button onclick="window.location.href=\'account.php\'">Votre Compte</button>
        <button onclick="window.location.href=\'logout.php\'">Se Déconnecter</button>
    </nav>';
}
?>
