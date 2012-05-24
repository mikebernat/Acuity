<?php
/**
 * Factory.php
 * Acuity_Db_Factory
 *
 * Database factory class
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Db_Factory
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 * @created  Jan 28, 2010
 *
 */
 
 
 /**
 * Factory pattern returning a database object
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
class Acuity_Db_Factory
{
	/**
	 * Factory pattern
	 * 
	 * @param array $config Config params for the connection
	 * 
	 * @return Acuity_Db_Driver Database object
	 */
	public static function load($config)
	{
		if (empty($config['driver'])) {
			throw new Acuity_Db_Exception('No driver provided');
		}
		
		try 
		{
			switch ($config['driver'])	{
			case 'sqlite':
				if (empty($config['file'])) {
					throw new Acuity_Db_Exception(
						'A sqlite database file must be specified'
					);						
				}	
						
				$conn_string = sprintf('sqlite:%s', $config['file']);
				
				return new Acuity_Db_Driver($conn_string);
				break;
			default:
				throw new Acuity_Db_Exception(
					'Driver ' . $config['driver'] . ' is not supported.'
				);
				break;
			}
		}
		catch (PDOException $e)	
		{
			throw new Acuity_Db_Exception('PDOException: ' . (string) $e);
		}
		
		throw new Acuity_Db_Exception('Failed to load driver');
	}
}