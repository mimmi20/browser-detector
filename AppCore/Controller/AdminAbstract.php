<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Controller;

/**
 * Basis-Klasse für den Adminbereich mit Anmeldung
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
 * Basis-Klasse für den Adminbereich mit Anmeldung
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @abstract
 */
abstract class AdminAbstract extends ControllerAbstract
{
    /**
     * @var string the actual identity
     */
    protected $_identity;

    /**
     * @var Zend_Acl
     */
    protected $_acl;

    /**
     * @var integer
     */
    protected $_itemsPerPage = 10;

    /**
     * Class constructor
     *
     * The request and response objects should be registered with the
     * controller, as should be any additional optional arguments; these will be
     * available via {@link getRequest()}, {@link getResponse()}, and
     * {@link getInvokeArgs()}, respectively.
     *
     * When overriding the constructor, please consider this usage as a best
     * practice and ensure that each is registered appropriately; the easiest
     * way to do so is to simply call parent::__construct($request, $response,
     * $invokeArgs).
     *
     * After the request, response, and invokeArgs are set, the
     * {@link $_helper helper broker} is initialized.
     *
     * Finally, {@link init()} is called as the final action of
     * instantiation, and may be safely overridden to perform initialization
     * tasks; as a general rule, override {@link init()} instead of the
     * constructor to customize an action controller's instantiation.
     *
     * @param \Zend\Controller\Request\AbstractRequest  $request    the Request
     * @param Zend_Controller_Response_Abstract $response   the Response
     * @param array                             $invokeArgs Any additional
     *                                                      invocation arguments
     *
     * @return void
     * @access public
     */
    public function __construct(\Zend\Controller\Request\AbstractRequest $request,
        Zend_Controller_Response_Abstract $response,
        array $invokeArgs = array())
    {
        $request->setParamSources(array('_GET', '_POST'));
        parent::__construct($request, $response, $invokeArgs);
    }

    /**
     * initializes the Controller
     *
     * @return void
     * @access public
     */
    public function init()
    {
        parent::init();
        
        $this->_config = new \Zend\Config\Config($this->getInvokeArg('bootstrap')->getOptions());
    }

    /**
     * Check if a Identity is set. If we got no Identity, redirect to
     * Login Page.
     *
     * (non-PHPdoc)
     *
     * @see    library/Zend/Controller/Zend_Controller_Action#preDispatch()
     * @return void
     * @access public
     */
    public function preDispatch()
    {
        parent::preDispatch();

        //set headers
        if ($this->_response->canSendHeaders()) {
            $this->_response->setHeader(
                'Content-Type',
                'text/html; charset=' . \Zend\Registry::get('_encoding'),
                true
            );
            $this->_response->setHeader('robots', 'noindex,nofollow', true);
            $this->_response->setHeader(
                'Cache-Control', 'private, max-age=3600', true
            );
        }

        //block access to Admin Area, if not enabled
        if (!$this->_config->admin->enabled
            || (!$this->_config->admin->isAdmin && !$this->_config->admin->hasAdmin)
        ) {
            $this->_helper->header->setErrorHeaders();

            return;
        }

        if (!$this->_request->isGet() && !$this->_request->isPost()) {
            $this->_helper->header->setErrorHeaders();

            return;
        }

        $session  = new Zend_Session_Namespace('KREDIT');
        $loggedIn = false;

        $this->view->identity = null;
        $this->view->menues   = array();

        $errorMessage = '';

        if (isset($session->identity)
            && $session->identity instanceof Zend_Auth_Result
        ) {
            $identity = $session->identity->getIdentity();

            if ($identity) {
                $this->_createAcl();

                $resName = $this->_controller . '_' . $this->_action;
                $user    = $identity->getUser();
                $allowed = false;

                if (strtolower($user->Rolle) != 'gast') {
                    $allowed = $this->_acl->isAllowed($user->Rolle, $resName);
                }

                if ($allowed) {
                    $this->_identity      = $identity;
                    $this->view->identity = $identity;

                    $modelAcl    = new \AppCore\Model\Acl();
                    $basisRollen = $modelAcl->getBaseRolesByRoleName(
                        $user->Rolle
                    );
                    $rollen      = array();
                    $rollen[]    = $user->RolleId;

                    foreach ($basisRollen as $basisRolle) {
                        $rollen[] = $basisRolle->RolleId;
                    }

                    $nav = $this->_createNavigation($rollen);

                    $menu = new KreditCore_View_Helper_Navigation_Menu();
                    $menu->setView($this->view)
                        ->setAcl($this->_acl)
                        ->setRole($user->Rolle)
                        ->setUlClass('first-of-type');

                    $this->view->navlist = $menu->render($nav);

                    $loggedIn     = true;
                    $errorMessage = '';
                } else {
                    $errorMessage = 'Zugriff nicht erlaubt';
                }
            }
        }

        if (!$loggedIn) {
            $this->_forward(
                'show-login',
                'auth',
                'kredit-admin',
                array('error' => $errorMessage)
            );
        }
    }

