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
     * @var string the actual identity
     */
    protected $_identity;

    /**
     * @var Zend_Acl
     */
    protected $_acl;

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

        $this->_redirector = $this->_helper->Redirector;
		
		$this->_context  = $this->_helper->contentNegogation();
		$this->_context->setConfig($this->_config->negogation);
		
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
		$this->_helper->header()->setDefaultHeaders();
        
        $layout = \Zend\Layout\Layout::getMvcInstance();
        $this->_context->setLayout($layout);
        $this->_context->initContext($this->_helper->getParam('format', null));

        
        //set headers
        if ($this->_response->canSendHeaders()) {
            $this->_response->setHeader('x-robots-tag', 'noindex,follow', true);
            $this->_response->setHeader(
                'Cache-Control', 'public, max-age=3600', true
            );
        }
		
		$this->view->identity = null;
		$loggedIn             = false;
		$errorMessage         = '';
		
		if (!isset($_SESSION->identity)/*
			|| !($_SESSION->identity instanceof \Zend\Auth\Result)*/
		) {
			$userService = new \App\Model\Users();
			$user = $userService->find(\App\Model\Users::USER_GUEST)->current();
			/*
			$_SESSION->identity = new \Zend\Auth\Result(
                \Zend\Auth\Result::SUCCESS,
                new \App\Auth\Identity($user),
                array()
            );
			/**/
			$_SESSION->identity = new \App\Auth\Identity($user);
		}
		
		$identity = $_SESSION->identity->getIdentity();
		$resName  = '';
		
		if ($identity) {
			$this->_createAcl();
			
			$ressourceParams = array(
				'controller',
				$this->_module,
				$this->_controller,
				$this->_action
			);

			$resName = implode('_', $ressourceParams);
			
			$user    = $identity->getUser();
			$role    = $identity->getRolle();
			$allowed = $this->_acl->isAllowed($role, $resName);
			//var_dump($allowed, $user, $role, $resName);exit;
			if ($allowed) {
				$this->_identity      = $identity;
				$this->view->identity = $identity;

				$modelAcl    = new \App\Service\Acl();
				$basisRollen = $modelAcl->getBaseRolesByRoleName($role);
				$rollen      = array();
				$rollen[]    = $identity->getRolleId();

				foreach ($basisRollen as $basisRolle) {
					$rollen[] = $basisRolle->RolleId;
				}

				$nav  = $this->_createNavigation($rollen);
				$menu = new \AppCore\View\Helper\Navigation\Menu();
				$menu->setView($this->view)
					->setAcl($this->_acl)
					->setRole($role)
					->setUlClass('first-of-type');

				$menuOptions = array(
					'ulClass'  => 'first-of-type',
					'indent'   => '                        ',
					'minDepth' => 0,
					'maxDepth' => 3,
					'onlyActiveBranch' => false
				);
				
				$this->view->navlist = $menu->render($nav);

				$loggedIn     = true;
				$errorMessage = '';
			} else {
				$errorMessage = 'Zugriff nicht erlaubt';
			}
		}

		//var_dump(isset($_SESSION->identity), $resName, $allowed, $loggedIn);exit;
		
		if (!$loggedIn && 'not-logged-in' != $this->_action) {
            $this->_forward(
                'not-logged-in',
                null,
                null,
                array('error' => $errorMessage)
            );
        }
    }

    /**
     * Creates ACL
     *
     * @return void
     */
    private function _createAcl()
    {
        $this->_acl = \Zend\Registry::get('_acl');
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

    /**
     * Creates Navigation object
     *
     * @param mixed $rollen the roles to be in the Navigation
     *
     * @return void
     * @access private
     */
    private function _createNavigation($rollen)
    {
        $cache  = null;

        $front = \Zend\Controller\Front::getInstance();
		$cache = $front->getParam('bootstrap')->getResource('cachemanager')->getCache('navi');

        $cacheId = 'navi_' . ((is_array($rollen))
                 ? implode('_', $rollen)
                 : $rollen);

        if (!is_object($cache)
            || !$navigation = $cache->load($cacheId)
        ) {
            $navigation = new \Zend\Navigation\Navigation();
            $parents    = array();
            $resources  = array();

            $resourcesModel = new \App\Model\Resources();
            /*
            $resArray       = $resourcesModel->fetchAll()->toArray();
            foreach ($resArray as $resource) {
                $resources[$resource['RessourceId']] = $resource['Controller'];
            }
            */
            $resources = $resourcesModel->getList();

            $navigationModel = new \App\Model\Navigation();
            $navigationItems = $navigationModel->getNavigation($rollen);

            foreach ($navigationItems as $nav) {
                if (isset($nav['parent_id']) && $nav['parent_id'] != 0) {
                    $parents[$nav['parent_id']] = true;
                }
            }

            foreach ($navigationItems as $nav) {
                $page = new \Zend\Navigation\Page\Mvc();

                $page
                    ->setController($resources[$nav['resource_id']])
                    ->setAction($nav['res_action'])
                    ->setModule('kredit-admin')
                    ->setLabel($nav['nav_name'])
                    ->setTitle($nav['nav_name'])
                    ->setResource($resources[$nav['resource_id']]);

                $page->navigation_id = $nav['nav_id'];

                if ($nav['parent_id'] == 0) {
                    if (array_key_exists($nav['nav_id'], $parents)) {
                        $navigation->addPage($page);
                        $newPage = clone $page;
                        $newPage->navigation_id = null;
                        $page->addPage($newPage);
                    } else {
                        $navigation->addPage($page);
                    }
                } else {
                    $container = $navigation->findOneBy(
                        'navigation_id', $nav['parent_id']
                    );
                    $container->addPage($page);
                }
            }

            if (is_object($cache)) {
                $cache->save($navigation, $cacheId);
            }
        }

        \Zend\Registry::set('navigation', $navigation);

        return $navigation;
    }
}