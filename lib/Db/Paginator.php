<?php
/**
 * Paginator.php
 * Acuity_Db_Paginator
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Db_Paginator
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 * @created  Jan 31, 2010
 *
 */
 
 
 /**
 * Paginator
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
class Acuity_Db_Paginator
{
	
	public $currentPage = 1;
	public $recordsPerPage = 10;
	protected $select;
	
	/**
	 * Constructor
	 * 
	 * @param Acuity_Db_Select $select Select object
	 * 
	 * @return void
	 */
	public function __construct(Acuity_Db_Select $select)
	{
		$this->select  = $select;
		$this->request = Acuity_Request::getInstance();
	}
	
	/**
	 * Set the records per page
	 * 
	 * @param string $perPage Per page
	 * 
	 * @return Acuity_Db_Paginator
	 */
	public function setRecordsPerPage($perPage)
	{
		$this->recordsPerPage = $perPage;
		
		return $this;
	}
	
	/**
	 * Set the current page
	 * 
	 * @param strint $page Current page
	 * 
	 * @return Acuity_Db_Paginator
	 */
	public function setCurrentPage($page)
	{
		$this->currentPage = $page;
		
		return $this;
	}
	
	/**
	 * Run the paginated query
	 * 
	 * @return PDOStatement
	 */
	public function query()
	{
		$this->select->countOnly = true;
		
		$this->totalRecords = $this->select
			->query()
			->fetch(Acuity_Db_Driver::FETCH_COLUMN);
		
		$this->select->countOnly = false;
		
		$offset = $this->recordsPerPage * ($this->currentPage - 1);
		
		$this->setPages();
		
		$this->select->limit(sprintf('%d, %d', $offset, $this->recordsPerPage));
		
		return $this->select->query();
	}
	
	/**
	 * Populate a pages array
	 * 
	 * @return void
	 */
	protected function setPages()
	{
		$pages = array();
		
		for( $pageNumber = 1; 
			($pageNumber * $this->recordsPerPage) < ($this->totalRecords + $this->recordsPerPage); 
			$pageNumber++) {
			
			$pages[] = $pageNumber;
		} 		
		
		$this->pages = $pages;
	}
}