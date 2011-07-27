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
class Params extends \Zend\Controller\Action\Helper\AbstractHelper
{
    /**
     * @var array
     */
    protected $_requestData = array();

    protected $_logger = null;

    /**
     * Class constructor
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->_logger = \Zend\Registry::get('log');
    }

    /**
     * detects and logs the user agent
     *
     * @param string $service The name of the Service
     * @param string $module  The name of the module
     *
     * @return void
     */
    public function get($return = false, $useNegotiation = false)
    {
        $request = $this->getRequest();

        $this->_requestData = $request->getParams();

        $keys = array_keys($this->_requestData);

        /*
         * delete the super globals
         */
        $_GET     = array();
        $_POST    = array();
        $_REQUEST = array();

        $encoding = $this->_setEncoding();

        \Zend\Registry::set('_encoding', $encoding);

        mb_internal_encoding($encoding);
        mb_regex_encoding($encoding);

        foreach ($keys as $key) {
            $this->_requestData[$key] = $this->getActionController()->getHelper('getParam')->direct($key, $encoding);
        }

        $view = $this->getActionController()->view;

        $view->setEncoding($encoding);
        //$view->encoding = $encoding;

        $this->_setParams($request, $return);
    }

    /**
     * Default-Methode für Services
     *
     * wird als Alias für die Funktion {@link log} verwendet
     *
     * @return null|array
     */
    public function direct($return = false)
    {
        return $this->get($return);
    }
    
    private function _setParams($request, $return = false)
    {
        $keys = array_keys($this->_requestData);

        foreach ($keys as $key) {
            $request->setParam($key, $this->_requestData[$key]);
        }
        
        return $return ? $this->_requestData : null;
    }
    
    private function _setEncoding()
    {
        $config = \Zend\Registry::get('_config');

        $allowedEncodings = array('iso-8859-1', 'iso-8859-15', 'utf-8', 'utf-16');

        //default encoding is defined in config
        $encoding = ((isset($config->encoding))
                  ? $config->encoding
                  : 'iso-8859-1');

        //encoding is requested from portal
        if (isset($this->_requestData['encoding'])
            && is_string($this->_requestData['encoding'])
        ) {
            $encoding = $this->_getEncoding($this->_requestData['encoding']);
        }

        if (!in_array($encoding, $allowedEncodings)) {
            $encoding = 'iso-8859-1';
        }
        
        return $encoding;
    }
    
    private function _getEncoding($encodingParam)
    {
        switch ($encodingParam) {
            case 'iso-8859-15':
            case 'iso15':
                $encoding = 'iso-8859-15';
                break;
            case 'utf-16':
            case 'utf16':
                $encoding = 'utf-16';
                break;
            case 'iso-8859-1':
            case 'iso':
                $encoding = 'iso-8859-1';
                break;
            case 'utf-8':
            case 'utf8':
            default:
                $encoding = 'utf-8';
                break;
        }
        
        return $encoding;
    }
}