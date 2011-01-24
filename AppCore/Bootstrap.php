<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore;

/**
 * Bootstrap-File
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Config
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Bootstrap.php 11 2011-01-22 22:07:35Z tmu $
 */

/**
 * Bootstrap-File
 *
 * @category  Kreditrechner
 * @package   Config
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Bootstrap extends \Zend\Application\Bootstrap
{
    /**
     * Logger Instance
     * @var \Zend\Log\Logger
     */
    private $_logger = null;

    /**
     * Init Zend Autoloader
     *
     * the autoloader is initialized here, the required namespaces are
     * registered and the plugin loader are defined
     *
     * @return void
     */
    protected function _initAutoload()
    {
        require_once LIB_PATH . DS . 'Zend' . DS . 'Loader' . DS .
            'Autoloader.php';

        $autoLoader = \Zend\Loader\Autoloader::getInstance();
        $autoLoader->suppressNotFoundWarnings(false);

        /*
         * register all needed Namespaces
         * 'Zend' is registered by default, is added just to create an complete
         * list
         */
        $autoLoader->registerNamespace('Zend');
        //$autoLoader->registerNamespace('ZendX');
        $autoLoader->registerNamespace('Credit');
        //$autoLoader->registerNamespace('Unister');
        $autoLoader->registerNamespace('Doctrine');
        $autoLoader->registerNamespace('Symfony');
        $autoLoader->registerNamespace('I18N');
        //spl_autoload_register(array('Doctrine_Core', 'modelsAutoload'));
    }

    /**
     * Register config object
     *
     * the main application config is loaded here and stored in the
     * {@link Zend_Registry}
     *
     * TODO: load {@link Zend_Config_Php} instead of {@link \Zend\Config\Ini}
     * in live Envirionment (to make application faster)
     *
     * @return void
     */
    protected function _initConfig()
    {
        /*
         * TODO: make it possible for live servers to handle php configs
         */
        $config = new \Zend\Config\Ini(APPLICATION_PATH . '' . DS . 'configs'
                . DS . 'application.ini', APPLICATION_ENV);
        \Zend\Registry::set('_config', $config);

        /*
         * load Constants
         */
        $constants = $config->constants->toArray();

        foreach ($constants as $constkey => $constvalue) {
            $constName = strtoupper('kredit_' . $constkey);

            if (!defined($constName)) {
                if (is_numeric($constvalue)) {
                    $constvalue = (int) $constvalue;
                }

                define($constName, $constvalue);
            }
        }
    }

    /**
     * init an plugin cache, if it is enabled
     *
     * @return void
     */
    protected function _initPluginCache()
    {
        $config = $this->getOptions();

        if (isset($config['plugincache']['enable'])
            && $config['plugincache']['enable']
        ) {
            $classFileIncCache = $config['plugincache']['path'];

            if (file_exists($classFileIncCache)) {
                include_once $classFileIncCache;
            }

            \Zend\Loader\PluginLoader::setIncludeFileCache($classFileIncCache);
        }
    }

    /**
     * initialze an Error Handler
     *
     * the Error Handler should handle all Errors inside the Application,
     * generate a Trace by throwing and catching an Exception, write the
     * Error Message with the Trace into the Error-Log and send emails
     *
     * @return void
     */
    protected function _initLogging()
    {
        $config = $this->getOptions();

        // Ensure the front controller is initialized
        $this->bootstrap('FrontController');

        $logger = new \Zend\Log\Logger();

        if ($config['error']['log']['enabled']) {
            //log warnings into a log file
            $fileWriter = new \Zend\Log\Writer\Stream(
                $config['error']['log']['path']
            );
            $fileWriter->addFilter(\Zend\Log\Logger::WARN);

            $formatter = new Log\Formatter\Simple();
            $fileWriter->setFormatter($formatter);

            $logger->addWriter($fileWriter);
        }

        /*
        if (SERVER_ONLINE_LIVE != APPLICATION_ENV) {
            //use Firebug to show logs, if its not live
            $fireWriter = new \Zend\Log\Writer\Firebug();
            $fireWriter->setDefaultPriorityStyle('TRACE');
            $fireWriter->addFilter(\Zend\Log\Logger::DEBUG);
            $logger->addWriter($fireWriter);
        }
        */

        if ($config['error']['mail']['enabled']) {
            /*
             * send an email when an error occured
             */
            $host = ((isset($_SERVER['HTTP_HOST']))
                  ? $_SERVER['HTTP_HOST']
                  : 'unknown-host');

            $host      = str_replace(':', '-', $host);

            if (false === strpos($host, 'kredit.geld.de')) {
                $host .= '.kredit.geld.de';
            }

            $emailName = 'ErrorMail - Errors on Site ' . $host;

            $mail = new \Zend\Mail\Mail();
            $mail->setFrom('ErrorHandler@' . $host);
            $mail->addTo($config['error']['mail']['to']);

            $mailWriter = new \Zend\Log\Writer\Mail($mail);
            $mailWriter->setSubjectPrependText($emailName);
            $mailWriter->addFilter(\Zend\Log\Logger::ERR);
            $logger->addWriter($mailWriter);
        }

        $logger->registerErrorHandler();

        $this->_logger = $logger;
        \Zend\Registry::set('log', $logger);
    }

    /**
     * Init DB
     *
     * loads the database config, defines the database cache and sets the
     * database handler for the Tracking tool
     *
     * @return void
     */
    protected function _initDatabase()
    {
        $config = $this->getOptions();

        $this->bootstrap('db');
        $db = $this->getResource('db');
        $db->setFetchMode(\Zend\Db\Db::FETCH_OBJ);

        \Zend\Db\Table\AbstractTable::setDefaultAdapter($db);

        if ($config['dbcache']['enable']) {
            /*
             * load Cache for table metadata
             */
            $dbcache = \Zend\Cache\Cache::factory(
                $config['dbcache']['frontend'],
                $config['dbcache']['backend'],
                $config['dbcache']['front'],
                $config['dbcache']['back']
            );

            \Zend\Db\Table\AbstractTable::setDefaultMetadataCache($dbcache);
        }
    }

    /**
     * Init DB Profiler
     *
     * outputs the DB profiling
     *
     * @return void
     */
    protected function _initDbProfiler()
    {
        /*
         * do not output the profiling during testing or then its live
         */
        /*
        if (SERVER_ONLINE_LIVE != APPLICATION_ENV
            && SERVER_ONLINE_TEST != APPLICATION_ENV
            && SERVER_ONLINE_TEST2 != APPLICATION_ENV
        ) {
            $this->bootstrap('db');

            $profiler = new \Zend\Db\Profiler\Firebug('All DB Queries');
            $profiler->setEnabled(true);

            $this->getPluginResource('db')
                ->getDbAdapter()
                ->setProfiler($profiler);
        }
        */
    }

    /**
     * Init DB Logger
     *
     * avtivates a database error logger
     *
     * @return void
     */
    protected function _initDbLogger()
    {
        /*
         * log all messages into a database
         */
        $dbWriter = new Log\Writer\Db();

        if (SERVER_ONLINE_LIVE == APPLICATION_ENV) {
            /*
             * do not log debug or information messages when live
             */
            $dbWriter->addFilter(\Zend\Log\Logger::NOTICE);
        }
        $this->_logger->addWriter($dbWriter);
    }

    /**
     * Init Plugins
     *
     * defines a list of plugins, these plugin will be loaded and registered
     *
     * @return void
     */
    protected function _initPlugins()
    {
        // Ensure the front controller is initialized
        $this->bootstrap('FrontController');

        // Retrieve the front controller from the bootstrap registry
        $front = $this->getResource('FrontController');
        
        $pluginsToRegister = array(
            123 => '\\Credit\\Core\\Plugin\\Module',
            126 => '\\Credit\\Core\\Plugin\\Cache'
        );

        foreach ($pluginsToRegister as $stackIndex => $plugin) {
            $pluginClass = new $plugin;

            /*
             * unregister Plugin, if already available
             */
            if ($front->hasPlugin($plugin)) {
                $front->unregisterPlugin($pluginClass);
            }

            // register Plugin
            $front->registerPlugin($pluginClass, $stackIndex);
        }
    }

    /**
     * initialize Doctrine
     *
     * @return void
     */
    protected function _initDoctrine()
    {
        //bootstrap the Autoload and the Config
        // -> needed for the CLI-Mode
        $this->bootstrap('autoload');
        $this->bootstrap('config');

        $options = $this->getOptions();
        $db      = $options['resources']['db']['params'];

        /*
        $engine   = $db['doctrineType'];
        $host     = $db['hostname'];
        $port     = $db['doctrinePort'];
        $database = $db['dbname'];
        $user     = $db['username'];
        $pass     = $db['password'];

        $dsn = $engine.'://'.$user.':'.$pass.'@'.$host.'/'.$database;

        $doctrineConfig = $config['doctrine'];

        if (APPLICATION_ENV_GROUP == SERVER_LOCAL) {
            $cache = new \Doctrine\Common\Cache\ArrayCache;
        } else {
            $cache = new \Doctrine\Common\Cache\ApcCache;
        }
        */

        $config = new \Doctrine\ORM\Configuration;
        $cache  = new \Doctrine\Common\Cache\ArrayCache;
        $config->setMetadataCacheImpl($cache);
        $driverImpl = $config->newDefaultAnnotationDriver(APPLICATION_PATH . DS . 'Model' . DS . 'Entities');
        $config->setMetadataDriverImpl($driverImpl);
        $config->setQueryCacheImpl($cache);
        $config->setProxyDir(APPLICATION_PATH . DS . 'Model' . DS . 'Proxies');
        $config->setProxyNamespace('Model\Proxies');

        if (APPLICATION_ENV_GROUP == SERVER_LOCAL) {
            $config->setAutoGenerateProxyClasses(true);
        } else {
            $config->setAutoGenerateProxyClasses(false);
        }

        $connectionOptions = array(
            'driver'    => $db['doctrineType'],
            'user'      => $db['username'],
            'password'  => $db['password'],
            'dbname'    => $db['dbname'],
            'host'      => $db['hostname'] . ':' . $db['doctrinePort']
        );

        $em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);
        
        \Zend\Registry::set('EntityManager', $em);
        
        return $em;
    }

    /**
     * Init Date
     *
     * loads ans sets the cache for {@link \Zend\Date\Date}
     *
     * @return void
     */
    protected function _initDate()
    {
        $config = $this->getOptions();

        //load Cache for \Zend\Date\Date
        $dateCache = \Zend\Cache\Cache::factory(
            $config['datecache']['frontend'],
            $config['datecache']['backend'],
            $config['datecache']['front'],
            $config['datecache']['back']
        );

        \Zend\Date\Date::setOptions(array('cache' => $dateCache));
    }

    /**
     * Init Locale
     *
     * loads and sets the cache Options for {@link \Zend\Locale\Locale}
     *
     * @return void
     */
    protected function _initLocale()
    {
        $config = $this->getOptions();

        //load Cache for \Zend\Locale\Locale
        $localeCache = \Zend\Cache\Cache::factory(
            $config['localecache']['frontend'],
            $config['localecache']['backend'],
            $config['localecache']['front'],
            $config['localecache']['back']
        );
        \Zend\Locale\Locale::setCache($localeCache);

        $locale = new \Zend\Locale\Locale('de_DE');
        \Zend\Registry::set('\\Zend\\Locale\\Locale', $locale);
    }

    /**
     * Init Layout
     *
     * @return void
     */
    protected function _initLayout()
    {
        /*
         * start the MVC
         */
        \Zend\Layout\Layout::startMvc();
    }

    /**
     * Init Request
     *
     * initializes the front controller and the routing
     *
     * @return \Zend\Controller\Request\Http
     */
    protected function _initRequest()
    {
        // Ensure the front controller is initialized
        $this->bootstrap('FrontController');

        // Retrieve the front controller from the bootstrap registry
        $front = $this->getResource('FrontController');

        //load global Config
        $config = $this->getOptions();

        //initialize Request
        $request = new \Zend\Controller\Request\Http();
        $request->setBaseUrl($config['url']['home']['base']);
        $front->setRequest($request);

        // Ensure the request is stored in the bootstrap registry
        return $request;
    }

    /**
     * inits Host specific settings and defines some global Urls
     *
     * TODO: Insert data if i18n is needed
     *
     * @return void
     */
    protected function _initHostSettings()
    {
        $config       = $this->getOptions();
        $urlHomeShort = $config['url']['home']['short'];

        if (isset($_SERVER['SERVER_PORT'])
            && (int) $_SERVER['SERVER_PORT'] === 443
        ) {
            $protocol = 'https://';
        } else {
            $protocol = 'http://';
        }

        \Zend\Registry::set('_protocol', $protocol);

        if (false !== strpos($urlHomeShort, '###HOST###')
            || false !== strpos($urlHomeShort, '###PORT###')
        ) {
            $hostParts = explode(':', $_SERVER['HTTP_HOST']);
            $host      = $this->_cleanParam($hostParts[0]);
            $port      = $hostParts[1];

            $urlHomeShort = str_replace(
                array('###HOST###', '###PORT###'),
                array($host, $port),
                $urlHomeShort
            );
        }

        $home = $protocol . $urlHomeShort;

        \Zend\Registry::set('_home', $home);

        $front = $this->getResource('FrontController');
        $gp    = $front->getRequest()->getParams();

        /*
         * detect if the application is running as service included in an other
         * application
         * -> works for curl and fallback mode
         */
        if (isset($gp['krediturl']) && is_string($gp['krediturl'])) {
            $urlDir  = $this->_cleanParam($gp['krediturl']);
            $urlType = 'EXT';
        } else {
            $urlDir  = $home;
            $urlType = 'INT';
        }

        \Zend\Registry::set('_urlType', $urlType);

        //the target base url for the Antrag
        if (isset($gp['antragurl']) && is_string($gp['antragurl'])) {
            $urlDirAntrag = $this->_cleanParam($gp['antragurl']);
        } else {
            $urlDirAntrag = $urlDir;
        }

        //the target base url for the info button
        if (isset($gp['infourl']) && is_string($gp['infourl'])) {
            $urlDirInfo = $this->_cleanParam($gp['infourl']);
        } else {
            $urlDirInfo = $urlDir;
        }

        if (isset($gp['abs'])) {
            $abs = (boolean) $gp['abs'];
        } else {
            $abs = false;
        }

        \Zend\Registry::set('_useAbsolteUrl', $abs);
        \Zend\Registry::set('_urlDir', $urlDir);
        \Zend\Registry::set('_urlDirAntrag', $urlDirAntrag);
        \Zend\Registry::set('_urlDirInfo', $urlDirInfo);
        \Zend\Registry::set('_imageUrlRoot', $home . 'images/');
        \Zend\Registry::set('_jsUrl', $home . 'js/');
        \Zend\Registry::set('_jsUrlShort', $urlHomeShort . 'js/');
        \Zend\Registry::set('_cssUrl', $home . 'css/');
        \Zend\Registry::set('_cssUrlShort', $urlHomeShort . 'css/');
    }

    /**
     * Init View
     *
     * @return \Zend\View\View
     */
    protected function _initView()
    {
        // Ensure the front controller is initialized
        $this->bootstrap('FrontController');

        // Retrieve the front controller from the bootstrap registry
        $front = $this->getResource('FrontController');

        // get Layout
        $layout = \Zend\Layout\Layout::getMvcInstance();

        // get view from Layout
        $view = $layout->getView();

        // set main properties for the layout
        $view->setEscape('htmlentities');
        $view->doctype(\Zend\View\Helper\Doctype::XHTML5);
        $view->headTitle('Kreditrechner');
        $view->headTitle()->setSeparator(' - ');

        // set global paths to the views
        $view->jsUrl        = \Zend\Registry::get('_jsUrl');
        $view->jsUrlShort   = \Zend\Registry::get('_jsUrlShort');
        $view->cssUrl       = \Zend\Registry::get('_cssUrl');
        $view->cssUrlShort  = \Zend\Registry::get('_cssUrlShort');
        $view->home         = \Zend\Registry::get('_home');
        $view->imageUrlRoot = \Zend\Registry::get('_imageUrlRoot');
        $view->imageUrl     = $view->imageUrlRoot;
        $view->urlDir       = \Zend\Registry::get('_urlDir');

        //register module specific view helper for the core module
        $view->addHelperPath(
            LIB_PATH . DS . 'Credit' . DS . 'Core' . DS . 'View' . DS .
            'Helper' . DS, '\\Credit\\Core\\View\\Helper'
        );

        //register module specific view helper for the core module
        /*
        $view->addBasePath(
            LIB_PATH . DS . 'Credit' . DS . 'Core' . DS . 'View' . DS,
            'KreditCore_View_Helper'
        );
        */

        //register unspecific action helper
        \Zend\Controller\Action\HelperBroker::addPath(
            LIB_PATH . DS . 'Credit' . DS . 'Core' . DS . 'Controller' . DS .
            'Helper' . DS, '\\Credit\\Core\\Controller\\Helper'
        );

        // Add it to the ViewRenderer
        $viewRenderer = \Zend\Controller\Action\HelperBroker::getStaticHelper(
            'ViewRenderer'
        );
        $viewRenderer->setView($view);

        // Return it, so that it can be stored by the bootstrap
        return $view;
    }

    /**
     * clean Parameters taken from GET or POST Variables
     *
     * @param string $param the value to be cleaned
     *
     * @return string
     */
    private function _cleanParam($param)
    {
        return strip_tags(trim(urldecode($param)));
    }
}