    /**
     * indexAction-Methode wird aufgerufen wenn keine Action angegeben wurde
     *
     * @return void
     */
    public function indexAction()
    {
        //set headers
        $this->_helper->header->setErrorHeaders();
    }

    /**
     * @return void
     * @access public
     */
    protected function loadJs()
    {
        $this->view->headScript()->appendFile(
            $this->view->basedUrl('js/kredit.js')
        );
        $this->view->headScript()->appendFile(
            $this->view->basedUrl('js/date.js')
        );
        $this->view->headScript()->appendFile(
            $this->view->basedUrl('js/stat.js')
        );
        $this->view->headScript()->appendFile(
            $this->view->basedUrl('js/jquery/jquery-ui-1.8.6.custom.min.js')
        );
        $this->view->headScript()->appendFile(
            $this->view->basedUrl('js/jquery/jquery.unister.tooltip.js')
        );
        $this->view->headScript()->appendFile(
            $this->view->basedUrl('js/jquery/flot/jquery.flot.js')
        );
        $this->view->headScript()->appendFile(
            $this->view->basedUrl('js/jquery/flot/jquery.flot.pie.js')
        );
        $this->view->headScript()->appendFile(
            $this->view->basedUrl('js/jquery/excanvas.compiled.js')
        );
        $this->view->headScript()->appendFile(
            $this->view->basedUrl('js/overlibmws/overlibmws.js')
        );
        $this->view->headScript()->appendFile(
            $this->view->basedUrl('js/overlibmws/overlibmws_modal.js')
        );
        $this->view->headScript()->appendFile(
            $this->view->basedUrl('js/overlibmws/overlibmws_hide.js')
        );
        $this->view->headScript()->appendFile(
            $this->view->basedUrl('js/number-functions.js')
        );
        $this->view->headLink()->appendStylesheet(
            $this->view->basedUrl('css/jquery/jquery-ui-1.8.6.custom.css'),
            'screen',
            false
        );
        $this->view->headLink()->appendStylesheet(
            $this->view->basedUrl('css/tabs.css'),
            'screen',
            false
        );
    }

    /**
     * Creates ACL
     *
     * @return void
     * @access private
     */
    private function _createAcl()
    {
        // TODO: Add cacheing
        $this->_acl = new Zend_Acl();
        $this->_setupRoles();
        $this->_setupResources();

        \Zend\Registry::set('_acl', $this->_acl);
    }

    /**
     * Creates roles from Database
     *
     * @return void
     * @access private
     */
    private function _setupRoles()
    {
        $modelAcl = new \AppCore\Model\Acl();

        // Basis-Rollen
        $roles = $modelAcl->getRoles('Basis');
        foreach ($roles as $role) {
            $this->_acl->addRole(new Zend_Acl_Role($role->name));
        }

        // Benutzer-Rollen
        $roles = $modelAcl->getRoles('Benutzer');
        foreach ($roles as $role) {
            $parents = (trim($role->elternrollen) != '')
                     ? explode(',', $role->elternrollen)
                     : null;

            if (!is_null($parents)) {
                $this->_acl->addRole(new Zend_Acl_Role($role->name), $parents);
            } else {
                $this->_acl->addRole(new Zend_Acl_Role($role->name));
            }
        }
    }

