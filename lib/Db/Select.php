<?php
/**
 * Select.php
 * Acuity_Db_Select
 *
 * Acuity select object
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Db_Select
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 * @created  Jan 28, 2010
 *
 */
 
 
 /**
 * Select object
 *
 * @category  Testing
 * @package   Acuity
 * @author    Mike Bernat <mike@mikebernat.com>
 * @copyright 2010 Mike Bernat <mike@mikebernat.com>
 * @license   Private http://www.acuityproject.com/
 * @version   Release: .01
 * @link      http://www.acuityproject.com/
 * @since     .01
 */
class Acuity_Db_Select
{
	protected $db;
	
	protected $queryString;
	
	protected $from;
	protected $joins = array();
	protected $where = array();
	protected $having = array();
	protected $limit;
	protected $group;
	protected $orders = array();
	
	protected $parameters;
	
	public $countOnly = false;
	
	/**
	 * Constructor
	 * 
	 * @param Acuity_Db_Abstract $db The db object to use
	 * 
	 * @return void
	 */
	public function __construct(Acuity_Db_Abstract $db)
	{
		$this->db = $db;
	}
	
	/**
	 * Adds a from param to the select object
	 * 
	 * @param string $table  The table to be selected from
	 * @param array  $fields Fields to select
	 * 
	 * @return Acuity_Db_Select
	 */
	public function from($table, $fields = array('*'))
	{
		$this->from = compact('table', 'fields');
		
		return $this;
	}
	
	/**
	 * Add a join to the select object
	 * 
	 * @param string $table  Name of table to join on
	 * @param string $on     The string to relate the join
	 * @param array  $fields fields from the joined table to select
	 * 
	 * @return Acuity_Db_Select
	 */
	public function join($table, $on, $fields = array('*'))
	{
		$type = 'INNER JOIN';
		
		$this->joins[] = compact('table', 'on', 'fields', 'type');
		
		return $this;
	}
	
	/**
	 * Add a left join to the select object
	 * 
	 * @param string $table  Name of table to join on
	 * @param string $on     The string to relate the join
	 * @param array  $fields fields from the joined table to select
	 * 
	 * @return Acuity_Db_Select
	 */
	public function joinLeft($table, $on, $fields = array('*'))
	{
		$type = 'LEFT JOIN';
		
		$join = compact('table', 'on', 'fields', 'type');
		
		$this->joins[] = $join;
		
		return $this;
	}
	
	/**
	 * Add a where clause to the select
	 * 
	 * @param string $statement Where clause
	 * @param string $value     Values to be escaped
	 * 
	 * @return Acuity_Db_Select
	 */
	public function where($statement, $value)
	{
		$this->where[]      = $statement;
		$this->parameters[] = $value;
		
		return $this;
	}
	
	/**
	 * Add a having clause to the select
	 * 
	 * @param string $statement Having clause
	 * @param string $value     Values to be escaped
	 * 
	 * @return Acuity_Db_Select
	 */
	public function having($statement, $value = null)
	{
		$this->having[]     = $statement;
		if ($value) {
			$this->parameters[] = $value;
		}
		
		return $this;
	}
	
	/**
	 * Add a limit to the select object
	 * 
	 * @param string $limit The limit clause
	 * 
	 * @return Acuity_Db_Select
	 */
	public function limit($limit)
	{
		$this->limit = $limit;
		
		return $this;
	}
	
	/**
	 * Add an order to the select object
	 * 
	 * @param string $order The order clause
	 * 
	 * @return Acuity_Db_Select
	 */
	public function order($order)
	{
		$this->orders[] = $order;
		
		return $this;
	}
	
	/**
	 * Add a group by to the select object
	 * 
	 * @param string $group The group clause
	 * 
	 * @return Acuity_Db_Select
	 */
	public function group($group)
	{
		$this->group = $group;
		
		return $this;
	}
	
	/**
	 * Assemble select object and execute the query
	 * 
	 * @return PDO_Statement
	 */
	public function query()
	{
		$queryString = $this->assemble();

		$statement = $this->db->prepare($queryString);
		
		$statement->execute($this->parameters);
		
		return $statement;
	}
	
	/**
	 * Collect all aspects of the select object and prepare it for assembly
	 * 
	 * @return string
	 */
	protected function assemble()
	{
		$sql_parts = array();
		
		if (empty($this->from)) {
			throw new Acuity_Db_Exception('No "FROM" specified');
		}
		
		$sql['FIELDS'] = $this->assembleSelectFields();
		$sql['FROM']   = $this->assembleFrom();
		$sql['JOINS']  = $this->assembleJoins();
		$sql['WHERE']  = $this->assembleWhere();
		$sql['ORDER']  = $this->assembleOrder();
		$sql['GROUP']  = $this->assembleGroup();
		$sql['HAVING'] = $this->assembleHaving();
		$sql['LIMIT']  = $this->assembleLimit();
		
		$this->assembledQuery = $sql;
		
		$queryString = $this->queryString = $this->assembleToString();

		return $queryString;
	}
	
