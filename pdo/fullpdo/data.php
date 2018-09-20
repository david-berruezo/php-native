<?php
/**
 * Class data to handle the values of a table (collection of TableRow)
 * @version 3.00
 * @author Pierre Delporte - pierre.delporte@alf-solution.be http://www.alf-solution.be
 * @since 23/01/2008
 * @copyright 2008-2015
 */
abstract class data implements SeekableIterator, ArrayAccess, Countable {

	protected $_position; // the position with the table of values
	public $array_value = array(); // the table with all values
	private $_tablename; // the name of the table
	private $dblink; // a link to the databse information
	protected $array_operator = array(); // the table with the comparison operators
	protected $array_andor = array(); // the table with the logical operators
	protected $orderBy; // order by clause

	/**
	 * Default constructor
	 */
	public function __construct() {
		$this->_position = 0;
		$this->array_value = array();
		$this->array_operator = array();
		$this->andor = array();
	}

	/**
	 * Return the element at the current position
	 * @return mixed
	 */
	public function current(){
		return $this->array_value[$this->_position];
	}

	/**
	 * Return the current position
	 * @return int
	 */
	public function key(){
		return $this->_position;
	}

	/**
	 * Move the current position to the next element
	 */
	public function next(){
		$this->_position++;
		if ($this->_position > $this->count()){
			$this->_position = $this->count();
		}
	}

	/**
	 * Move the position to the first element
	 */
	public function rewind(){
		$this->_position = 0;
	}

	/**
	 * Move the current position to the previous position
	 */
	public function previous() {
		$this->_position--;
		if ($this->_position < 0){
			$this->_position = 0;
		}
	}

	/**
	 * Move the current position to position $_position
	 * @param int $_position
	 */
	public function seek($_position) {
		$savedPosition = $this->_position;
		$this->_position = $_position;
		if (!$this->valid()) {
			$this->_position = $savedPosition;
		}

	}


	/**
	 * check if the current position is valid with the table of values
	 * @return bool
	 */
	public function valid()
	{
		return isset($this->array_value[$this->_position]);
	}

	/**
	 * Check if the key exists
	 * @param mixed $key
	 * @return bool
	 */
	public function offsetExists($key){
		return isset($this->array_value[$key]);
	}

	/**
	 * Return the value of the key
	 * @param mixed $key
	 * @return mixed
	 */
	public function offsetGet($key){
		return $this->array_value[$key];
	}

	/**
	 * Set the value to the key
	 * @param mixed $key
	 * @param mixed $value
	 */
	public function offsetSet($key, $value){
		$this->array_value[$key] = $value;
	}

	/**
	 * Delete the specified key
	 * @param mixed $key
	 */
	public function offsetUnset($key){
		unset($this->array_value[$key]);
	}

	/**
	 * Return the number of field
	 * @return int
	 */
	public function count(){
		return $this->columns();
	}

	/**
	 * Return the number of columns
	 * @return int the number of columns
	 */
	public function columns() {
		if (!is_array($this->array_value)){
			return 0;
		} else {
			return count($this->array_value);
		}
	}

	/**
	 * Return the field name at position $_position
	 * @param string $_position
	 * @return mixed
	 */
	public function FieldName($_position='') {
		if (!isset($_position)) {
			$_position = $this->_position;
		}
		$arr_keys = array_keys($this->array_value);
		return $arr_keys[$_position];
	}

	/**
	 * Return the field name at position $_position
	 * @param $_position
	 * @return mixed
	 */
	public function getFieldName($_position) {
		if (!isset($_position)) {
			$_position = $this->_position;
		}
		$arr_keys = array_keys($this->array_value);
		return $arr_keys[$_position];
	}

	/**
	 * Set the name of the table
	 * @param $_tablename
	 */
	public function setTablename($_tablename) {
		$this->_tablename = $_tablename;
	}

	/**
	 * Get the name of the table
	 * @return mixed
	 */
	public function getTablename() {
		return $this->_tablename;
	}

	/**
	 * Get the link to the db
	 * @return mixed
	 */
	public function getDblink() {
		return $this->dblink;
	}

	/**
	 * Set the link to the db
	 * @param $dblink
	 */
	public function setDBLink($dblink){
		$this->dblink = $dblink;
	}

	/**
	 * Set the order by clause
	 * @param $orderby
	 */
	public function orderBy($orderby){
		$this->orderBy = $orderby;
	}

	/**
	 * Return the order by clause
	 * @return mixed
	 */
	public function getOrderBy(){
		return $this->orderBy;
	}

	/**
	 * Set the value for a specified key (field)
	 * @param $key the field name
	 * @param $value the value to be set
	 * @param string $operator the comparison operator, by default "="
	 * @param string $andor the logical operator, by default "AND"
	 */
	public function set($key, $value, $operator = '=', $andor = 'AND') {
		if (is_numeric($key))
		{
			$arr_keys = array_keys($this->array_value);
			$this->array_value[$arr_keys[$key]] = $value;
			$this->array_operator[$arr_keys[$key]] = $operator;
			$this->array_andor[$arr_keys[$key]] = $andor;
		}
		else {
			$key = ucfirst(strtolower($key));
			$this->array_value[$key] = $value;
			$this->array_operator[$key] = $operator;
			$this->array_andor[$key] = $andor;
		}
	}