    /**
     * Loads resources from database
     *
     * @return void
     * @access private
     */
    private function _setupResources()
    {
        // Ressourcen
        $modelAcl   = new \AppCore\Model\Acl();
        $ressources = $modelAcl->getResourcesRoles();

        foreach ($ressources as $res) {
            if (!$this->_acl->hasRole($res['rolle'])) {
                $this->_logger->err(
                    'Rolle \'' . $res['rolle'] . '\' dont exist'
                );

                continue;
            }

            if (!$this->_acl->has($res['ressource'])) {
                $this->_acl->addResource(
                    new Zend_Acl_Resource($res['ressource'])
                );
            }

            switch ($res['recht']) {
                case 'allow':
                    $this->_acl->allow($res['rolle'], $res['ressource']);
                    break;
                case 'deny':
                default:
                    $this->_acl->deny($res['rolle'], $res['ressource']);
                    break;
            }
        }
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

        if ($this->_config->navicache->enable) {
            $cache = \Zend\Cache\Cache::factory(
                $this->_config->navicache->frontend,
                $this->_config->navicache->backend,
                $this->_config->navicache->front->toArray(),
                $this->_config->navicache->back->toArray()
            );
        }

        $cacheId = 'navi_' . ((is_array($rollen))
                 ? implode('_', $rollen)
                 : $rollen);

        if (!is_object($cache)
            || !$navigation = $cache->load($cacheId)
        ) {
            $navigation = new Zend_Navigation();
            $parents    = array();
            $resources  = array();

            $resourcesModel = new \AppCore\Model\Resources();
            /*
            $resArray       = $resourcesModel->fetchAll()->toArray();
            foreach ($resArray as $resource) {
                $resources[$resource['RessourceId']] = $resource['Controller'];
            }
            */
            $resources = $resourcesModel->getList();

            $navigationModel = new \AppCore\Model\Navigation();
            $navigationItems = $navigationModel->getNavigation($rollen);

            foreach ($navigationItems as $nav) {
                if (isset($nav['parent_id']) && $nav['parent_id'] != 0) {
                    $parents[$nav['parent_id']] = true;
                }
            }

            foreach ($navigationItems as $nav) {
                $page = new \Zend\Navigation\AbstractPage_Mvc();

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

    /**
     * sucht einen Datensatz oder erstellt einen neuen
     *
     * @param \\AppCore\\Model\ModelAbstract $model das Datenmodell
     * @param integer                           $rowNumber die ID des zu
     *                                          öffnenden Datensatzes
     *
     * @return \Zend\Db\Table\Row der gefundene oder erstellte Datensatz
     * @access protected
     */
    protected function getEditedRow(
        \\AppCore\\Model\ModelAbstract $model, $rowNumber = 0)
    {
        $rowNumber = (int) $rowNumber;

        if ($rowNumber > 0) {
            $row = $model->find($rowNumber)->current();
        } else {
            $row = $model->createRow();
        }

        return $row;
    }

    /**
     * Disable View Renderer
     *
     * @return void
     * @access protected
     */
    protected function initAjax()
    {
        $this->_helper->viewRenderer->setNoRender();
        //$this->_helper->layout->disableLayout();
    }

    /**
     * ertsllt eine Pagination
     *
     * @param Zend_Paginator_Adapter_Interface $paginatorAdapter the paginator
     * @param integer                          $pageNumber       the actual page
     *                                                           number
     * @param string                           $validationFunction the function
     *                                         to create a validated array
     *
     * @return void
     * @access protected
     */
    protected function createPagination(
        Zend_Paginator_Adapter_Interface $paginatorAdapter,
        $pageNumber,
        $validationFunction = 'getValidPaginationApps')
    {
        $queryPaginator = new Zend_Paginator($paginatorAdapter);

        $queryPaginator->setCurrentPageNumber($pageNumber);
        $queryPaginator->setItemCountPerPage($this->_itemsPerPage);

        $applications = $queryPaginator->getAdapter()->getItems(
            ($pageNumber - 1) * $this->_itemsPerPage,
            $this->_itemsPerPage
        );

        if (!method_exists($this, $validationFunction)) {
            $validationFunction = 'getValidPaginationApps';
        }

        $validApplications = $this->$validationFunction($applications);

        $paginator = new Zend_Paginator(
            new Zend_Paginator_Adapter_Array($validApplications)
        );
        $paginator->setItemCountPerPage($this->_itemsPerPage);
        $paginator->setCurrentPageNumber($pageNumber);


        $this->view->paginator      = $paginator;
        $this->view->queryPaginator = $queryPaginator;

        $this->view->search_key  = $this->_helper->getParam('key', '');
        $this->view->search_name = $this->_helper->getParam('name', '');
    }

    /**
     * erstellt eine Liste mit Werten zur Anzeige und filtert diese
     *
     * @param array $applications the paginator
     *
     * @return void
     * @access protected
     */
    protected function getValidPaginationApps(array $applications = array())
    {
        $validApplications = array();

        foreach ($applications as $key => $row) {
            $validApplications[$key] = $row;

            //Get Content
            $validApplications[$key]->Content = array();
        }

        return $validApplications;
    }
}