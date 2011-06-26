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
        //get requested file
        $file = $request->getRequestUri();

        if ('' == $file) {
            /*
             * no Request-Uri given (mostly while unit testing)
             * -> no Cache
             */
            return;
        }

        $front = \Zend\Controller\Front::getInstance();
        $cache = $front->getParam('bootstrap')->getResource('cachemanager')->getCache('site');
        $cache->start();

        //nur bereinigen, wenn nicht im Cache
        $cache->clean(\Zend\Cache\Cache::CLEANING_MODE_OLD);
    }
}