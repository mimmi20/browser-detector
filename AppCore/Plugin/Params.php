<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Plugin;

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
 * @version   SVN: $Id: Params.php 46 2011-08-10 18:50:42Z tmu $
 */
 
use Zend\Controller\Request;
use Zend\Controller\Plugin\AbstractPlugin;

/**
 * ActionHelper Class to detect the user agent and to set actions according to
 * it
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Params extends AbstractPlugin
{
    /**
     * @var array
     */
    private $_requestData = array();

    private $_logger = null;
    
    private $_config = null;

    /**
     * Class constructor
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
		$front = \Zend\Controller\Front::getInstance();
        $this->_config = new \Zend\Config\Config($front->getParam('bootstrap')->getOptions());
    }

    /**
     * Called after Zend_Controller_Router exits.
     *
     * Called after Zend_Controller_Front exits from the router.
     *
     * @param  \Zend\Controller\Request\AbstractRequest $request
     * @return void
     */
    public function routeShutdown(Request\AbstractRequest $request)
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

        mb_internal_encoding($encoding);
        mb_regex_encoding($encoding);

        foreach ($keys as $key) {
            $_SESSION->requestData[$key] = $this->getActionController()->getHelper('getParam')->getParamFromNameAndConvert($key, $encoding);
        }

        $view = $this->getActionController()->view;

        $view->setEncoding($encoding);
        $_SESSION->encoding = $encoding;
	}
    
    private function _setEncoding()
    {
        $allowedEncodings = array('iso-8859-1', 'iso-8859-15', 'utf-8', 'utf-16');

        //default encoding is defined in config
        $encoding = ((isset($this->_config->encoding))
                  ? $this->_config->encoding
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