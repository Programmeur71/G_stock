<?php 
class Database
{
	private $dsn;
	private $user;
	private $password;

	public function __construct()
	{
		$host = 'localhost';
		$db_name = 'g_stock';
		$db_user = 'root';
		$db_pass = '';

		$this->dsn = "mysql:host=$host;dbname=$db_name;port=3306;charset=utf8";
		$this->user = "$db_user";
		$this->password = "$db_pass";
	}


	public function connexiondb(){
		$pdo = new PDO($this->dsn, $this->user, $this->password);
		$pdo->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $pdo;
	}

	public function requette($sql, $params = null)
	{
		$db = $this->connexiondb();
		$rqt = $db->prepare($sql);
		$id = 0;

		if ($params == null) {
			$rqt->execute();
		}else{
			$rqt->execute($params);
			$id = $db->lastInsertID();
		}

		return [$rqt, $id];

	}

	public function recupere($rqt, $donnee = true)
	{
		$stmt = is_array($rqt) ? $rqt[0] : $rqt;
		$stmt->SetFetchMode(PDO::FETCH_OBJ);

		if ($donnee == true) {
			$datas = $stmt->fetch();
		} else {
			$datas = $stmt->fetchAll();
		}

		return $datas;
	}

}