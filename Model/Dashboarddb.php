<?php
require_once 'Model/BaseModel.php';

class Dashboarddb extends Model
{
    public function __construct() { parent::__construct('users', 'id_user'); }

    public function getStats()
    {
        $stats = [];
        
        // 1. Total Clients
        $r = $this->db->requette("SELECT COUNT(*) as total FROM client");
        $stats['total_clients'] = $this->db->recupere($r)->total;

        // 2. Total Produits
        $r = $this->db->requette("SELECT COUNT(*) as total FROM produit");
        $stats['total_produits'] = $this->db->recupere($r)->total;

        // 3. Chiffre d'Affaires (Ventes)
        $r = $this->db->requette("SELECT SUM(total) as total FROM vente WHERE statut = 'Livré'");
        $stats['ca_total'] = $this->db->recupere($r)->total ?? 0;

        // 4. Ventes en attente
        $r = $this->db->requette("SELECT COUNT(*) as total FROM vente WHERE statut = 'En attente'");
        $stats['ventes_attente'] = $this->db->recupere($r)->total;

        // 5. Dernières Ventes
        $r = $this->db->requette("SELECT v.*, c.nom as client_nom FROM vente v LEFT JOIN client c ON v.id_client = c.id_client ORDER BY v.date DESC LIMIT 5");
        $stats['recent_sales'] = $this->db->recupere($r, false);

        // 6. Top Produits (Vendus)
        $sql_top = "SELECT p.nom, SUM(dv.quantite) as total_vendu 
                    FROM detail_vente dv 
                    JOIN produit p ON dv.id_produit = p.id_produit 
                    GROUP BY dv.id_produit 
                    ORDER BY total_vendu DESC LIMIT 5";
        $r = $this->db->requette($sql_top);
        $stats['top_products'] = $this->db->recupere($r, false);

        // 7. Ventes par jour (Mois en cours)
        $sql_daily = "SELECT DAY(date) as jour, SUM(total) as total 
                      FROM vente 
                      WHERE MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE()) AND statut = 'Livré'
                      GROUP BY DAY(date) ORDER BY jour ASC";
        $r = $this->db->requette($sql_daily);
        $stats['sales_daily'] = $this->db->recupere($r, false);

        // 8. Ventes par mois (Année en cours)
        $sql_monthly = "SELECT MONTH(date) as mois, SUM(total) as total 
                        FROM vente 
                        WHERE YEAR(date) = YEAR(CURRENT_DATE()) AND statut = 'Livré'
                        GROUP BY MONTH(date) ORDER BY mois ASC";
        $r = $this->db->requette($sql_monthly);
        $stats['sales_monthly'] = $this->db->recupere($r, false);

        return $stats;
    }
}
