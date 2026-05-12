<?php
    
error_reporting(0);

function backDb($host, $user, $pass, $dbname, $tables = '*'){
    
    try {
        // Connexion à la base de données avec PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    // Si les tables à sauvegarder ne sont pas spécifiées, récupérer toutes les tables de la base de données
    if($tables == '*'){
        $tables = array();
        $sql = "SHOW TABLES";
        $query = $pdo->query($sql);
        while($row = $query->fetch(PDO::FETCH_NUM)){
            $tables[] = $row[0];
        }
    } else {
        // Si les tables sont spécifiées, les convertir en un tableau s'il ne l'est pas déjà
        $tables = is_array($tables) ? $tables : explode(',',$tables);
    }

    // Initialiser la chaîne de sortie SQL
    $outsql = '';
    foreach ($tables as $table) {
        // Récupérer la structure de la table
        $sql = "SHOW CREATE TABLE $table";
        $query = $pdo->query($sql);
        $row = $query->fetch(PDO::FETCH_NUM);
        $outsql .= "\n\n" . $row[1] . ";\n\n";
        
        // Récupérer les données de la table
        $sql = "SELECT * FROM $table";
        $query = $pdo->query($sql);
        
        // Boucler à travers les données et les ajouter à la chaîne de sortie SQL
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $outsql .= "INSERT INTO $table VALUES(";
            $outsql .= implode(', ', array_map(function($value) use ($pdo) {
                return $pdo->quote($value);
            }, $row));
            $outsql .= ");\n";
        }
        $outsql .= "\n";
    }

    // Nom du fichier de sauvegarde
    $date = date('d-m-Y');
    $backup_file_name = $dbname .'_'.$date. '.sql';

    // Écrire le contenu dans le fichier
    $fileHandler = fopen($backup_file_name, 'w+');
    fwrite($fileHandler, $outsql);
    fclose($fileHandler);

    // Télécharger le fichier de sauvegarde
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($backup_file_name));
    ob_clean();
    flush();
    readfile($backup_file_name);

    // Supprimer le fichier après le téléchargement
    unlink($backup_file_name);
}

?>
