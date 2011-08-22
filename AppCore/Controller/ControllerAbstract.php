<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Controller;

/**
 * abstrakte Basis-Klasse für alle Controller
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

use Zend\Controller\Request\AbstractRequest,
    Zend\Controller\Response\AbstractResponse;

/**
 * abstrakte Basis-Klasse für alle Controller
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @abstract
 */
abstract class ControllerAbstract extends \Zend\Rest\Controller
{
    /**
     * Database object
     *
     * @var Zend_Db_Adapter_Pdo_Mysql
     */
    protected $_db = null;

    /**
     * App config
     *
     * @var \Zend\Config\Ini
     */
    protected $_config;

    /**
     * @var string the actual controller
     */
    protected $_controller ='';

    /**
     * @var string the actual action
     */
    protected $_action = '';

    /**
     * @var string the actual module
     */
    protected $_module = '';

    /**
     * @var Zend_Controller_Action_Helper_Redirector
     */
    protected $_redirector = null;
    
    /**
     * @var Zend_Controller_Action_Helper_ContextSwitch
     */
    protected $_context = null;

    /**
     * a Logger Instance
     * @var \Zend\Log\Logger
     */
    protected $_logger = null;
    
    protected $_time = 0;

    /**
     * initializes the Controller
     *
     * @return void
     * @access public
     */
    public function init()
    {
        $this->initView();
        try {
        $this->_config = new \Zend\Config\Config($this->getInvokeArg('bootstrap')->getOptions());
		$this->_logger = $this->getInvokeArg('bootstrap')->getResource('log');
		
        $this->_request  = $this->getRequest();
        $this->_response = $this->getResponse();

        //var_dump(strtolower($this->_request->getActionName()));
        //var_dump(strtolower($this->_request->getControllerName()));
        //var_dump(strtolower($this->_request->getModuleName()));

        
        $this->_redirector = $this->broker('Redirector');
		$this->getFrontController()->getHelperBroker()->register('contentNegogation', new \AppCore\Controller\Helper\ContentNegogation());
		
		$this->_context  = $this->broker('contentNegogation');
		$this->_context->setConfig($this->_config->negogation);
		
		//var_dump(1, $this->_redirector, $this->_context);
		$this->getFrontController()->getHelperBroker()->register('header', new \AppCore\Controller\Helper\Header());
        $this->getFrontController()->getHelperBroker()->register('params', new \AppCore\Controller\Helper\Params());//getStack()->push(new \AppCore\Controller\Helper\Params())
        $this->getFrontController()->getHelperBroker()->register('getParam', new \AppCore\Controller\Helper\GetParam());
        $this->getFrontController()->getHelperBroker()->register('agentLogger', new \AppCore\Controller\Helper\AgentLogger());
		$this->getFrontController()->getHelperBroker()->register('requestLogger', new \AppCore\Controller\Helper\RequestLogger());
		
		$this->broker('params')->direct(true);

        $this->_action     = strtolower($this->_request->getActionName());
        $this->_controller = strtolower($this->_request->getControllerName());
        $this->_module     = strtolower($this->_request->getModuleName());

        $this->_db = \Zend\Db\Table\AbstractTable::getDefaultAdapter();
		
		} catch (\Exception $e) {
			var_dump($e->getMessage(), $e->getTraceAsString());
		}
    }

