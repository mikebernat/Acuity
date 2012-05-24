<?php
/**
 * Abstract.php
 * Acuity_Db_Abstract
 *
 * Abstract database object
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Db_Abstract
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 * @created  Jan 28, 2010
 *
 */
 
 
 /**
 * Abstract database
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
abstract class Acuity_Db_Abstract extends PDO
{
	/**
	 * Update table data
	 * 
	 * @param string $tableName The name of the table
	 * @param array  $data      Array of data to update
	 * @param string $where     Where clause of update statement
	 * 
	 * @return PDO_Statement
	 */
	public function update($tableName, $data, $where)
	{
		$data_parts = array();
		
		foreach ($data as $field => $value) {
			$data_parts[] = sprintf('%s = %s', $field, $this->quote($value));
		}
		
		$statement = sprintf(
			'UPDATE %s SET %s WHERE %s',
			$tableName,
			implode(',', $data_parts),
			$where
		);

		return $this->query($statement);
	}
	
	/**
	 * Insert data into a table
	 * 
	 * @param string $tableName The name of the table
	 * @param array  $data      Array of data to insert
	 * 
	 * @return int last insert id
	 */
	public function insert($tableName, $data)
	{
		$data_parts = array();
		
		$field_parts = array();
		
		foreach (array_keys($data) as $field) {
			// Strip all non-alphanumeric chars
			$field_parts[] = preg_replace('/[^\w]/', '', $field);
		}
		
		foreach ($data as $field => $value) {
			$data_parts[] = $this->quote($value);
		}
		
		$statement = sprintf(
			'INSERT INTO %s(%s) VALUES(%s)',
			$tableName,
			implode(',', $field_parts),
			implode(',', $data_parts)
		);
		
		$this->query($statement);
		
		return $this->lastInsertId();
	}
}