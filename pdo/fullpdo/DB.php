<?php

/**
* @version 3.10
* @author Pierre Delporte - pierre.delporte@alf-solution.be
* @since 09/07/2004
* @copyright 2004-2015
* @example : www.alf-solution.be
*/

class DB {
	/*
	* Private variable
	*/
	/**
	 * @var Singleton
	 * @access private
	 * @static
	 */
	private static $_instance = null;
	
	private $host;
	private $db;
	private $user;
	private $pass;
	private $link;
	private $result;
	private $typeDB; // Type can be mysql (or mysqli), pgsql, oracle, sqlite
	private $oPdo; // Connexion à PDO
	private $currentSQL;
	/*
	* Public Variable
	*/

	/*
	* Constructor
	* Parameters can be optional
	*/
	private function __construct($Host = "localhost", $User = "root", $Pass = "", $Db = "test", $typedb="mysql") {
		$this->typeDB = "mysql"; // By default use mysql db
		//$this->connect($Host, $User, $Pass, $Db);
		if ($Host == "") {
			$this->host = "localhost";
		} else {
			$this->host = $Host;
		}
		if ($Db == "") {
			$this->db = "test";
		} else {
			$this->db = $Db;
		}
		if ($User == "") {
			$this->user = "root";
		} else {
			$this->user = $User;
		}
		if ($Pass == "") {
			$this->pass = "";
		} else {
			$this->pass = $Pass;
		}
		if ($typedb == "") {
			$this->typeDB = "mysql";
		} else {
			$this->typeDB = $typedb;
		}
	}
	
	/**
	 * Méthode qui crée l'unique instance de la classe
	 * si elle n'existe pas encore puis la retourne.
	 *
	 * @param void
	 * @return Singleton
	 */
	public static function getInstance($Host = "localhost", $User = "root", $Pass = "", $Db = "test", $typedb="mysql") {
	
		if(is_null(self::$_instance)) {
			self::$_instance = new DB($Host, $User, $Pass, $Db, $typedb);
			self::$_instance->setTypeDB($typedb);
			self::$_instance->connect();
		}
	
		return self::$_instance;
	}

	/**
	 * Delete all references to the DB connection
	 */
	function __destruct(){
		$this->db = null;
	}

	function __sleep(){
		return array_keys(get_object_vars($this));
	}

	function __wakeup(){
		$this->__construct($this->host, $this->user, $this->pass, $this->db, $this->typeDB);
		$this->connect();
	}

	/**
	 * Save the type of the DB used
	 * @param string $type type name of the database (mysql, pgsql, oracle, sqlite)
	 */
	public function setTypeDB($type = "mysql") {
		$this->typeDB = $type;
	}

	/**
	 * Establish the connection to the database
	 * @param string $Host the hostname, if omitted the hostname specified in the constructor will be used
	 * @param string $User the user, if omitted the username specified in the constructor will be used
	 * @param string $Pass the password, if omitted the password specified in the constructor will be used
	 * @param string $Db the dbname if omitted the dbname specified in the constructor will be used
	 * @throws Exception
	 * @return boolean return true if the connection is successfull
	 */
	public function connect($Host = '', $User = '', $Pass = '', $Db = '') {
		switch ($this->typeDB) {
			case 'mysql' :
				if ($Host != "") {
					$this->host = $Host;
				}
				if ($Db != "") {
					$this->db = $Db;
				}
				if ($User != "") {
					$this->user = $User;
				}
				if ($Pass != "") {
					$this->pass = $Pass;
				}

				$limit = 10;
				$counter = 0;
				while (true) {
					try {
						$this->oPdo = new PDO('mysql:dbname=' . $this->db . ';host=' . $this->host . ';', $this->user, $this->pass, array(PDO::ATTR_PERSISTENT=> true));						
						$this->oPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						break;
					}
					catch (Exception $e) {
						$this->oPdo = null;
						$counter++;
						if ($counter == $limit)
							throw $e;
					}
					catch (PDOException $oPE) {
						echo 'Impossible de se connecter à la base de données, raison : ' . $oPE->getMessage();
						return false;
					}
				}
				break;
			case 'pgsql' :
				break;
			case 'oracle' :
				break;
			case 'sqlite' :
				if ($Host != "") {
					$this->host = $Host;
				}

				try {
					$this->link = new PDO('sqlite:' . $this->host); //host is the full path to the sqlite file
				}
				catch (PDOException $oPE) {
					echo 'Impossible de se connecter à la base de données, raison : ' . $oPE->getMessage();
					return false;
				}
				break;
			default :
				return false;
				break;
		}
		return true;
	}


	/**
	 * Execute the query and return a resulset
	 * @param unknown $query the query to be executed
	 * @return boolean|Ambigous <unknown, PDOStatement>
	 */
	public function query($query) {
		$this->currentSQL = $query;
		try {
			$this->result = $this->oPdo->query($query);
		} catch (PDOException $err) {
			Debug::var_dump('Error while executing : <br>'.$this->currentSQL);
			Debug::print_backtrace();
			return false;
		} catch (Exception $e) {
			Debug::var_dump("Failed: " . $e->getMessage());
			Debug::print_backtrace();
			return false;
		}
		if ($this->result===false) {
			return false;
		}
		return $this->result;
	}

