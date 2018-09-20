<?php
/**
 * Class Table
 * @version 3.10
 * @author Pierre Delporte - pierre.delporte@alf-solution.be
 * @since 23/01/2008
 * @copyright 2008-2015
 * @example : www.alf-solution.be
 */
class Table {
	public $dblink;
	public $tablename;

	/**
	 * Default constructor
	 * @param DB $dblink
	 * @param string $tablename
	 * @return TableData|TableDAO
	 */
	function __construct($tablename='', $dblink=''){
		if (empty($dblink) || $dblink=='') {
			/*
			$this->dblink = new DB(HOST, USER, PASSWORD, DBNAME);
			$this->dblink->setTypeDB(TYPEDB);
			$this->dblink->connect(HOST, USER, PASSWORD, DBNAME);
			*/
			$this->dblink = DB::getInstance(HOST, USER, PASSWORD, DBNAME);
		} else {
			$this->dblink = $dblink;
		}

		if (isset($tablename)) {
			$this->tablename = $tablename;
			return new TableRow($tablename, $this->dblink);
		} else {
			return $this;
		}
	}

	function __destruct(){
		$this->dblink->close();
	}

	public function __sleep()
	{
		return array('dblink', 'tablename');
	}

	public function __wakeup() {

	}

	/**
	 * Static function to retrieve a record from a specified table based on an id
	 * @param DB $dblink the connection object to the database
	 * @param string $tablename the name of the table
	 * @param int $id the unique id of the record to be retrieved
	 * @deprecated use FetchById
	 */
	public static function GetById($dblink, $tablename, $id){
		$data = new Table($tablename, $dblink);
		return $data->LoadByID($id);
	}

	/**
	 * Static function to retrieve a rechord from specified table for a specific id
	 * @param string $tablename the name of the table
	 * @param int $id the unique id of the record to be retrieved
	 */
	public static function FetchById($tablename, $id){
		$data = new Table($tablename);
		return $data->LoadByID($id);
	}

	/**
	 * Delete a record from the table $tablename
	 * @param $tablename the name of the table
	 * @param $id the uniek identifier of the record to be deleted
	 * @return bool
	 */
	public static function DeleteById($tablename, $id){
		$data = new Table($tablename);
		return $data->Delete($id);
	}

	/**
	 * return the record corresponding to the $id or false if not found
	 * @param int $id the unique identifier of the record to be retrieved
	 * @return the record if found, otherwise false
	 */
	public function LoadByID($id){
		if ($this->tablename != ''){
			$listtable = $this->Query("select * from $this->tablename where id = $id", $this->tablename);
			if (count($listtable) == 1) {
				return $listtable[0];
			}
			else {
				return false;
			}
		}
		else
		{
			echo 'tablename not defined';
			return false;
		}
	} //end of function LoadByID

	/**
	 * Find all record based on a TableRow object
	 * @param TableRow $obj
	 * @return Ambigous <boolean, unknown>|boolean
	 * @see TableRow
	 */
	public function Find($obj) {
		if (!empty($obj) && $obj != null){
			$whereclause = 'WHERE ';
			$this->tablename = $obj->getTablename();
			for ($iCol=0; $iCol < $obj->columns(); $iCol++) {
				if ($iCol != 0)
				{
					$whereclause .= ' '.$obj->getAndor($iCol).' ';
				}
				$fieldname = strtolower($obj->FieldName($iCol));
				$whereclause .= '`'.$fieldname.'` '.$obj->getOperator($iCol)." '";
				$whereclause .= preg_replace("/'/", "''", $obj->get($iCol))."'";
			}
			$orderby = $obj->getOrderBy();
			if (!empty($orderby) && $orderby != ''){
				$whereclause .= ' ORDER BY '.$obj->getOrderBy();
			}
			return $this->Load($whereclause);
		} else {
			return false;
		}
	}

