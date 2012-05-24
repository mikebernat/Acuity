<?php
/**
 * Entity.php
 * Acuity_Model_Entity
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Model_Entity
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 * @created  Jan 28, 2010
 *
 */


/**
 * Entity model for single instance objects
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
abstract class Acuity_Model_Entity
{
    public $primaryKeyName = 'id';

    /**
     * Name of table
     *
     * @var string
     */
    public $table;

    /**
     * @var Acuity_Db_Abstract
     */
    protected $db;

    /**
     * List of fields in the table
     *
     * @var array
     */
    protected $fields = array();

    protected $options;

    /**
     * Current data
     *
     * @var array
     */
    protected $data = array();

    /**
     * Return the default select object for fetching a record
     *
     * @param string $primaryKey The primary key value to select
     * @param array  $options    Options
     *
     * @return Acuity_Db_Select
     */
    abstract protected function getSelect($primaryKey, $options = array());

    /**
     * Loads a single entity from a datasource
     *
     * @param string $primaryKey The primary key value to select
     * @param array  $options    Options
     *
     * @return void
     */
    public function __construct($primaryKey = null, $options = array(), Acuity_Db_Driver $db = null)
    {
        if (!$db) {
            $db = Acuity_Registry::get('db');
        }

        $this->db = $db;

        $this->options = $options;

        if ($primaryKey) {
            $this->load($this->getSelect($primaryKey, $options));
        }
    }

    /**
     * Get options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Load the entity
     *
     * @param Acuity_Db_Select $select The select object
     *
     * @return void
     */
    protected function load(Acuity_Db_Select $select)
    {
        $result = $select->query()->fetch(Acuity_Db_Driver::FETCH_ASSOC);

        foreach ($result as $field => $value) {
            $this->$field = $value;
        }
    }

    /**
     * Setter for all data fields.
     * Allows custom set field implementations.
     *
     * @param string $name  Name of the field
     * @param mixed  $value Value of field
     *
     * @return mixed
     */
    private function _setField($name, $value)
    {
        $customSetMethod = 'set' . ucfirst($name);
        if (method_exists($this, $customSetMethod)) {
            return $this->$customSetMethod($value);
        }

        return $this->data[$name] = $value;
    }

    /**
     * Getter for all data fields.
     * Allows custom get field implementations.
     *
     * @param string $name Name of field
     *
     * @return mixed
     */
    private function _getField($name)
    {
        $customGetMethod = 'get' . ucfirst($name);
        if (method_exists($this, $customGetMethod)) {
            return $this->$customGetMethod($name);
        }

        if (empty($this->data[$name])) {
            return false;
        }

        return $this->data[$name];
    }

    /**
     * Getter
     *
     * @param string $name Name of field
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->_getField($name);
    }

    /**
     * Setter
     *
     * @param string $name  Name of field
     * @param mixed  $value Value of field
     *
     * @return void
     */
    public function __set($name, $value)
    {
        return $this->_setField($name, $value);
    }

    /**
     * Get all data fields
     *
     * @return array
     */
    public function getData()
    {
        $fields = array();

        if (empty($this->data)) {
            return $fields;
        }

        foreach (array_keys($this->data) as $fieldName) {
            $fields[$fieldName] = $this->_getField($fieldName);
        }

        return $fields;
    }

    /**
     * Get all field names
     *
     * @return array
     */
    public function getFields()
    {
        if (empty($this->fields)) {
            throw new Acuity_Exception('No fields specified');
        }

        return $this->fields;
    }

    /**
     * Update the database
     *
     * @param array $data Fieldname => Value pairs
     *
     * @return bool
     */
    public function save($data)
    {
        $id = $this->_getField($this->primaryKeyName);

        if ($id) {
            $result = $this->db->update(
            $this->table,
            $data,
            sprintf('%s = %s', $this->primaryKeyName, $id)
            );
        } else {
            unset($data[$this->primaryKeyName]);

            $result = $this->db->insert(
            $this->table,
            $data
            );

            $data[$this->primaryKeyName] = $this->db->lastInsertId();
        }

        if (empty($result)) {
            return false;
        }

        // Set the updated data in the current object
        foreach ($data as $name => $value) {
            $this->_setField($name, $value);
        }

        return true;
    }

    /**
     * Save or Update a join table with values.
     *
     * @param string $tableName Join table name
     * @param int    $primaryId Primary ID
     * @param string $pkName    Primary key's fieldname
     * @param string $fkName    Foreign key's fieldname
     * @param array  $data      Data
     *
     * @return void
     */
    public function saveToJoinTable($tableName, $primaryId, $pkName, $fkName, $data)
    {
        $sql = sprintf(
            'DELETE FROM %s WHERE %s = %s',
        $tableName,
        $pkName,
        $this->db->quote($primaryId)
        );

        $this->db->query($sql);

        if (!empty($data[$fkName])) {
            foreach ($data[$fkName] as $value) {
                $values = array(
                $pkName    => $primaryId,
                $fkName    => $value,
                );

                $this->db->insert($tableName, $values);
            }
        }
    }
}