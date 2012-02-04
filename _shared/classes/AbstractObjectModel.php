<?php

/**
 * Abstract class to acces various objects in database
 *
 * @author stoneflash
 */
abstract class AbstractObjectModel {
	
	/**
	 * Integer ID value in database
	 * @var int
	 */
	private $id;

	/**
	 * return value of object's ID
	 * @return int
	 */
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		if ($this->id != 0)
			throw Exception;
		
		$this->id = intval($id);
	}

	/**
	 * array of params values (as in static $paramsList or not)
	 * @var array
	 */
	public $paramValues;
	
	function __construct($id = NULL) {
		if ($id instanceof AbstractObjectModel) {
			$this->id = $id->getId();
			$this->paramValues = $id->paramValues;
			return;
		}
		
		if ($id == NULL || $id == 0){
			$this->id = 0;
			$this->fillParams(array());
			return;
		}
		
		$id = intval($id);

		$q = "SELECT * FROM `".$this->_getTableName()."` WHERE `id` = '".$id."' ";
		$r = M::su($q);
		
		if (!$r) return;
		$this->id = (int) $id;
		
		$this->fillParams($r);
	}

	/**
	 *
	 * @param	array	$params	List of parameters to set to object
	 * @return unknown_type
	 */
	public function fillParams($params){
		if ($params == null){
			return;
		}
		
		foreach ($params as $parameterName => $parameterValue){
			foreach ($this->getParamsList() as $parameterBase){
				if ($parameterBase['name'] == $parameterName){
					// parameter found
					
					switch ($parameterBase['type']){
						case 'boolean':
						case 'int':
						case 'select':
							$this->paramValues[$parameterName] = intval($parameterValue);
						break;
						
						case 'date':
							if (is_numeric($parameterValue))
								$this->paramValues[$parameterName] = $parameterValue;
							else{
								$this->paramValues[$parameterName] = DateUtils::fromDate($parameterValue);
							}
						break;
						
						case 'tinymce':
						case 'string':
							$this->paramValues[$parameterName] = $parameterValue;
						break;
						
						default:
							if ($parameterValue instanceof AbstractObjectModel)
								$this->paramValues[$parameterName] = $parameterValue->getId();
							else{
								$force = false;
								
								if ($force){
									$rClass = new ReflectionClass($parameterBase['type']);
					        		$rClass = $rClass->newInstance($parameterValue);
									
									$this->paramValues[$parameterName] = $rClass;
								}else{
									$this->paramValues[$parameterName] = $parameterValue;
								}
							}
						break;	
					}
				}
			}
		}
		
		//print_r(	$this->paramValues);
	}

	/**
	 * check is object exists in database or new
	 *
	 * @return boolean
	 */
	public function isExists(){
		return $this->getId() != 0;
	}

	/**
	 * insert record in database and return
	 * insert_id if present or zero if not
	 *
	 * @return int
	 */
	public function create(){
		if ($this->isExists())
			return;
		
		$query = "INSERT INTO `".$this->_getTableName()."` ".
					$this->_prepareSqlToInsert();
		
		if (!M::q($query)){
			print_r(M::e());
			exit();
		}
		
		$this->id = M::lastId();

		return intval($this->getId());
	}


	public function update () {

		if (!$this->isExists()) {
			return false;
		}
		
		$q = "UPDATE `".$this->_getTableName()."` SET ".
					$this->_prepareSqlWithParams().
					" WHERE `id` = ".$this->getId();
		
		if (M::q($q))
			return true;
		else
			return false;
	}
	
	public function saveOrUpdate () {
		if (!$this->isExists()) {
			return $this->create();
		}else{
			return $this->update();
		}
	}

	public function delete(){
		if (!$this->isExists())
			return false;

		M::q("DELETE FROM `".$this->_getTableName()."`".
					"WHERE `id` = ".$this->getId());
		
		$this->id = 0;
		
		return true;
	}
	
	public function selectAll($query = NULL){
		
		$q = "SELECT * FROM `".$this->_getTableName()."`";
		
		if ($query != NULL){
			$q .= " ".$query;
		}
		
		$return = array();
		
		$res = M::s($q);
		
        $rClass = new ReflectionClass(get_class($this));
		
        if ($res)
		foreach($res as $rRow) {
			$obj = $rClass->newInstance($rRow['id']);
			$obj->fillParams($rRow);
			$return[] = $obj;
		}
		
		return $return;
	}
	
	public function selectAllCount($query = NULL){
		$q = "SELECT count(*) FROM `".$this->_getTableName()."`";
		
		if ($query != NULL){
			$q .= " ".$query;
		}
		
		$res = M::su($q);
		
		return $res[0];
	}
	
	private function _prepareSqlWithParams(array $params = null){
		if ($params == null)
			$params = $this->paramValues;

		$values = array();

		foreach ($this->getParamsList() as $paramName){
			switch ($paramName['type']){
				case 'boolean':
				case 'int':
				case 'string':
				case 'date':
				case 'tinymce':
				case 'photo':
				case 'select':
					$values[] = "`".$paramName['name']."` = '".@($params[$paramName['name']])."'";
				break;
				
				default:
					if (isset($params[$paramName['name']]) && $params[$paramName['name']] instanceof AbstractObjectModel){
						$values[] = "`".$paramName['name']."` = '".$params[$paramName['name']]->getId()."'";	
					}else{
						$values[] = "`".$paramName['name']."` = '".@($params[$paramName['name']])."'";
					}
				break;	
			}
		}
		
		return implode(","."\n",$values);
	}
	
	private function _prepareSqlToInsert(array $params = null){
		if ($params == null)
			$params = $this->paramValues;
		
		$paramNames = array();
		$values = array();

		foreach ($this->getParamsList() as $paramName){
			$paramNames[] = "`".$paramName['name']."`";
			
			switch ($paramName['type']){
				case 'boolean':
				case 'int':
				case 'string':
				case 'date':
				case 'tinymce':
				case 'photo':
				case 'select':
					$values[] = "'".@($params[$paramName['name']])."'";
				break;
				
				default:
					if (isset($params[$paramName['name']]) && $params[$paramName['name']] instanceof AbstractObjectModel){
						$values[] = "'".$params[$paramName['name']]->getId()."'";	
					}else{
						$values[] = "'".@($params[$paramName['name']])."'";
					}
				break;	
			}
		}

		return	"(".implode(","."\n",$paramNames).")".
				" VALUES (".implode(","."\n",$values).")";
	}
	
	public function _getTableName(){
		global $GLOBAL_CONFIG;
		return $GLOBAL_CONFIG['db']['tablePrefix'].$this->TABLE_NAME;
	}
	
	public function getParamsList() {
		return $this->paramsList;
	}
	
	public function getFullParams(){
		$arr = array();
		$arr = $this->paramValues;
		$arr['id'] = $this->getId();
		return $arr;
	}
	
	public function getParamByName($name){
		foreach ($this->getParamsList() as $paramName){
			if ($paramName['name'] == $name)
				return $paramName;
		}
	}
	
	public function __get($name) {
        if (array_key_exists($name, $this->paramValues)) {
            
        	$param = $this->getParamByName($name);
        	
			switch ($param['type']){
				case 'boolean':
				case 'int':
				case 'photo':
				case 'select':
				case 'date':
				case 'tinymce':
				case 'string':

				break;
				
				default:
					if (!($this->paramValues[$name] instanceof AbstractObjectModel)){
						$rClass = new ReflectionClass($param['type']);
		        		$this->paramValues[$name] = $rClass->newInstance($this->paramValues[$name],true);
					}
				break;
			}
			
			return $this->paramValues[$name];
        }
		
        $trace = debug_backtrace();
        echo 'No property "' . $name  . '" of object "' . get_class($this)  . '" in file ' . $trace[0]['file'] . ' on line ' . $trace[0]['line'];
        exit;
    }
    
	public function __set($name, $value) {
		foreach($this->getParamsList() as $paramName) {
        
		if ($paramName['name'] == $name){
			switch ($paramName['type']){
					case 'boolean':
					case 'int':
					case 'photo':
					case 'select':
						$this->paramValues[$name] = intval($value);
					break;
					
					case 'date':
						if (is_numeric($value))
							$this->paramValues[$name] = $value;
						else{
							$this->paramValues[$name] = DateUtils::fromDate($value);
						}
					break;
					
					case 'tinymce':
					case 'string':
						$this->paramValues[$name] = $value;
					break;
					
					default:
						if ($value instanceof AbstractObjectModel)
							$this->paramValues[$name] = $value;
						else{
							$rClass = new ReflectionClass($paramName['type']);
			        		$rClass = $rClass->newInstance($value);
							
							$this->paramValues[$name] = $rClass;
						}
					break;
				}
				
				return $this->paramValues[$name];
			}
        }
		
        $trace = debug_backtrace();
        echo 'No property "' . $name  . '" of object "' . get_class($this)  . '" in file ' . $trace[0]['file'] . ' on line ' . $trace[0]['line'];
        exit;
    }
    
    
    public function imgExists(){
    	return file_exists('./upload/'.get_class($this).'/'.$this->getId().'.jpg');
    } 
	
}