	/**
	 * Execute an sql command like insert or update
	 * @param unknown $cmd the SQL command to be executre
	 * @return number the number of rows affected
	 */
	public function exec($cmd) {
		$this->currentSQL = $cmd;
		try {
			$iAffected = $this->oPdo->exec($cmd);
		} catch (PDOException $err) {
			Debug::var_dump('Error while executing : <br>'.$this->currentSQL);
			Debug::print_backtrace();
			return false;
		} catch (Exception $e) {
			Debug::var_dump("Failed: " . $e->getMessage());
			Debug::print_backtrace();
			return false;
		}
		return $iAffected;
	}

	/**
	 * close the connection to the DB
	 */
	public function close() {
		$this->link = null;
	}
	
	/**
	 * Fetches the next row from a result set
	 * @param string $result the reust set from which to retrieve the next row
	 * @return mixed
	 */
	public function fetch($result = "") {
		if ($result == "") {
			$result = $this->result;
		} else {
			$this->result = $result;
		}

		try {
			$rec = $this->result->fetch(PDO :: FETCH_BOTH);
		} catch (PDOException $err) {
			Debug::var_dump('Error while executing : <br>'.$this->currentSQL);
			Debug::print_backtrace();
		} catch (Exception $e) {
			Debug::var_dump("Failed: " . $e->getMessage());
			Debug::print_backtrace();
		}
		return $rec;
	}


	/**
	 * @deprecated use fetch instead
	 * Fetch a result row as an associative an a numeric array
	 * @param string $result
	 * @return mixed
	 */
	public function fetch_array($result = "") {
		return $this->fetch($result);
	}

	/**
	 * Returns all column of all rows
	 * @param unknown $fetch_style
	 * @param number $column_index
	 */
	public function fetchAll($fetch_style = PDO :: FETCH_BOTH, $column_index = 0) {
		try {
			$resultset = $this->resulset->fetchAll($fetch_style, $column_index); 
		} catch (PDOException $err) {
			Debug::var_dump('Error while executing : <br>'.$this->currentSQL);
			Debug::print_backtrace();
		} catch (Exception $e) {
			Debug::var_dump("Failed: " . $e->getMessage());
			Debug::print_backtrace();
		}
		return $resultset;
	}

	/**
	 * returns the contents of one cell from a MySQL result set
	 * @param unknown $row
	 * @param unknown $field
	 * @param string $result
	 */
	public function getField($row, $field, $result = "") {
		if ($result == "") {
			$result = $this->result;
		}

		$data = $result->fetchAll();
		return $data[$row][$field];
	}


	/**
	 * @deprecated Use rowCount()
	 * Gets the number of rows in a result
	 * @param string $result
	 * @return number
	 */
	public function numRows($result = "") {
		if ($result == "") {
			$result = $this->result;
		}

		$data = $result->fetchAll();
		return count($data);
	}


	/**
	 * Get the number of field in a row of a result set
	 * @param string $result The result set
	 * @return number the number of field
	 */
	public function numFields($result = "") {
		if ($result == "") {
			$result = $this->result;
		}
		return $result->columnCount();
	}

	/**
	 * Get the name of a column
	 * @param unknown $field_index the 0 based position of the column
	 * @param string $result the name of the column
	 * @return Ambigous <>
	 */
	public function getFieldName($field_index, $result = "") {
		if ($result == "") {
			$result = $this->result;
		}
		$meta = $result->getColumnMeta($field_index);
		return $meta['name'];
	}

	/**
	 * Returns a string description of the last error
	 * @return string The error info
	 */
	public function error() {
		$error = $this->result->errorInfo();
		return $error[2];
	}

	/**
	 * Returns a string description of the last connect error
	 * @return string The error info
	 */
	public function connect_error() {
		$error = $this->result->errorInfo();
		return $error[2];
	}

	/**
	 * Gets the number of affected rows in a previous MySQL operation
	 * @return number the number of affected rows
	 */
	public function rowCount() {
		return $this->result->rowCount();
	}
	
	/**
	 * Frees the memory associated with a result
	 * @param string $result
	 */
	public function free_result($result = "") {
		if ($result == "") {
			$result = $this->result;
		}
		$result->closeCursor();
	}
	
	/**
	 * Start a transaction
	 */
	public function begin() {
		$this->link->beginTransaction();
	}
	
	/**
	 * Commit the current transaction
	 */
	public function commit() {
		$this->link->commit();
	}

	/**
	 * Rollback the current transaction
	 */
	public function rollback() {
		$this->link->rollBack();
	}
	
	/**
	 * Get the last inserted id
	 * @return string
	 */
	public function get_insert_id() {
		return $this->oPdo->lastInsertId();
	}
}
?>
