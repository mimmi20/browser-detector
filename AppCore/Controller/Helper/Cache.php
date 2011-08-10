<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Controller\Helper;

/**
 * ActionHelper Class to detect the user agent and to set actions according to
 * it
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * ActionHelper Class to detect the user agent and to set actions according to
 * it
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Cache extends \Zend\Controller\Action\Helper\AbstractHelper
{
    private $_config = null;
    
    /**
     * Class constructor
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->_logger = \Zend\Registry::get('log');
        $this->_config = new \Zend\Config\Config($this->getActionController()->getInvokeArg('bootstrap')->getOptions());
    }
    
    /**
     * function called after routing the request
     *
     * TODO: aufspalten: Module-abhängige Teile verlagern
     *
     * @param \Zend\Controller\Request\AbstractRequest $request the Request
     *
     * @return void
     * @access public
     */
    private function _doCache()
    {
        $request = $this->getRequest();

        //get requested file
        $file = $request->getRequestUri();

        if ('' == $file) {
            /*
             * no Request-Uri given (mostly while unit testing)
             * -> no Cache
             */
            return;
        }

        if (!$this->_config->sitecache->enable) {
            /*
             * site cache is not enabled
             * -> no Cache
             */
            return;
        }

        /*
         * set headers for javascript or style files
         * needed, if these files are delivered from cache
         * if not set here, the cached content is sent as 'text/html'
         */
        if (substr($file, -4) == '.css') {
            header('Content-Type: text/css', true);
        } elseif (substr($file, -3) == '.js') {
            header('Content-Type: text/javascript', true);
        }

        $optionsFront = array(
            'lifetime' => (int) $this->_config->sitecache->lifetime,
            'debug_header' => (boolean) $this->_config->sitecache->debug,
            'default_options' => $this->_config->sitecache->defaults->toArray(),
            'regexps' => array(
                '^/$' => array(
                    'cache' => false
                ),
                '^/index/' => array(
                    'cache' => false
                ),
                '^/js/' => array(
                    'cache' => true,
                    'make_id_with_post_variables' => false,
                    // allways disabled, causes javascript errors
                    'debug_header' => false,
                    'memorize_headers' => array(
                        'Content-Type: text/javascript; charset=' .
                        \Zend\Registry::get('_encoding'),
                        'Content-Language: de',
                        'robots: noindex,nofollow'
                    )
                ),
                '^/css/' => array(
                    'cache' => true,
                    'make_id_with_post_variables' => false,
                    'memorize_headers' => array(
                        'Content-Type: text/css; charset=' .
                        \Zend\Registry::get('_encoding'),
                        'Content-Language: de',
                        'robots: noindex,nofollow'
                    )
                ),
                '^/kredit/' => array(
                    'cache' => true,
                    'memorize_headers' => array('Content-Language: de_DE')
                ),
                '^/kredit/index/antrag/' => array(
                    'cache' => false
                ),
                '^/iframe/kredite/function/antrag' => array(
                    'cache' => false
                ),
                '^/curl/kredite.html?function=antrag' => array(
                    'cache' => false
                ),
                '^/Kredit/' => array(
                    'cache' => true,
                    'memorize_headers' => array('Content-Language: de_DE')
                ),
                '^/Kredit/index/antrag/' => array(
                    'cache' => false
                ),
                '^/html/' => array(
                    'cache' => true,
                    'memorize_headers' => array(
                        'Content-Type: text/html; charset=' .
                        \Zend\Registry::get('_encoding'),
                        'Content-Language: de'
                    )
                ),
                '^/curl/' => array(
                    'cache' => true,
                    'memorize_headers' => array(
                        'Content-Type: text/html; charset=' .
                        \Zend\Registry::get('_encoding'),
                        'Content-Language: de'
                    )
                ),
                '^/iframe/' => array(
                    'cache' => true,
                    'memorize_headers' => array(
                        'Content-Type: text/html; charset=' .
                        \Zend\Registry::get('_encoding'),
                        'Content-Language: de'
                    )
                ),
                '^/xml/' => array(
                    'cache' => true,
                    // allways disabled, makes xml invalid
                    'debug_header' => false,
                    'memorize_headers' => array(
                        'Content-Type: text/xml; charset=' .
                        \Zend\Registry::get('_encoding'),
                        'Content-Language: de',
                        'robots: noindex,nofollow'
                    )
                ),
                '^/admin/' => array(
                    'cache' => false
                ),
                '^/admin/statistics/overview/' => array(
                    'cache' => true,
                    'make_id_with_post_variables' => false,
                    // allways disabled, causes javascript errors
                    'debug_header' => false,
                    'memorize_headers' => array(
                        'Content-Type: text/javascript; charset=' .
                        \Zend\Registry::get('_encoding'),
                        'Content-Language: de',
                        'robots: noindex,nofollow'
                    )
                ),
                '^/admin/statistics/overview-new/' => array(
                    'cache' => true,
                    'make_id_with_post_variables' => false,
                    // allways disabled, causes javascript errors
                    'debug_header' => false,
                    'memorize_headers' => array(
                        'Content-Type: text/javascript; charset=' .
                        \Zend\Registry::get('_encoding'),
                        'Content-Language: de',
                        'robots: noindex,nofollow'
                    )
                ),
                '^/geo/' => array(
                    'cache' => false
                ),
                '^/validate/' => array(
                    'cache' => false
                )
            )
        );
        $optionsBack  = $this->_config->sitecache->back->toArray();

        $cache = \Zend\Cache\Cache::factory(
            $this->_config->sitecache->frontend,
            $this->_config->sitecache->backend,
            $optionsFront,
            $optionsBack
        );

        \Zend\Registry::set('siteCache', $cache);

        $cache->start();

        //nur bereinigen, wenn nicht im Cache
        $cache->clean(\Zend\Cache\Frontend\Core::CLEANING_MODE_OLD);
    }

    /**
     * Default-Methode für Services
     *
     * wird als Alias für die Funktion {@link log} verwendet
     *
     * @return void
     */
    public function direct()
    {
        $this->_doCache();
    }
}