    /**
     * (non-PHPdoc)
     *
     * @see    library/Zend/Controller/Zend_Controller_Action#preDispatch()
     * @return void
     * @access public
     */
    public function preDispatch()
    {
        $this->_time = \microtime(true);
        parent::preDispatch();

        //set headers
		$this->broker('header')->setDefaultHeaders();
		$this->broker('agentLogger')->direct();
		$this->broker('requestLogger')->direct();
        
        $layout = \Zend\Layout\Layout::getMvcInstance();
        $this->_context->setLayout($layout);
        $this->_context->initContext($this->_helper->getParam('format', null));

        
        //var_dump($this->getRequest()->getActionName(), $this->getRequest()->getControllerName());
        
        //set headers
        if ($this->_response->canSendHeaders()) {
            $this->_response->setHeader('robots', 'noindex,follow', true);
            $this->_response->setHeader(
                'Cache-Control', 'public, max-age=3600', true
            );
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see    library/Zend/Controller/Zend_Controller_Action#preDispatch()
     * @return void
     * @access public
     */
    public function postDispatch()
    {
        $this->view->duration = \microtime(true) - $this->_time;
        
        parent::postDispatch();
    }

    /**
     * decodes an value from utf-8 to iso
     *
     * @param string  $item     the string to decode
     * @param boolean $entities an flag,
     *                          if TRUE the string will be encoded with
     *                          htmlentities
     *
     * @return string
     * @access protected
     */
    protected function decode($item, $entities = true)
    {
        return \AppCore\Globals::decode($item, $entities);
    }

    /**
     * encodes an value from iso to utf-8
     *
     * @param string  $item     the string to decode
     * @param boolean $entities (Optional) an flag,
     *                          if TRUE the string will be encoded with
     *                          html_entitiy_decode
     *
     * @return string
     * @access protected
     */
    protected function encode($item, $entities = true)
    {
        return \AppCore\Globals::encode($item, $entities);
    }

    /**
     * formats the content string for the spefied output
     *
     * @param string $text the text to format
     *
     * @return string the formated output
     * @access protected
     */
    protected function format($text)
    {
        return $text;
    }

    /**
     * lädt die Partner/Campaign-ID
     *
     * @param mixed $value die Partner/Campaign-ID
     *
     * @return void
     * @access protected
     */
    protected function loadPaid($value)
    {
        $agent           = '';
        $campaignService = new \AppCore\Service\Campaigns();

        $campaignService->loadCaid(
            $value,
            $this->_requestData,
            $agent,
            $this->_paid,
            $this->_caid,
            $this->_hostName
        );

        $this->_campaignId = $campaignService->getName($this->_caid);

        $portalService    = new \AppCore\Service\PartnerSites();
        $this->_partnerId = $portalService->getName($this->_paid);
    }

    /**
     * checkt die Partner-ID
     *
     * @param mixed $value der Wert, der geprüft werden soll
     *
     * @return boolean
     * @access protected
     */
    protected function checkPaid($value)
    {
        return \AppCore\Globals::checkPaid($value);
    }

    /**
     * Recursively stripslashes string/array
     *
     * @param mixed $var the variable to clean
     *
     * @return mixed
     * @access protected
     */
    protected function clean($var)
    {
        if (true === $var
            || false === $var
            || is_object($var)
            || is_numeric($var)
        ) {
            return $var;
        } elseif (is_array($var)) {
            return array_map(array($this, '_clean'), $var);
        }

        $var = stripslashes($var);
        $var = strip_tags($var);
        $var = trim($var);

        return $var;
    }

    /**
     * Recursively stripslashes string/array
     *
     * @return array
     * @access protected
     */
    /*
    protected function getParams()
    {
        $sources = $this->_request->getParamSources();
        $this->_request->setParamSources(array());

        $params = $this->_request->getParams();

        if (in_array('_GET', $sources)) {
            $params = array_merge($params, $_GET);
        }

        if (in_array('_POST', $sources)) {
            $params = array_merge($params, $_POST);
        }

        $this->_requestData = array_map(
            array($this, 'clean'),
            $params
        );

        $this->_request->setParamSources($sources);

        return $this->_requestData;
    }

    /**
     * reduces the size of generated css and/or js files by deleting spaces
     *
     * @param string  $text the file content to compress
     *
     * @return string the formated output
     * @access protected
     */
    protected function compress($text)
    {
        //$text = preg_replace('/\/\/.*$/i', '', $text);
        $text = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $text);
        $text = str_replace(array("\r\n", "\r", "\n", "\t"), ' ', $text);
        $text = preg_replace('/\s\s+/', ' ', $text);
        $text = str_replace('> <', '><', $text);
        $text = trim($text);

        return $text;
    }
}