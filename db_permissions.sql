-- Insertion des permissions de base pour chaque entité
INSERT INTO `permission` (`designation`) VALUES 
('AJOUTER_CLIENT'), ('MODIFIER_CLIENT'), ('SUPPRIMER_CLIENT'), ('VOIR_CLIENT'),
('AJOUTER_FOURNISSEUR'), ('MODIFIER_FOURNISSEUR'), ('SUPPRIMER_FOURNISSEUR'), ('VOIR_FOURNISSEUR'),
('AJOUTER_PRODUIT'), ('MODIFIER_PRODUIT'), ('SUPPRIMER_PRODUIT'), ('VOIR_PRODUIT'),
('AJOUTER_COMMANDE'), ('MODIFIER_COMMANDE'), ('SUPPRIMER_COMMANDE'), ('VOIR_COMMANDE'),
('AJOUTER_VENTE'), ('MODIFIER_VENTE'), ('SUPPRIMER_VENTE'), ('VOIR_VENTE'),
('AJOUTER_UTILISATEUR'), ('MODIFIER_UTILISATEUR'), ('SUPPRIMER_UTILISATEUR'), ('VOIR_UTILISATEUR'),
('AJOUTER_ROLE'), ('MODIFIER_ROLE'), ('SUPPRIMER_ROLE'), ('VOIR_ROLE'),
('AJOUTER_STOCK'), ('MODIFIER_STOCK'), ('SUPPRIMER_STOCK'), ('VOIR_STOCK');

-- Création d'un rôle Administrateur
INSERT INTO `role` (`designation`) VALUES ('CLIENTS');
INSERT INTO `role` (`designation`) VALUES ('ADMINISTRATEUR');

-- Attribution de toutes les permissions au rôle Administrateur (ID 1 supposé)
INSERT INTO `role_permission` (id_role, id_permission)
SELECT 1, id_permission FROM `permission` ;