	/**
	 * Return true if the $key (column position or fieldname) exists
	 * @param $key the field key
	 * @return bool
	 */
	public function Exists($key) {
		if (is_numeric($key)) {
			if ($key < $this->columns() && $key >= 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return array_key_exists(ucfirst(strtolower($key)), $this->array_value);
		}
	}

	/**
	 * Return the value of the column specified by $key
	 * @param $key the key
	 * @return string The value of the key
	 * @throws Exception
	 */
	public function getValue($key) {

		if (is_numeric($key)) {
			$arr_values = array_values($this->array_value);
			return $arr_values[$key];
		}
		else {
			$key = ucfirst(strtolower($key));
			if (array_key_exists($key, $this->array_value)) {
				return ($this->array_value[$key]);
			} else {
				return $key.' not exists in table '.$this->_tablename;
			}
		}
		throw new Exception('Definition not found for '.$key);

	}

	/**
	 * Return the comparison operator for the specified key
	 * @param $key
	 * @return mixed
	 * @throws Exception
	 */
	public function getOperator($key) {
		if (is_numeric($key)) {
			$arr_values = array_values($this->array_operator);
			return $arr_values[$key];
		}
		else {
			$key = ucfirst(strtolower($key));
			if (array_key_exists($key, $this->array_operator)) {
				return ($this->array_operator[$key]);
			}
		}
		throw  new Exception('Definition not found for '.$key);
	}

	/**
	 * Return the logical operator (AND or OR) for the specified key
	 * @param $key
	 * @return mixed
	 * @throws Exception
	 */
	public function getAndor($key) {
		if (is_numeric($key)) {
			$arr_values = array_values($this->array_andor);
			return $arr_values[$key];
		}
		else {
			$key = ucfirst(strtolower($key));
			if (array_key_exists($key, $this->array_andor)) {
				return ($this->array_andor[$key]);
			}
		}
		throw  new Exception('Definition not found for '.$key);
	}

	public function get_enum() {
		return array_keys($this->array_value);
	}

	/**
	 * Return a string containing all fields and their values separated by an equal sign ('=')
	 * @return string
	 */
	public function Dump(){
		$dump = '';
		foreach ($this->array_value as $key => $value){
			$dump .= $key. ' = '.($value==null)?'<NULL>':$value.'<br/>';
		}
		return $dump;
	}

	/**
	 * Return the whole record
	 * @return array
	 */
	public function getRow(){
		return $this->array_value;
	}

	/**
	 * magic function to return the value of a field
	 * @param unknown $key variable name
	 * @return Ambigous <string, multitype:>
	 */
	public function __get($key) {
		$action = substr($key, 0, 3);
		if ($action == 'get')
			$key = substr($key, 3);
		return $this->getValue($key);
	}

	/**
	 * magic function to set a valtue to a field
	 * @param unknown $key variable name
	 * @param unknown $value value to assign
	 */
	public function __set($key, $value) {
		//echo $key.' '.$value.'<br>';
		$action = substr($key, 0, 3);
		if ($action == 'set')
			$key = substr($key, 3);
		return $this->set($key, $value);
	}

	/**
	 * This magic method is invoked each time a nonexistent method is called on the object
	 * @param unknown $func the name of the function
	 * @param unknown $args the parameters of the function
	 * @throws Exception Exception thrown
	 * @return Ambigous <string, multitype:>|boolean
	 */
	public function __call($func, $args) {
		$action = substr($func, 0, 3);
		$key = substr($func, 3);
		switch($action){
			case 'set':
				if (isset($args[0])) {
					return $this->set($key, $args[0]);
				} else {
					return $this->set($key, '');
				}
				break;
			case 'get':
				if ($key == ''){
					$key = $args[0];
				}
				if (is_numeric($key)){
					return $this->getValue($key);
				} else {
					if (array_key_exists(ucfirst(strtolower($key)), $this->array_value)) {
						return $this->getValue($key);
					} else {
						print_r($this->array_value);
						throw new Exception('Undefined properties '.$key);
					}
				}
				break;
			case 'del':
				if (isset($this->array_value[$key])) {
					unset($this->array_value[$key]);
				}
				else {
					print_r($this->array_value);
					throw new Exception('Undefined properties '.$key);
				}
				break;
			case 'Exi':
				//echo 'Exi';
				return $this->Exists($key);
				break;
			case 'ord':
				return $this->orderBy($key);
				break;
			default: {
				echo 'action = '.$action;
				print_r($this->array_value);
				throw
				new Exception('Undefined function ***'.$func);
			}
		}
	}
}

?>
