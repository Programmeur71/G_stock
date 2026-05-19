<?php
// On redirige vers l'API pour effectuer la déconnexion
header("Location: api.php?entity=utilisateur&action=logout");
exit;
