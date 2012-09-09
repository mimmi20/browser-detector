<?php
/**
 * Bootstrap-Datei
 *
 * PHP version 5
 *
 * @category  CreditCalc
 * @package   Config
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 * @license   http://www.unister.de     Unister License
 * @version   SVN: $Id$
 * @link      todo
 */

/**
 * Bootstrap-Datei
 *
 * @category  CreditCalc
 * @package   Config
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 * @license   http://www.unister.de  Unister License
 * @link      todo
 */

/*
 * Maximize Memory Limit
 */
ini_set('memory_limit', '3072M');
ini_set('display_errors', 1);
error_reporting(E_COMPILE_ERROR|E_RECOVERABLE_ERROR|E_ERROR|E_CORE_ERROR);

ini_set('max_execution_time', '60000');
ini_set('max_input_time', '-1');

/*
 * Set default timezone
 */
date_default_timezone_set('Europe/Berlin');

/*
 * Testing environment
 */
define('DS', DIRECTORY_SEPARATOR);
define('ENCODING', 'utf-8');
define('ROOT_PATH', realpath(__DIR__ . DS . '..' . DS));

define('APPLICATION_PATH', ROOT_PATH . DS . 'application');
define('DATA_PATH', ROOT_PATH . DS . 'data');
define('HOME_PATH', ROOT_PATH . DS . 'public');
define('LIB_PATH', ROOT_PATH . DS . 'library');

define('SERVER_LOCAL', 'local');
define('SERVER_LOCAL_TWO', 'local2');
define('SERVER_LOCAL_HOST', 'localhost');
define('SERVER_LOCAL_TEST', 'localtest');
define('SERVER_LOCAL_TEST2', 'localtest2');
define('SERVER_LOCAL_TEST3', 'localtest3');
define('SERVER_LOCAL_TEST4', 'localtest4');
define('SERVER_ONLINE_STAGING', 'staging');
define('SERVER_ONLINE_TEST', 'test');
define('SERVER_ONLINE_TEST2', 'test2');
define('SERVER_ONLINE_LIVE', 'live');
define('SERVER_ONLINE_LIVE14', 'live14');
define('SERVER_ONLINE_LIVE47', 'live47');
define('SERVER_ONLINE_LIVE57', 'live57');
define('SERVER_ONLINE_LIVE_F1', 'livef1');
define('SERVER_ONLINE_LIVE_F2', 'livef2');
define('SERVER_ADMIN', 'admin');
define('SERVER_ADMIN_TEST', 'admintest');

define('APPLICATION_ENV', SERVER_ONLINE_TEST);

/*
 * Prepend the library/, tests/, and models/ directories to the
 * include_path. This allows the tests to run out of the box.
 */
set_include_path(
    implode(
        PATH_SEPARATOR,
        array(
            APPLICATION_PATH . DS,
            LIB_PATH . DS,
            get_include_path(),
        )
    )
);

/*
 * Init Autoloader
 */
require_once LIB_PATH . DS . 'Zend' . DS . 'Loader' . DS . 'Autoloader.php';

$autoLoader = \Zend\Loader\Autoloader::getInstance();
$autoLoader->registerNamespace('Zend');
$autoLoader->registerNamespace('App');
$autoLoader->registerNamespace('AppCore');
$autoLoader->registerNamespace('Doctrine');
$autoLoader->registerNamespace('Symfony');
$autoLoader->registerNamespace('I18N');
$autoLoader->registerNamespace('TeraWurfl');
$autoLoader->registerNamespace('OpenGeoDb');
$autoLoader->registerNamespace('Browscap');
$autoLoader->registerNamespace('HTML');
$autoLoader->suppressNotFoundWarnings(false);

/*******************************************************************************
 * Zend_Application
 */
require_once LIB_PATH . DS . 'Zend' . DS . 'Application' . DS . 'Application.php';
require_once LIB_PATH . DS . 'Zend' . DS . 'Config' . DS . 'Config.php';
require_once LIB_PATH . DS . 'Zend' . DS . 'Config' . DS . 'Ini.php';
require_once LIB_PATH . DS . 'Zend' . DS . 'Registry.php';
require_once LIB_PATH . DS . 'Zend' . DS . 'Db' . DS . 'Adapter' . DS . 'AbstractAdapter.php';
require_once LIB_PATH . DS . 'Zend' . DS . 'Db' . DS . 'Adapter' . DS . 'AbstractPdoAdapter.php';
require_once LIB_PATH . DS . 'Zend' . DS . 'Db' . DS . 'Adapter' . DS . 'PdoMysql.php';
require_once LIB_PATH . DS . 'Zend' . DS . 'Db' . DS . 'Db.php';
require_once LIB_PATH . DS . 'Zend' . DS . 'Db' . DS . 'Profiler.php';
require_once LIB_PATH . DS . 'Zend' . DS . 'Db' . DS . 'Table' . DS . 'AbstractTable.php';
require_once LIB_PATH . DS . 'Zend' . DS . 'Log' . DS . 'Factory.php';
require_once LIB_PATH . DS . 'Zend' . DS . 'Log' . DS . 'Logger.php';
require_once LIB_PATH . DS . 'Zend' . DS . 'Log' . DS . 'Writer.php';
require_once LIB_PATH . DS . 'Zend' . DS . 'Log' . DS . 'Writer' . DS . 'AbstractWriter.php';
require_once LIB_PATH . DS . 'Zend' . DS . 'Log' . DS . 'Writer' . DS . 'Stream.php';
require_once LIB_PATH . DS . 'Zend' . DS . 'Log' . DS . 'Formatter.php';
require_once LIB_PATH . DS . 'Zend' . DS . 'Log' . DS . 'Formatter' . DS . 'Simple.php';
//require_once LIB_PATH . DS . 'Zend' . DS . 'Auth' . DS . 'Adapter' . DS . 'AdapterInterface.php';

// require_once LIB_PATH . DS . 'AppCore' . DS . 'Controller' . DS . 'ControllerAbstract.php';

// require_once LIB_PATH . DS . 'App' . DS . 'Credit' . DS . 'CreditAbstract.php';
// require_once LIB_PATH . DS . 'App' . DS . 'Credit' . DS . 'Input' . DS . 'InputAbstract.php';
// require_once LIB_PATH . DS . 'App' . DS . 'Credit' . DS . 'Output' . DS . 'OutputAbstract.php';
// require_once LIB_PATH . DS . 'App' . DS . 'Model' . DS . 'CalcResult.php';
// require_once LIB_PATH . DS . 'App' . DS . 'Model' . DS . 'CalcResult' . DS . 'Ingdiba.php';
// require_once LIB_PATH . DS . 'App' . DS . 'Model' . DS . 'CalcResult' . DS . 'Cetelem.php';

//require_once LIB_PATH . DS . 'AppAdmin' . DS . 'Statistics' . DS . 'Adapter' . DS . 'AgentAbstract.php';