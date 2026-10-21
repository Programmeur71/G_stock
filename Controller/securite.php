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
        
        $user = $_SESSION['user'];
        
        // DEBUG TEMPORAIRE: Forcer les accès pour l'utilisateur principal le temps du test
        if (isset($user->id_user) && $user->id_user == 1) {
            return true;
        }
        
        // Les administrateurs ont toutes les permissions par défaut
        $currentRole = strtoupper($user->role ?? '');
        if ($currentRole === 'ADMINISTRATEUR') {
            return true;
        }

        // Si l'utilisateur n'a pas de permissions chargées, on retourne false
        if (!isset($user->permissions) || !is_array($user->permissions)) {
            return false;
        }
        
        return in_array($permissionName, $user->permissions);
    }

?>