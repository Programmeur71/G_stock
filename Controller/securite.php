<?php
	if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

	if(!(isset($_SESSION['user'])))
	{
		header("location:login"); 
        exit;
	}

    /**
     * Vérifie si l'utilisateur a une permission spécifique
     */
    function hasPermission($permissionName) {
        if (!isset($_SESSION['user'])) return false;
        
        // Les administrateurs ont toutes les permissions par défaut
        // On force la comparaison en majuscules pour éviter les erreurs de saisie en BD
        $currentRole = strtoupper($_SESSION['user']->role ?? '');
        if ($currentRole === 'ADMINISTRATEUR') {
            return true;
        }

        if (!isset($_SESSION['user']->permissions)) return false;
        
        return in_array($permissionName, $_SESSION['user']->permissions);
    }

?>