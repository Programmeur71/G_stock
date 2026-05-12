<?php 

class Database
{
	private $dsn;
	private $user;
	private $password;

	private $dsn2;
	private $user2;
	private $password2;

	
	public function __construct()
	{
		$host = getenv('DB_HOST') ?: 'localhost';
		$db_name = getenv('DB_NAME') ?: 'pharmacie';
		$db_user = getenv('DB_USER') ?: 'root';
		$db_pass = getenv('DB_PASS') ?: '';

		$this->dsn = "mysql:host=$host;dbname=$db_name;port=3306;charset=utf8";
		$this->user = "$db_user";
		$this->password = "$db_pass";

		$this->dsn2 = "mysql:host=$host;dbname=pharmacieglobal;port=3306;charset=utf8";
		$this->user2 = "$db_user";
		$this->password2 = "$db_pass";
	}



	public function connexiondb()
	{
		$pdo = new PDO($this->dsn, $this->user, $this->password);

		$pdo->exec("SET lc_time_names='fr_FR'");
		$pdo->exec("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
		//$pdo->exec("SET DATEFIRST 1");

		$pdo->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return $pdo;
	}

	public function connexiondb2()
	{
		$pdo = new PDO($this->dsn2, $this->user2, $this->password2);

		$pdo->exec("SET lc_time_names='fr_FR'");
		$pdo->exec("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");

		$pdo->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return $pdo;
	}


	public	function insertion($sql, $params)
	{
		$db = $this->connexiondb();

		$rqt = $db->prepare($sql);

		$rqt->execute($params);

		$id = $db->lastInsertID();

		return $id;
	}



	
	public function requette($sql, $params = null)
	{
		$db = $this->connexiondb();

		$rqt = $db->prepare($sql);

		if ($params == null) {

			$rqt->execute();

		}else{

			$rqt->execute($params);
		}

		return $rqt;

	}

	public function requette_2($sql, $params = null)
	{
		$db = $this->connexiondb2();

		$rqt = $db->prepare($sql);

		if ($params == null) {

			$rqt->execute();

		}else{

			$rqt->execute($params);
		}

		return $rqt;

	}

	public function requette2($sql, $params = null)
	{
		$db = $this->connexiondb();

		$rqt = $db->prepare($sql);

		if ($params == null) {

			$rqt->execute();
			$nb = $rqt->rowCount();
			$id = $db->lastInsertID();

		}else{

			$rqt->execute($params);
			$nb = $rqt->rowCount();
			$id = $db->lastInsertID();
		}

		$retour = [$rqt, $nb, $id];

		return $retour;

	}


	public function recupere($rqt, $donnee = true)
	{
		$data = null;

		$rqt->SetFetchMode(PDO::FETCH_OBJ);

		if ($donnee == true) {
			
			$datas = $rqt->fetch();

		} else {
		
			$datas = $rqt->fetchAll();

		}

		return $datas;
	}


	public function recupere2($rqt, $donnee = true)
	{
		$data = null;

		$rqt->SetFetchMode(PDO::FETCH_ASSOC);

		if ($donnee == true) {
			
			$datas = $rqt->fetch();

		} else {
		
			$datas = $rqt->fetchAll();

		}

		return $datas;
	}

}