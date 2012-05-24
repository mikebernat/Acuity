<?php
/**
 * App.php
 * Acuity_App
 *
 * Acuity Bootstrap
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_App
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 * @created  Jan 1, 2010
 *
 */


/**
 * Acuity App
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
class Acuity_App
{

    /**
     * Empty constructor
     *
     * @return
     */
    public function __construct()
    {
    }

    /**
     * Setup the autoloader
     *
     * @return void
     */
    public function autoLoader()
    {
        // Setup the autoloader to use Acuity_Import
        if (!function_exists('acuityAutoloader')) {
            include_once dirname(__FILE__) . DS . 'Import.php';

            $loader = Acuity_Import::getInstance();

            // Add the base-autoloaders to Acuity_Import
            include_once dirname(__FILE__) . DS . 'Autoloader' . DS . 'Loader.php';
            include_once dirname(__FILE__) . DS . 'Autoloader' . DS . 'Library.php';

            $loader->addLoader(new Acuity_Autoloader_Library());

            function acuityAutoloader($className)
            {
                $loader = Acuity_Import::getInstance();

                $loader->load($className);
            }

            spl_autoload_register('acuityAutoloader');

            // Now that the autoloader is in place, add other generic loaders
            $loader->addLoader(new Acuity_Autoloader_Root());
            $loader->addLoader(new Acuity_Autoloader_Controllers());
            $loader->addLoader(new Acuity_Autoloader_Models());
        }
    }

    /**
     * Parse the config file and store it in the registry
     *
     * @param string $config_path Full path to the config file
     * @param string $section     Section of the ini file to parse
     *
     * @return void
     */
    public function config($config_path = null, $section = null)
    {
        if (!$config_path) {
            $config_path = ROOT_PATH . DS . 'config.ini';
        }

        if (!$section) {
            $section = 'application';
        }

        $config = new Acuity_Config($config_path);

        Acuity_Registry::set('config', $config);
    }

    /**
     * Setup the DB connections
     *
     * @return void
     */
    public function db()
    {
        $config = array(
            'driver'    => Acuity_Registry::get('config')->driver,
            'file'        => ROOT_PATH . DS . Acuity_Registry::get('config')->file,
        );

        $db = Acuity_Db_Factory::load($config);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        Acuity_Registry::set('db', $db);
    }

    /**
     * Adjust the debug settings based on the config
     *
     * @return void
     */
    public function debug()
    {
        if (Acuity_Registry::get('config')->debug) {
            error_reporting(E_ALL | ~E_STRICT);
            ini_set('display_errors', 1);
        } else {
            ini_set('display_errors', 0);
        }
    }

    /**
     * Dispatch the stack based on the request
     *
     * @return boolean
     */
    public function dispatch()
    {
        // @TODO abstract to Acuity_Dispatcher()

        $request = Acuity_Request::getInstance();

        $controller_name = $request->getController();
        if (empty($controller_name)) {
            throw new Acuity_Exception('No Controller Specified');
        }

        $action_name = $request->getAction() . 'Action';
        if (empty($action_name)) {
            throw new Acuity_Exception('No Action Specified');
        }

        $controller_class_name = ucfirst($request->getController()) . 'Controller';
        $controller_file_name  = sprintf(
        ROOT_PATH . DS . 'Controllers' . DS . '%s.php',
        ucfirst($request->getController())
        );

        // Load the controller class manually as the autoloader
        // can not throw exceptions thus 404 pages would be impossible
        // to trigger

        if (   !class_exists($controller_class_name)
        && !file_exists($controller_file_name)
        ) {
            throw new Acuity_Exception_Pagenotfound();
        }

        if (!class_exists($controller_class_name)) {
            include_once $controller_file_name;
        }

        $controller = new $controller_class_name(new Acuity_View(), $request);

        if (!method_exists($controller, $action_name)) {
            throw new Acuity_Exception_Pagenotfound(
                'Method ' . $action_name . ' does not exist in ' .
            $controller_class_name . '.'
            );
        }

        Acuity_Helper_Breadcrumb::add('Acuity', '/');

        $controller->preDispatch();
        $controller->$action_name();
        $controller->postDispatch();
        $response = $controller->render();

        Acuity_Response::getInstance()->setBody($response);

        return $response;
    }

    /**
     * Display the results of the request
     *
     * @return void
     */
    public function display()
    {
        Acuity_Response::getInstance()->send();
    }

}