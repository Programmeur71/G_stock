<?php 
require_once 'Model/Database.php';

class Autorisationdb
{
	private $db;

	public
		function __construct()
		{
			$this->db = new Database();
		}


	
	public	function get_autorisation($id, $champs = null)
	{

		if ($champs == null) {

			$pdo = " SELECT * FROM personnel_autorisation WHERE id_personnel=?";

				$params = array($id);

				$rqt = $this->db->requette($pdo, $params);

				$data = $this->db->recupere($rqt, true);

		} else {

			$pdo = " SELECT * FROM personnel_autorisation WHERE id_personnel=? AND $champs=?";

			$params = array($id, true);

			$rqt = $this->db->requette($pdo, $params);

			$data = $this->db->recupere($rqt, true);

		}
		


		return $data;
	}

	public function set_autorisation($id,$vente,$enregistrement,$commande,$st_accuil,$f_vente,$f_stock,$p_enregistrement,$p_admin,$p_info)
	{

	$pdo = " UPDATE personnel_autorisation SET vente=?, enregistrement=?, commande=?, st_accuil=?, f_vente=?, f_stock=?, p_enregistrement=?, p_admin=?, p_info=? WHERE id_personnel=? AND id_personnel!=1 ";

		$params = array($vente, $enregistrement, $commande, $st_accuil, $f_vente, $f_stock, $p_enregistrement, $p_admin, $p_info, $id);

		$rqt = $this->db->requette($pdo, $params);

		return $rqt;
	}	

}
 ?>