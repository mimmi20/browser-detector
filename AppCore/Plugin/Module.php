<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Plugin;

/**
 * Plugin Class to define the main layout for the application
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Controller_Plugin
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */
 
use Zend\Controller\Request;
use Zend\Controller\Plugin\AbstractPlugin;

/**
 * Plugin Class to define the main layout for the application
 *
 * @category  Kreditrechner
 * @package   Controller_Plugin
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Module extends AbstractPlugin
{
    /**
     * function called before dispatching
     *
     * TODO: in Module_Controller_Plugin_ModuleInit verschieben
     *
     * @param \Zend\Controller\Request\AbstractRequest $request the Request
     *
     * @return void
     * @access public
     */
    public function dispatchLoopStartup(
        \Zend\Controller\Request\AbstractRequest $request)
    {
        
    }

    /**
     * converts the module name into the class name
     *
     * @param string $module
     *
     * @return string
     */
    private function _getModuleClassName($module)
    {
        $module = (string) $module;
        $module = str_replace(
            ' ', '', ucwords(str_replace(array('-', '.'), ' ', $module))
        );

        return $module;
    }
}