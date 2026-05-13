<?php
// api.php - Routeur centralisé pour les requêtes AJAX

// Si les paramètres nécessaires ne sont pas présents, on arrête l'exécution silencieusement
// pour éviter d'interférer avec la navigation classique du site.
if (!isset($_REQUEST['entity']) || !isset($_REQUEST['action'])) {
    exit;
}

$entity = $_REQUEST['entity'];
$action = $_REQUEST['action'];

// Construction du nom du contrôleur
$controllerName = ucfirst($entity) . 'Controller';
$controllerFile = 'Controller/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        $method = $action . 'Action';

        if (method_exists($controller, $method)) {
            // Appel de la méthode dynamique du contrôleur
            $controller->$method();
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Action non trouvée']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Classe contrôleur invalide']);
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Entité non trouvée']);
}
