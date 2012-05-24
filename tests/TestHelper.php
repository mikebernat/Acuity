<?php
/**
 * testbootstrap.php
 *
 * Bootstrap file used for tests.
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Test_Bootstrap
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 *
 */

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', dirname(dirname(__FILE__)));

set_include_path(
	ROOT_PATH . DS . 'lib' . PATH_SEPARATOR .
	ROOT_PATH . DS . 'tests' . PATH_SEPARATOR .
	get_include_path()
);

require_once ROOT_PATH . DS . 'lib' . DS . 'App.php';
$app = new Acuity_App();
$app->autoLoader();
