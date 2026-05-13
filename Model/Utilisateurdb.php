<?php 
require_once 'Database.php';

class Utilisateurdb
{
	private $db;
	private $id;
	private $table;

	public function __construct(){
        $this->db = new Database();
        $this->id = "id_user";
        $this->table = "users";
    }


	public	function get_user($id = null)
	{
		if ($id == null) {

			$pdo = " SELECT * FROM $this->table";

            $rqt = $this->db->requette($pdo);

            $data = $this->db->recupere($rqt, false);

		} else {

			$pdo = " SELECT * FROM $this->table WHERE $this->id=?";

			$params = [$id];

			$rqt = $this->db->requette($pdo, $params);

			$data = $this->db->recupere($rqt);

		}

		return $data[0];
	}

	public function set_user($nom,$prenom,$email,$password,$id=null){
        if ($id == null) {
            $pdo = " UPDATE $this->table SET nom=?, prenom=?, email=?, password=? WHERE $this->id=?";

            $params = [$nom, $prenom, $email, $password, $id];

            $rqt = $this->db->requette($pdo, $params);

            return $rqt[0];
        } else {
            $pdo = " INSERT INTO $this->table SET nom=?, prenom=?, email=?, password=?";

            $params = [$nom, $prenom, $email, $password];

            $rqt = $this->db->requette($pdo, $params);

            return $rqt[1];
        }
	}

}
 ?>