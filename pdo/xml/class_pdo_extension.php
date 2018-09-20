<?php
class PDO_EXT extends PDO
{ 
/**
* Classe que extende a interface PDO 
* http://www.php.net/pdo
* @author Marcelo Soares da Costa
* @email phpmafia at yahoo dot com dot br
* @copyright Marcelo Soares da Costa © 2007. 
* @license FreeBSD http://www.freebsd.org/copyright/freebsd-license.html
* @version 1,1
* @access public
* @package PDO_EXT
* @subpackage 
* @data 2007-09-28
* @changelog Adicionado metodos para Transacao Simples
*/ 
function __construct() {
$DSN=RELDB.":host=".HOST.";dbname=".DATABASE;
parent::__construct($DSN, USER, PASSWORD);
}
/**
*
* Metodo publico para setar a query
* Decide o metodo de acordo com o tipo de SQL
* @access public
* @input SQL {string}
* @return Obj
*
*/
public function setsql($sqlstring) 
{ 
if($sqlstring==null)
{
throw new Exception("O valor passado para a função setsql não pode ser nulo",1000);
}
  switch($this->__querytype($sqlstring))
  {
  case "select";
	 return $this->__selectquery($this->__sql);
	 break;
  case "update";
	 return $this->__conditionalquery($this->__sql);
	 break;
  case "delete";
	 return $this->__conditionalquery($this->__sql);
	 break;
	case "insert";
	 return $this->__insertquery($this->__sql);
	 break;
  default:
    throw new Exception("Query não suportada => ".$sqlstring."\r\n<br/> => para executar este tipo de query é necessário utilizar um gerenciador de banco de dados",1001);
      break;
  }
} 
/**
*
* Metodo privado para setar a query
* Retira caracteres proibidos e retorna o tipo de query
* @access private
* @input SQL {string}
* @return tipo de query {string}
*
*/
private function __querytype($sqlstring)
{
  unset($this->__sql);
	unset($this->querytype);

	$array_injection=array("#","--","\\","//",";","/*","*/","drop","truncate");
	
   $this->__sql=trim(str_replace($array_injection,"",strtolower($sqlstring)));
	 
   list($this->querytype)= explode(" ",$this->__sql);
   
   return $this->querytype;
}
/**
*
* Metodo privado para query do tipo SELECT
* Prepara e executa SELECT
* @access private
* @input SQL {string}
* @return Obj
*
*/
private function __selectquery($sqlstring)
{
   $this->select=parent::prepare($sqlstring);
   $this->select->execute();
   return $this->select;

}
/**
*
* Metodo privado para query condicionais
* Executa query condicionais para query UPDATE e DELETE
* @access private
* Retorna o numero de resultados afetados
* @input SQL {string}
* @return numero de resultados afetados, number of affected rows, {string}
*
*/
private function __conditionalquery($sqlstring)
{
	 
  if(stripos($sqlstring, 'where') == false)
  {
  throw new Exception("Eh necessário a clausula WHERE para => ".$sqlstring,1005);
  }
  try {
	$result=parent::exec($sqlstring);
	return $result;
      } catch (PDOException $e) {
	    return $e->getMessage();
      }
}
/**
*
* Metodo privado para query do tipo INSERT
* Executa query INSERT e retorna o ID inserido
* @access private
* Retorna o numero ID inserido
* @input SQL {string}
* @return lastInsertId {string}
*
*/ 
private function __insertquery($sqlstring)
{
  try {
  $sth=parent::prepare($sqlstring);
  $sth->execute();
  $this->lastInsertId=parent::lastInsertId();
  return $this->lastInsertId;
	} catch (PDOException $e) {
   return $e->getMessage();

}
}
/**
*
* Metodo publico para retornar um array associativo
* Verifica se a query e um SELECT e retorna um array associativo
* @access public
* @input
* @return array
*
*/
public function getassocarray()
{
	unset($this->rows);
	unset($this->results);
 if($this->querytype=="select")
 {
	$this->results = array();

	while ($this->rows = $this->select->fetchAll(PDO::FETCH_ASSOC))
   {
    $this->results=$this->rows;
   }
			return $this->results;
 }else{
 throw new Exception("O método getassocarray é somente suportado em select",1010);
 }
}
/**
*
* Metodo publico para carregar uma sequencia de sql em array
* @access public
* Uso combinado com a funcao transaction
* Especifico para transacoes simples de insert ou update
* @input
* @return 
*
*/
public function addsql($sql) 
{ 
	$this->__sqltrans[] = $sql; 
} 
/**
*
* Metodo publico para executar uma transacoes simples de insert ou update
* @access public
* Uso combinado com a funcao addsql
* @input
* @return 
*
*/
public function transaction()
{
//var_export($this->__sqltrans);die();
if(is_array($this->__sqltrans))
  {
try {
  $this->transactionsql=parent::beginTransaction();
  foreach($this->__sqltrans as $sqlexec)
  {
  $this->transactionsql->exec($sqlexec);
  }
  $this->transactionsql=parent::commit();
  unset($this->__sqltrans);
  return $this->transactionsql;
   } catch (Exception $e) {
  parent::rollBack();
  return $e->getMessage();
   }
  }else{
  throw new Exception("Para efetuar uma transacao simples passe multiplos SQL com $objeto->addsql($sql)",1015);
  }
}

# FIM DA CLASSE
}

class PDOStatement_EXT extends PDOStatement {
}

/*
# Exemplo de uso
$SQL="SELECT * FROM table";
$teste = new PDO_EXT;
$teste->setsql($SQL); 
var_export($teste->getassocarray());
*/