	/**
	 * Assemble the query into a string
	 * 
	 * @return string
	 */
	protected function assembleToString()
	{
		$statement = '';
		
		$statement .= sprintf(
			'SELECT %s ', 
			implode(',', $this->assembledQuery['FIELDS'])
		);
								
		$statement .= sprintf(
			'FROM %s ', 
			reset($this->assembledQuery['FROM'])
		);
		
		if (!empty($this->assembledQuery['JOINS'])) {
			$statement .= sprintf(
				'%s ', 
				implode(' ', $this->assembledQuery['JOINS'])
			);
		}
		
		if (!empty($this->assembledQuery['WHERE'])) {
			$statement .= sprintf(
				'WHERE %s ', 
				implode(
					' AND ', 
					$this->assembledQuery['WHERE']
				)
			);
		}
		
		
		if (!empty($this->assembledQuery['ORDER'])) {
			$statement .= sprintf(
				'ORDER BY %s ', 
				implode(',', $this->assembledQuery['ORDER'])
			);
		}
		
		if (!empty($this->assembledQuery['GROUP'])) {
			$statement .= sprintf(
				'GROUP BY %s ', 
				$this->assembledQuery['GROUP']
			);
		}
		
		if (!empty($this->assembledQuery['HAVING'])) {
			$statement .= sprintf(
				'Having %s ', 
				implode(
					' AND ', 
					$this->assembledQuery['HAVING']
				)
			);
		}
		
		if (!empty($this->assembledQuery['LIMIT'])) {
			$statement .= sprintf(
				'LIMIT %s ', 
				$this->assembledQuery['LIMIT']
			);
		}
		
		return trim($statement);
	}
	
	/**
	 * Get the group params
	 * 
	 * @return string
	 */
	protected function assembleGroup()
	{
		return $this->group;
	}
	
	/**
	 * Get the limit params
	 * 
	 * @return string
	 */
	protected function assembleLimit()
	{
		return $this->limit;
	}
	
	/**
	 * Get the order params
	 * 
	 * @return array
	 */
	protected function assembleOrder()
	{
		$orders = array();
		if (empty($this->orders)) {
			return $orders;
		}
		
		foreach ($this->orders as $order) {
			$orders[] = $order;
		}
		
		return $orders;
	}
	
	/**
	 * Get the where params
	 * 
	 * @return array
	 */
	protected function assembleWhere()
	{
		return $this->where;
	}
	
	protected function assembleHaving()
	{
		return $this->having;
	}
	
	/**
	 * Assemble the joins
	 * 
	 * @return array
	 */
	protected function assembleJoins()
	{
		$from = array();
		
		if (!empty($this->joins)) {
			foreach ($this->joins as $join) {
				if (is_array($join['table'])) {
					$keys = array_keys($join['table']);
					$tableName = sprintf(
						'%s as %s', 
						reset($join['table']), 
						reset($keys)
					);
				} else {
					$tableName = $join['table'];
				}
				
				$from[] = sprintf(
					'%s %s ON %s', 
					strtoupper($join['type']), 
					$tableName, $join['on']
				);
			}
		}
		
		return $from;
	}
	
	/**
	 * Assemble the froms
	 * 
	 * @return array
	 */
	protected function assembleFrom()
	{
		$from = array();
		
		if (is_array($this->from['table'])) {
			$tableAlias = array_keys($this->from['table']);
			$tableAlias = reset($tableAlias);
			$from[]     = sprintf(
				'%s as %s', 
				reset($this->from['table']), 
				$tableAlias
			);
		} else {
			$from[] = $this->from['table'];
		}
		
		return $from;
	}
	
	/**
	 * Assemble the select fields
	 * 
	 * @return array
	 */
	protected function assembleSelectFields()
	{
		if ($this->countOnly) {
			return array('COUNT(*) as total_records');
		}
		
		$fields = array();
		
		$fields = array_merge(
			$this->assembleSelectFieldValues(
				$this->from['table'], 
				$this->from['fields']
			)
		);
		
		foreach ($this->joins as $join) {
			$fields = array_merge(
				$fields, 
				$this->assembleSelectFieldValues(
					$join['table'], 
					$join['fields']
				)
			);
		}
		
		return $fields;
	}
	
	/**
	 * Assemble the selected value fields
	 * 
	 * @param string $table  The table to select from
	 * @param array  $fields The fields to select
	 * 
	 * @return array
	 */
	protected function assembleSelectFieldValues($table, $fields = null)
	{
		if (!is_array($fields) || empty($fields)) {
			return array();
		}
		
		$fields_array = array();
		
		if (!is_array($table)) {
			$tableName = $table;
		} else {
			$keys = array_keys($table);
			$tableName = reset($keys);
		}
		
		foreach ($fields as $fieldAlias => $fieldName) {
			$statement = sprintf('%s.%s', $tableName, $fieldName);
			
			if (!empty($fieldAlias) && !is_numeric($fieldAlias)) {
				$statement .= sprintf(' as %s', $fieldAlias);
			}
			
			$fields_array[] = $statement;
		}
		
		return $fields_array;
	}	
}