	/**
	 * Retrieve the rows from a table 
	 * @param string $whereclause The where clause to filter the rows
	 * @return Ambigous <boolean, unknown>|boolean
	 */
	public function Load($whereclause = "") {
		if ($this->tablename != '') {
			try {
				return $this->Query("select * from $this->tablename $whereclause", $this->tablename);
			} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return false;
			}

		}
		else
		{
			return false;
		}
	} //end of function Load

	/**
	 * Frees the memory associated with a result
	 * @param string $tablename The name of the table
	 * @param string $where The where clause
	 * @return Ambigous
	 */
	public static function Fetch($tablename, $where="") {
		$table = new Table($tablename);
		return $table->Load($where);
	}

	/**
	 * Return the first row matching the where clause for the table 
	 * @param string $tablename The name of the table
	 * @param string $where the where clause
	 * @return Ambigous|boolean An object TableRow, of false if not successfull
	 */
	public static function FetchFirst($tablename, $where=""){
		$table = new Table($tablename);
		$rows =  $table->Load($where);
		if ($rows !==false && $rows->count() > 0){
			return $rows[0];
		} else {
			return false;
		}
	}

	/**
	 * Search $dblink for the query
	 * @deprecated should use Select instead
	 * @param unknown_type $dblink
	 * @param unknown_type $query
	 */
	public static function Search($dblink, $query){
		$data = new Table();
		return $data->Query($query);
	}

	/**
	 * Execute the query
	 * @param unknown $query The sql query to be executed
	 * @return Ambigous <boolean, unknown>
	 */
	public static function Select($query){
		$data = new Table();
		return $data->Query($query);
	}

	/**
	 * Execute an sql command like insert or update
	 * @param string The commande to be executed
	 * @return number the number of rows affected  
	 */
	public static function Execute($cmd) {
		$exec = new Table();
		return $exec->dblink->exec($cmd);
	}

	/**
	 * Execute the query and return a resulset
	 * @param string the query to be executed
	 * @param string the name of the table
	 * @return array of TableRow|TableRow|bool
	 */
	public function Query($query, $tablename='') {
		if ($query != '') {
			$listtable = new TableRow($tablename, $this->dblink);
			try {
				$res = $this->dblink->query($query);
				if ($res===false) {
					return false;
				}
			} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				$e->getTraceAsString().'<br>';
				throw new Exception('Table.Query : '.$query);
			}
			$iPos = 0;
			try {
				$res->setFetchMode(PDO::FETCH_CLASS, 'TableRow', array($tablename, $this->dblink));
				while ($table = $res->fetch()) {
					$table->setTablename($tablename);
					$table->setDBLink($this->dblink);
					$listtable[$iPos] = $table;
					$iPos++;
				}
			} catch (Exception $e) {
				throw new Exception('Table.Query.Fetch : '.$query);
			}
			if ($iPos==0) {
				$listtable->offsetUnset(0);
			}
			return $listtable;
		} else {
			return false;
		}
	} //end of function Query

	// Del an element from the table
	/**
	 * Delete a record from a table
	 * @param string the uniek id of the record to be deleted
	 * @return bool true if successfully deleted, otherwise false
	 */
	public function Delete($id){
		if ($this->tablename != '' && $id != ''){
			$res = $this->dblink->query("delete from $this->tablename where id = '".$id."'");
			if ($res !== false)
				return true;
			else
				return false;
		}
		else {
			return false;
		}
	}

	/**
	 * insert of update a row into a table
	 * @param TableRow an object TableRow with the data to be saved
	 * @return bool false if not successfull, otherwise the ID of the saved record
	 */
	public function Save($tablerow) {
		//if no ID is specified (value NULL or = 0) then create a new record
		if ($tablerow->Id != "" && $tablerow->Id != '0') {
			return $this->Update($tablerow);
		} else {
			return $this->Insert($tablerow);
		}
	}

	/**
	 * insert an element into the table
	 * @param string the name of the table
	 * @return bool false if not successfull, otherwise the ID of the inserted record
	 */
	private function Insert($tablerow){
		if ($this->tablename != '')	{
			$insert = 'insert into `'.$this->tablename.'` (';
			$insert_value = 'values (';
			for ($iCol=0; $iCol < $tablerow->columns(); $iCol++)
			{
				if ($iCol != 0)
				{
					$insert .= ',';
					$insert_value .= ',';
				}
				$fieldname = strtolower($tablerow->FieldName($iCol));
				$insert .= '`'.$fieldname.'`';

				$fieldvalue = $tablerow->get($iCol);

				if (is_numeric($fieldvalue)) {
					$insert_value .= $fieldvalue;
				} else {
					if ($fieldvalue== '' || $fieldvalue == '0000-00-00') {
						$insert_value .= 'null';
					} else {
						$insert_value .= '\''.preg_replace("/'/", "''", $fieldvalue).'\'';
					}
				}
			}

			$insert .= ') ';
			$insert_value .= ')';

			$res = $this->dblink->exec($insert.$insert_value);
			if ($res === false)
				return false;
			else
				return $this->dblink->get_insert_id();
		}
		return false;
	} //End of insert an element into the table

	/**
	 * Update a record
	 * @param TableRow An object of type TableRow with the data of the record to be updated
	 * @return bool false if not successfull, otherwise the ID of the saved record
	 */
	private function Update($tablerow){
		if ($this->tablename != '')
		{
			$update = 'update `'.$this->tablename.'` set ';

			for ($iCol=0; $iCol < $tablerow->columns(); $iCol++)
			{
				if ($iCol != 0)
				{
					$update .= ',';
				}
				$fieldname = strtolower($tablerow->FieldName($iCol));
				$fieldvalue = $tablerow->get($fieldname);
				if (is_numeric($fieldvalue)) {
					$update .= '`'.$fieldname.'` = '.$fieldvalue;
				} else {
					if ($fieldvalue== '' || $fieldvalue == '0000-00-00') {
						$update .= '`'.$fieldname.'` = null';
					} else {
						$update .= '`'.$fieldname.'` = '.'\''.preg_replace("/'/", "''", $fieldvalue).'\'';
					}
				}
			}
			$update .= ' where id = '.$tablerow->Id.';';

			$res = $this->dblink->exec($update);

			if ($res === false)
				return false;
			else
				return $tablerow->Id;
		}
		return false;
	} //End of insert an element into the table

}
?>