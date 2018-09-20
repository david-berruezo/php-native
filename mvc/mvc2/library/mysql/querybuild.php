<?php
class library_mysql_queryBuilder{
	private $con;
	private $query;
	
	public function __construct(mysqli $con){
		$this->con = $con;
	}
	
	private function buildWhere(array $mixed){
		$str = "";
		foreach($mixed as $key => $val){
			if(!is_string($val)){
				$str .= "`$key` = $val AND";
			}else{
				$str .= "`$key` = '$val' AND";
			}
		}
		return substr($str, 0, count($str)-4);
	}
	
	private function buildWhere(array $mixed){
		$str = "";
		foreach($mixed as $key => $val){
			if(!is_string($val)){
				$str .= "`$key` = $val, ";
			}else{
				$str .= "`$key` = '$val', ";
			}
		}
		return substr($str, 0, count($str)-2);
	}
	
	public function select(string $what, string $from, array $where){
		$str_where = $this->buildWhere($where);
		$this->query = "SELECT $what FROM `$from` WHERE ".(($str_where == "")? $str_where:"1=1")." ";
		return $this;
	}
	
	public function insert(array $what, string $to){
		$this->query = "INSERT INTO `$to` SET ".$this->buildSet($what)." ";
		return $this;
	}
	
	public function update(string $table, array $what, array $where){
		$str_where = $this->buildWhere($where);
		$this->query = "UPDATE `$table` SET ".$this->buildSet($what)." WHERE ".(($str_where == "")? $str_where:"1=1")." ";
		return $this;
	}
	
	public function delete(string $from, array $where){
		$str_where = $this->buildWhere($where);
		$this->query = "DELETE FROM `$from` WHERE ".(($str_where == "")? $str_where:"1=1")." ";
		return $this;
	}
	
	public function orderby(string $row, string $mode){
		if($mode != "DESC" && $mode != "ASC"){
			trigger_error("Order by mode can only been 'DESC'(decending) or 'ASC'(ascending)", E_WARNING);
		}
		$this->query .= "ORDER BY `$row` $mode ";
		return $this;
	}
	
	public function limit(int $count, int $start = 0 ){
		$this->query .= "LIMT $start, $count ";
		return $this;
	}
	
	public function exec(string $mode){
		switch($mode){
			case "getString":
				return $this->query;
			break;
			case "getRows":
				$result = $this->con->query($this->query) or trigger_error($this->con->error);
				$rows = array();
				if($result->num_rows > 0) {
					while($row = $result->fetch_assoc()){
						$rows[] = $row;
					}
				}else{
					trigger_error("no results to return", E_WARNING);
					return array();
				}
				return $rows;
			break;
			case "getRow":
				$result = $this->con->query($this->query) or trigger_error($this->con->error);
				$rows = array();
				if($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					$rows[] = $row;
				}else{
					trigger_error("no results to return", E_WARNING);
					return array();
				}
				return $rows;
			break;
			default:
				try{
					$result = $this->con->query($this->query) or trigger_error($this->con->error);
					return $result->$mode;
				}catch(Exception $e){
					trigger_error("Unknown database execute command");
					return;
				}
			break;
		}
	}
}
?>