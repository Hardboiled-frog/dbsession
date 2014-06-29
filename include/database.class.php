<?php

define("DB_HOST", "");
define("DB_NAME", "");
define("DB_USER", "");
define("DB_PASS", "");

class Database {
	private $host = DB_HOST;
	private $user = DB_USER;
	private $pass = DB_PASS;
	private $dbname = DB_NAME;

	private $dbh;
	private $error;

	private $stmt;

	public function __construct() {
		// set DSN
		$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;

		// set OPTIONS
		$options = array(
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		);

		// create a new PDO instance or catch any errors
		try {
			$this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
		} catch (PDOException $e) {
			$this->error = $e->getMessage();
		}
	}
	
	// prepare statement
	public function query($query) {
		$this->stmt = $this->dbh->prepare($query);
	}
	
	// bind values and execute statement
	public function execute(array $params = null) {
		$this->stmt->execute($params);
	}
	
	// fetch single row result
	public function single() {
		try {
			return $this->stmt->fetch(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			$this->error = $e->getMessage();
		}
	}
	
	// fetch all results
	public function resultset() {
		try {
			return $this->stmt->fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			$this->error = $e->getMessage();
		}
	}
	
	// fetch output parameter from stored procedure
	public function outParam($paramName, $paramAsName) {
		$this->stmt->closeCursor();
		return $this->dbh->query('SELECT ' . $paramName . ' AS ' . $paramAsName)->fetch(PDO::FETCH_OBJ);
	}
	
	// get affected rows count
	public function rowCount() {
		return $this->stmt->rowCount();
	}
	
	// get the id of the last inserted row
	public function lastInsertId() {
		return $this->dbh->lastInsertId();
	}
	
	// begin transaction
	public function beginTransaction() {
		return $this->dbh->beginTransaction();
	}
	
	// end transaction
	public function endTransaction() {
		return $this->dbh->commit();
	}
	
	// cancel transaction
	public function cancelTransaction() {
		return $this->dbh->rollBack();
	}
	
	// debug dump parameters
	public function debugDumpParams() {
		return $this->stmt->debugDumpParams();
	}
	
	// close connection
	public function close() {
		$this->dbh = null;
	}
}

?>