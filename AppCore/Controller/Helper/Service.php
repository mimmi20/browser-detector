<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Controller\Helper;

/**
 * Service-Finder für alle Kredit-Services
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
 * Service-Finder für alle Kredit-Services
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Service extends \Zend\Controller\Action\Helper\AbstractHelper
{
    private $_services = array();

    /**
     * loads the service class
     *
     * @param string $service The name of the Service
     * @param string $module  The name of the module
     *
     * @return \\AppCore\\Service\Abstract The servics class
     * @access public
     */
    public function getService($service, $module = 'kredit-core')
    {
        if (!isset($this->_services[$module][$service])) {
            $class = implode(
                '_',
                array(
                    $this->_getClassName($module),
                    'Service',
                    $this->_getClassName($service)
                )
            );

            $front = \Zend\Controller\Front::getInstance();
            $classPath = $front->getModuleDirectory($module)
                       . DS . 'services' . DS
                       . $this->_getClassName($service) . '.php';

            if (!file_exists($classPath)) {
                return false;
            }

            $this->_services[$module][$service] = new $class();
        }

        return $this->_services[$module][$service];
    }

    /**
     * Default-Methode für Services
     *
     * wird als Alias für die Funktion {@link getService} verwendet
     *
     * @param string $service The name of the Service
     * @param string $module  The name of the module
     *
     * @return \\AppCore\\Service\Abstract The servics class
     * @access public
     */
    public function direct($service, $module = 'kredit-core')
    {
        return $this->getService($service, $module);
    }

    /**
     * generiert den Klassennamen aus dem Modulnamen
     *
     * @param string $module der Modulname
     *
     * @return string der Klassenname
     * @access private
     */
    private function _getClassName($module)
    {
        $module = (string) $module;
        $module = str_replace(
            ' ', '', ucwords(str_replace(array('-', '.'), ' ', $module))
        );

        return $module;
    }
}