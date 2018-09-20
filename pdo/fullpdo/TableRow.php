<?php
/**
 * Class TableRow
 * @version 3.00
 * @author Pierre Delporte - pierre.delporte@alf-solution.be
 * @since 23/01/2008
 * @copyright 2008-2015
 * @example : www.alf-solution.be
 */
class TableRow extends data {

	/**
	 * Default construtcor
	 * @param string $tablename The name of the table
	 * @param string $dblink A link to the database connection
	 * @return TableRow
	 */
	function __construct($tablename='', $dblink='') {
		if (isset($tablename)) {
			$this->setTablename($tablename);
		}
		if (isset($dblink)) {
			$this->setDBLink($dblink);
		}
		//parent::__construct();
		//initialize bien default the ID to zero
		//$this->set('Id', 0);

		return $this;
	}

	/**
	 * Default destructor
	 */
	function __destruct(){
		if (isset($this->dblink))
			$this->dblink->close();
	}

	/**
	 * Default value use if the object is used as a string
	 * @return mixed
	 */
	public function __toString() {
		return $this->FieldName(1);
	}

	/**
	 * Save the row object into the table
	 * @return number|bool returns the id of the inserted or updated record if success, otherwise returns false
	 */
	public function save() {
		if ($this->getTablename()!='') {
			$dao = new Table($this->getTablename(), $this->getDblink());
			return $dao->save($this);
		}
		else {
			return false;
		}
	}

	/**
	 * Delete a record from a table
	 * @return bool true if successfully deleted, otherwise false  
	 */
	function delete() {
		if ($this->getTablename()!='') {
			$dao = new Table($this->getTablename(), $this->getDblink());
			return $dao->Delete($this->Id);
		}
		else
			return false;
	}

	/**
	 * Return the rows matching the columns criteria 
	 * @return Ambigous|boolean
	 */
	public function find(){
		if ($this->getTablename()!='') {
			$dao = new Table($this->getTablename(), $this->getDblink());
			return $dao->Find($this);
		}
		else
			return false;
	}

	/**
	 * Return the first rows of a query 
	 * @return Ambigous <>|boolean|Ambigous <boolean, Ambigous>
	 */
	public function findFirst(){
		$rows = $this->find();
		if ($rows !== false) {
			if ($rows->count() > 0){
				return $rows[0];
			}
			else
				return false;
		}
		else {
			return $rows;
		}
	}

}
?>
