<?php
/**
 * @author		David Curras
 * @version		May 28, 2013
 * @filesource		/Models/ProcessModel.php
 */

class ProcessModel extends AbstractModel {

	/**
	 * Saves the Process in the Data Base
	 * 
	 * @param		Process		$process
	 * @static
	 */
	public static function Save(&$process){
		$id = $process->getId();
		$properties = array(
				"typeId" => $process->getType()->getId(),
				"stateId" => $process->getState()->getId(),
				"processDate" => Date::ParseDate($process->getProcessDate()),
				"bundleId" => null,
				"issues" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($process->getIssues()), ENT_COMPAT, self::$Charset, false) : htmlentities($process->getIssues(), ENT_COMPAT, self::$Charset, false)
			);
		if(is_object($process->getBundle())){
			$properties["bundleId"] = $process->getBundle()->getId();
		}
		$emptyValues = '';
		if(empty($properties["typeId"])){
			$emptyValues .= ' typeId';
		}
		if(empty($properties["stateId"])){
			$emptyValues .= ' stateId';
		}
		if(empty($properties["processDate"])){
			$emptyValues .= ' processDate';
		}
		if(empty($emptyValues)){
			$query = new Query();
			if(!empty($id) && is_int($id)){
				$query->createUpdate('processes', $properties, 'id = "'.$id.'"', true);
				$isExecuted = $query->execute();
				if(!$isExecuted){
					throw new Exception('Unable to update Process "'.$id.'" in database. (ProcessModel::save())');
				}
			} else {
				$query->createInsert('processes', $properties, true);
				$isExecuted = $query->execute();
				if($isExecuted){
					//get the last inserted id
					$query->createSelect(array('MAX(id) as id'), 'processes');
					$value = $query->execute();
					$process->setId($value['id']);
				} else {
					throw new Exception('Unable to insert Process in database. (ProcessModel::save())');
				}
			}
		} else {
			throw new Exception('Unable to save Process with empty required values:'.$emptyValues.'. (ProcessModel::save())');
		}
		return true;
	}

	/**
	 * Finds a Process by id
	 * 
	 * @param		int		$id
	 * @return		Process
	 * @static
	 */
	public static function FindById($id){
		$query = new Query();
		$query->createSelect(array('*'), 'processes', array(), 'id = "'.$id.'"');
		$processArray = $query->execute();
		$process = false;
		if(!empty($processArray)){
			$process = self::CreateObjectFromArray($processArray);
		}
		return $process;
	}

	/**
	 * Finds stored Processes by specific values
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Process
	 * @static
	 */
	public static function FindBy($params, $expectsOne=false){
		$processesArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			$where = '';
			if(is_array($params['where'])){
				//TODO: Use Query::Make() !!!
				$whereArray = array();
				foreach ($params['where'] as $key => $value){
					if(!empty($value)){
						$parsedValue = self::$IsUsingUtf8 ? htmlentities(utf8_decode($value), ENT_COMPAT, self::$Charset, false) : htmlentities($value, ENT_COMPAT, self::$Charset, false);
						array_push($whereArray, $key.' = "'.$parsedValue.'"');
					}
				}
				$where = implode(' AND ', $whereArray);
			} else {
				$where = trim($params['where']);
			}
			$orderBy = array();
			if(!empty($params['orderBy'])){
				$orderBy = implode(',', $params['orderBy']);
			}
			$limit = '';
			if(!empty($params['from'])){
				$limit = ''.$params['from'];
				if(!empty($params['amount'])){
					$limit .= ', '.$params['amount'];
				} else {
					$limit .= ', 10';
				}
			}
			$query = new Query();
			$query->createSelect(array('*'), 'processes', null, $where, $orderBy, $limit);
			$arrayArraysProcess = $query->execute(true);
			if(!empty($arrayArraysProcess)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysProcess[0]);
				}
				foreach($arrayArraysProcess as $arrayProcess){
					array_push($processesArray, self::CreateObjectFromArray($arrayProcess));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid argument passed, expects param to be Array in ProcessModel::FindBy()');
		}
		return $processesArray;
	}

	/**
	 * Finds stored Processes by multiple values of an specific field
	 * 
	 * @param		array|string		$params
	 * @return		array|Process
	 * @static
	 */
	public static function FindByMultipleValues($params, $expectsOne=false){
		$processesArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			//TODO: Use Query::Make() !!!
			$whereArray = array();
			foreach ($params['where'] as $key => $value){
				if(!empty($value) && is_array($value)){
					array_push($whereArray, $key.' IN ('.implode(', ', $value).')');
				} else {
					throw new Exception('Invalid param, array expected in ProcessModel::FindByMultipleValues()');
				}
			}
			$where = implode(' OR ', $whereArray);
			$orderBy = array();
			if(!empty($params['orderBy'])){
				$orderBy = implode(',', $params['orderBy']);
			}
			$limit = '';
			if(!empty($params['from'])){
				$limit = ''.$params['from'];
				if(!empty($params['amount'])){
					$limit .= ', '.$params['amount'];
				} else {
					$limit .= ', 10';
				}
			}
			$query = new Query();
			$query->createSelect(array('*'), 'processes', null, $where, $orderBy, $limit);
			$arrayArraysProcess = $query->execute(true);
			if(!empty($arrayArraysProcess)){
				foreach($arrayArraysProcess as $arrayProcess){
					array_push($processesArray, self::CreateObjectFromArray($arrayProcess));
				}
			}
		} else {
			throw new Exception('Invalid param, array expected in ProcessModel::FindByMultipleValues()');
		}
		return $processesArray;
	}

	/**
	 * Finds stored Processes by related Type properties
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Process
	 * @static
	 */
	public static function FindByTypeProperties($params, $expectsOne=false){
		$processesArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			$selectFields = array(
					'processes.id',
					'processes.typeId',
					'processes.stateId',
					'processes.processDate',
					'processes.bundleId',
					'processes.issues'
				);
			$joinArray = array('types'=>'types.id = processes.typeId');
			$whereArray = array();
			foreach ($params['where'] as $key => $value){
				if(!empty($value)){
					$parsedValue = self::$IsUsingUtf8 ? htmlentities(utf8_decode($value), ENT_COMPAT, self::$Charset, false) : htmlentities($value, ENT_COMPAT, self::$Charset, false);
					array_push($whereArray, 'types.'.$key.' = "'.$parsedValue.'"');
				}
			}
			$where = implode(' AND ', $whereArray);
			$orderBy = array();
			if(!empty($params['orderBy'])){
				$orderBy = implode(',', $params['orderBy']);
			}
			$limit = '';
			if(!empty($params['from'])){
				$limit = ''.$params['from'];
				if(!empty($params['amount'])){
					$limit .= ', '.$params['amount'];
				} else {
					$limit .= ', 10';
				}
			}
			$query = new Query();
			$query->createSelect(array('*'), 'processes', $joinArray, $where, $orderBy, $limit);
			$arrayArraysProcess = $query->execute(true);
			if(!empty($arrayArraysProcess)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysProcess[0]);
				}
				foreach($arrayArraysProcess as $arrayProcess){
					array_push($processesArray, self::CreateObjectFromArray($arrayProcess));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid param, array expected in ProcessModel::FindByTypeProperties()');
		}
		return $processesArray;
	}

	/**
	 * Finds stored Processes by related State properties
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Process
	 * @static
	 */
	public static function FindByStateProperties($params, $expectsOne=false){
		$processesArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			$selectFields = array(
					'processes.id',
					'processes.typeId',
					'processes.stateId',
					'processes.processDate',
					'processes.bundleId',
					'processes.issues'
				);
			$joinArray = array('states'=>'states.id = processes.stateId');
			$whereArray = array();
			foreach ($params['where'] as $key => $value){
				if(!empty($value)){
					$parsedValue = self::$IsUsingUtf8 ? htmlentities(utf8_decode($value), ENT_COMPAT, self::$Charset, false) : htmlentities($value, ENT_COMPAT, self::$Charset, false);
					array_push($whereArray, 'states.'.$key.' = "'.$parsedValue.'"');
				}
			}
			$where = implode(' AND ', $whereArray);
			$orderBy = array();
			if(!empty($params['orderBy'])){
				$orderBy = implode(',', $params['orderBy']);
			}
			$limit = '';
			if(!empty($params['from'])){
				$limit = ''.$params['from'];
				if(!empty($params['amount'])){
					$limit .= ', '.$params['amount'];
				} else {
					$limit .= ', 10';
				}
			}
			$query = new Query();
			$query->createSelect(array('*'), 'processes', $joinArray, $where, $orderBy, $limit);
			$arrayArraysProcess = $query->execute(true);
			if(!empty($arrayArraysProcess)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysProcess[0]);
				}
				foreach($arrayArraysProcess as $arrayProcess){
					array_push($processesArray, self::CreateObjectFromArray($arrayProcess));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid param, array expected in ProcessModel::FindByStateProperties()');
		}
		return $processesArray;
	}

	/**
	 * Finds stored Processes by related Bundle properties
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Process
	 * @static
	 */
	public static function FindByBundleProperties($params, $expectsOne=false){
		$processesArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			$selectFields = array(
					'processes.id',
					'processes.typeId',
					'processes.stateId',
					'processes.processDate',
					'processes.bundleId',
					'processes.issues'
				);
			$joinArray = array('bundles'=>'bundles.id = processes.bundleId');
			$whereArray = array();
			foreach ($params['where'] as $key => $value){
				if(!empty($value)){
					$parsedValue = self::$IsUsingUtf8 ? htmlentities(utf8_decode($value), ENT_COMPAT, self::$Charset, false) : htmlentities($value, ENT_COMPAT, self::$Charset, false);
					array_push($whereArray, 'bundles.'.$key.' = "'.$parsedValue.'"');
				}
			}
			$where = implode(' AND ', $whereArray);
			$orderBy = array();
			if(!empty($params['orderBy'])){
				$orderBy = implode(',', $params['orderBy']);
			}
			$limit = '';
			if(!empty($params['from'])){
				$limit = ''.$params['from'];
				if(!empty($params['amount'])){
					$limit .= ', '.$params['amount'];
				} else {
					$limit .= ', 10';
				}
			}
			$query = new Query();
			$query->createSelect(array('*'), 'processes', $joinArray, $where, $orderBy, $limit);
			$arrayArraysProcess = $query->execute(true);
			if(!empty($arrayArraysProcess)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysProcess[0]);
				}
				foreach($arrayArraysProcess as $arrayProcess){
					array_push($processesArray, self::CreateObjectFromArray($arrayProcess));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid param, array expected in ProcessModel::FindByBundleProperties()');
		}
		return $processesArray;
	}

	/**
	 * Retrieves all Processes stored in the data base
	 * 
	 * @return		array|Process
	 * @static
	 */
	public static function FetchAll($params=array('orderBy', 'from', 'amount')){
		$processesArray = array();
		$params = self::CheckParams($params, self::FetchAll);
		$orderBy = array();
		if(!empty($params['orderBy'])){
			$orderBy = implode(',', $params['orderBy']);
		}
		$limit = '';
		if(!empty($params['from'])){
			$limit = ''.$params['from'];
			if(!empty($params['amount'])){
				$limit .= ', '.$params['amount'];
			} else {
				$limit .= ', 10';
			}
		}
		$query = new Query();
		$query->createSelect(array('*'), 'processes', null, null, $orderBy, $limit);
		$arrayArraysProcess = $query->execute(true);
		if(!empty($arrayArraysProcess)){
			foreach($arrayArraysProcess as $arrayProcess){
				array_push($processesArray, self::CreateObjectFromArray($arrayProcess));
			}
		}
		return $processesArray;
	}

	/**
	 * Retrieves all Processes that matches the search text
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Process
	 * @static
	 */
	public static function Search($params, $expectsOne=false){
		$processesArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			if(is_array($params['where']) && isset($params['where']['text']) && isset($params['where']['fields'])){
				$text = trim($params['where']['text']);
				$searchs = array();
				foreach($params['where']['fields'] as $field){
					array_push($searchs, trim($field).' LIKE "%'.$text.'%"');
				}
				$where = implode(' OR ', $searchs);
				$orderBy = array();
				if(!empty($params['orderBy'])){
					$orderBy = implode(',', $params['orderBy']);
				}
				$limit = '';
				if(!empty($params['from'])){
					$limit = ''.$params['from'];
					if(!empty($params['amount'])){
						$limit .= ', '.$params['amount'];
					} else {
						$limit .= ', 10';
					}
				}
				$query = new Query();
				$query->createSelect(array('*'), 'processes', null, $where, $orderBy, $limit);
				$arrayArraysProcess = $query->execute(true);
				if(!empty($arrayArraysProcess)){
					if($expectsOne){
						return self::CreateObjectFromArray($arrayArraysProcess[0]);
					}
					foreach($arrayArraysProcess as $arrayProcess){
						array_push($processesArray, self::CreateObjectFromArray($arrayProcess));
					}
				} elseif($expectsOne){
					return false;
				}
			} else {
				throw new Exception('Unable to perform search with invalid params. ProcessModel::Search()');
			}
		} else {
			throw new Exception('Unable to perform search with invalid params. ProcessModel::Search()');
		}
		return $processesArray;
	}

	/**
	 * Retrieves the number of Processes stored in the data base
	 * 
	 * @return		int
	 * @static
	 */
	public static function GetCount(){
		$query = new Query();
		$query->push('SELECT count(*) as count FROM processes');
		$result = $query->execute();
		return $result['count'];
	}

	/**
	 *  Deletes Process by id
	 * 
	 * @param		int		$id
	 * @static
	 */
	public static function Delete($id){
		$query = new Query();
		$query->createDelete('processes', $id);
		return $query->execute();
	}

	/**
	 *  Creates Process object from the basic properties
	 * 
	 * @param		array|string		$properties
	 * @return		Process
	 * @static
	 */
	public static function CreateObjectFromArray($properties){
		$emptyValues = '';
		if(empty($properties["id"])){
			$emptyValues .= ' id';
		}
		if(empty($properties["typeId"])){
			$emptyValues .= ' typeId';
		}
		if(empty($properties["stateId"])){
			$emptyValues .= ' stateId';
		}
		if(empty($properties["processDate"])){
			$emptyValues .= ' processDate';
		}
		if(empty($emptyValues)){
			$properties['type'] = TypeModel::FindById($properties['typeId']);
			if(empty($properties['type'])){
				throw new Exception('Unable to find the Type for the Process.(ProcessModel::CreateObjectFromArray())');
			}
			$properties['state'] = StateModel::FindById($properties['stateId']);
			if(empty($properties['state'])){
				throw new Exception('Unable to find the State for the Process.(ProcessModel::CreateObjectFromArray())');
			}
			if(!empty($properties['bundleId'])){
				$properties['bundle'] = BundleModel::FindById($properties['bundleId']);
				if(empty($properties['bundle'])){
					throw new Exception('Unable to find the Bundle for the Process.(ProcessModel::CreateObjectFromArray())');
				}
			}
			return new Process($properties);
		} else {
			throw new Exception('Unable to create Process with empty required values:'.$emptyValues.' for Process "'.$properties['id'].'". (ProcessModel::CreateObjectFromArray())');
		}
	}
}