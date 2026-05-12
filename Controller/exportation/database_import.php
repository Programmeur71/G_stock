<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Sécurité : vérifier les droits si nécessaire
// include('../droit/securite.php');

if (isset($_POST['importnow'])) {
    if (!isset($_FILES['sql_file']) || $_FILES['sql_file']['error'] == UPLOAD_ERR_NO_FILE) {
        die("Veuillez sélectionner un fichier SQL.");
    }

    if ($_FILES['sql_file']['error'] !== UPLOAD_ERR_OK) {
        $error_codes = [
            1 => 'Le fichier dépasse la limite autorisée par le serveur (upload_max_filesize).',
            2 => 'Le fichier dépasse la limite autorisée par le formulaire.',
            3 => 'Le fichier n\'a été que partiellement téléchargé.',
            6 => 'Dossier temporaire manquant.',
            7 => 'Échec de l\'écriture du fichier sur le disque.',
            8 => 'Une extension PHP a arrêté le téléchargement.'
        ];
        $msg = isset($error_codes[$_FILES['sql_file']['error']]) ? $error_codes[$_FILES['sql_file']['error']] : 'Erreur inconnue lors de l\'envoi.';
        die($msg);
    }

    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $db_name = getenv('DB_NAME') ?: 'pharmacie';
    $db_user = getenv('DB_USER') ?: 'root';
    $db_pass = getenv('DB_PASS') ?: '';

    $file = $_FILES['sql_file']['tmp_name'];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Désactiver les contraintes de clés étrangères pour l'importation
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");

        $sql = file_get_contents($file);
        
        // Exécuter le SQL
        // Note: Pour les gros fichiers, il vaudrait mieux lire ligne par ligne ou utiliser exec() avec mysql cli
        // Mais ici on tente une exécution directe du contenu
        $pdo->exec($sql);

        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

        $_SESSION['import_success'] = "La base de données a été importée avec succès.";
    } catch (PDOException $e) {
        $_SESSION['import_error'] = "Erreur lors de l'importation : " . $e->getMessage();
    }

    header("Location: ../../Information");
    exit();
} else {
    header("Location: ../../Information");
    exit();
}
?>
