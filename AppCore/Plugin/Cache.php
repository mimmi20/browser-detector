<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Plugin;

/**
 * Plugin Class to cache the whole application
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Controller_Plugin
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * Plugin Class to cache the whole application
 *
 * @category  Kreditrechner
 * @package   Controller_Plugin
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Cache extends \Zend\Controller\Plugin\AbstractPlugin
{
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
    public function routeStartup(\Zend\Controller\Request\AbstractRequest $request)
    {
        $this->_doCache($request);
    }

    /**
     * function called before dispatching
     *
     * @param \Zend\Controller\Request\AbstractRequest $request the Request
     *
     * @return void
     * @access public
     */
    public function dispatchLoopStartup(
        \Zend\Controller\Request\AbstractRequest $request)
    {
        $config    = \Zend\Registry::get('_config');
        $fileCache = null;

        if ($config->filecache->enable) {
            $fileCache = \Zend\Cache\Cache::factory(
                $config->filecache->frontend,
                $config->filecache->backend,
                $config->filecache->front->toArray(),
                $config->filecache->back->toArray()
            );
        }

        \Zend\Registry::set('_fileCache', $fileCache);
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
    private function _doCache(\Zend\Controller\Request\AbstractRequest $request)
    {
        //get requested file
        $file = $request->getRequestUri();

        if ('' == $file) {
            /*
             * no Request-Uri given (mostly while unit testing)
             * -> no Cache
             */
            return;
        }

        $config = \Zend\Registry::get('_config');

        if (!$config->sitecache->enable) {
            /*
             * site cache is not enabled
             * -> no Cache
             */
            return;
        }

        /*
         * set headers for javascript or style files
         * needed, if these files are delivered from cache
         * if not set here, the cached content is sent as "text/html"
         */
        /*
        if (substr($file, -4) == '.css') {
            header('Content-Type: text/css', true);
        } elseif (substr($file, -3) == '.js') {
            header('Content-Type: text/javascript', true);
        }
        */

        $optionsFront = array(
            'lifetime' => (int) $config->sitecache->lifetime,
            'debug_header' => (boolean) $config->sitecache->debug,
            'default_options' => $config->sitecache->defaults->toArray(),
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
                    'debug_header' => false, // allways disabled, causes javascript errors
                    'memorize_headers' => array(
                        'Content-Type',
                        'Content-Language',
                        'robots',
                        'Cache-Control',
                        'Last-Modified',
                        'Expires',
                        'Pragma'
                    )
                ),
                '^/css/' => array(
                    'cache' => true,
                    'make_id_with_post_variables' => false,
                    'memorize_headers' => array(
                        'Content-Type',
                        'Content-Language',
                        'robots',
                        'Cache-Control',
                        'Last-Modified',
                        'Expires',
                        'Pragma'
                    )
                ),
                '^/kredit/' => array(
                    'cache' => false
                ),
                '^/Kredit/' => array(
                    'cache' => false,
                    'memorize_headers' => array(
                        'Content-Type',
                        'Content-Language',
                        'robots',
                        'Cache-Control',
                        'Last-Modified',
                        'Expires',
                        'Pragma'
                    )
                ),
                '^/Kredit/index/antrag/' => array(
                    'cache' => false
                ),
                '^/curl/' => array(
                    'cache' => false,
                    'memorize_headers' => array(
                        'Content-Type',
                        'Content-Language',
                        'robots',
                        'Cache-Control',
                        'Last-Modified',
                        'Expires',
                        'Pragma'
                    )
                ),
                '^/curl/kredite/function/antrag' => array(
                    'cache' => false
                ),
                '^/curl/kredite.html?function=antrag' => array(
                    'cache' => false
                ),
                '^/iframe/' => array(
                    'cache' => false,
                    'memorize_headers' => array(
                        'Content-Type',
                        'Content-Language',
                        'robots',
                        'Cache-Control',
                        'Last-Modified',
                        'Expires',
                        'Pragma'
                    )
                ),
                '^/iframe/kredite/function/antrag' => array(
                    'cache' => false
                ),
                '^/iframe/kredite.html?function=antrag' => array(
                    'cache' => false
                ),
                '^/kredit-admin/' => array(
                    'cache' => false
                ),
                '^/geo/' => array(
                    'cache' => false
                ),
                '^/validate/' => array(
                    'cache' => false
                )
            )
        );

        $cache = \Zend\Cache\Cache::factory(
            $config->sitecache->frontend,
            $config->sitecache->backend,
            $optionsFront,
            $config->sitecache->back->toArray()
        );

        \Zend\Registry::set('siteCache', $cache);

        $cache->start();

        //nur bereinigen, wenn nicht im Cache
        $cache->clean(\Zend\Cache\Cache::CLEANING_MODE_OLD);
    }
}