<?php
/**
 * Controller-Klasse, zur Authentifizierung eines Benutzers
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * Controller-Klasse, zur Authentifizierung eines Benutzers
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_AuthController extends KreditCore_Controller_Abstract
{
    private _config = null;

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

            $this->broker('header')->setDefaultHeaders();
        }

        //block access to Admin Area, if not enabled
        if (!$this->_config->admin->enabled
            || (!$this->_config->admin->isAdmin && !$this->_config->admin->hasAdmin)
        ) {
            $this->broker('header')->setErrorHeaders();

            return;
        }

        if (!$this->_request->isGet() && !$this->_request->isPost()) {
            $this->broker('header')->setErrorHeaders();

            return;
        }
    }

    /**
     * an Alias for the showLoginAction
     *
     * @return void
     * @access public
     */
    public function loginAction()
    {
        $errorMsg = $this->_getParam('error', null);
        $message  = $this->_getParam('msg', '');
        $this->_forward(
            'show-login',
            'auth',
            'kredit-admin',
            array('error' => $errorMsg, 'msg' => $message)
        );
    }

    /**
     * Display Login Form
     *
     * @return void
     */
    public function showLoginAction()
    {
        $form = $this->_getForm();

        $this->view->form = $form;

        if ($errorMsg = $this->_getParam('error', null)) {
            switch ($errorMsg) {
                case 'nopost':
                    $message = 'wrong request';
                    $this->_logger->warn($message);
                    break;
                case 'novalid':
                    $message = 'Logindaten fehlerhaft!';
                    $this->_logger->warn(
                        'Logindaten fehlerhaft. Wahrscheinlich wurden ' .
                        'Benutzername und/oder Passwort nicht eingegeben.'
                    );
                    break;
                case 'authfailed':
                    $message = $this->_getParam('msg', '');
                    $this->_logger->warn($message);

                    if ($message != '') {
                        $message = explode('::', $message);
                        $message = '<ul><li>'
                                 . implode('</li><li>', $message)
                                 . '</li></ul>';
                    }
                    break;
                case 'loginfailed':
                default:
                    $message = 'Login fehlgeschlagen!';
                    $this->_logger->warn($message);
                    break;
            }
            $this->view->message = $message;
        } else if ($this->_getParam('logoff', null)) {
            $this->view->message = 'Erfolgreich ausgeloggt!';
        }
    }

    /**
     * Do Login
     *
     * @return void
     */
    public function doLoginAction()
    {
        if (!$this->_request->isGet() && !$this->_request->isPost()) {
            $this->broker('header')->setErrorHeaders();

            return;
        }

        if ($this->_request->isPost()) {
            $params = $this->_request->getParams();

            $form = $this->_getForm();
            $form->populate($params);
            if ($form->isValid($params)) {
                $auth     = Zend_Auth::getInstance();
                $account  = new \AppCore\Model\Bearbeiter();
                $name     = $form->getElement('name')->getValue();
                $password = $form->getElement('password')->getValue();

                //Try to Autenticate - first Level
                $account->setCredentials($name, $password);
                $authResult = $auth->authenticate($account);

                /*
                 * double check if the LDAP is enabled
                 */
                if ($authResult->isValid()
                    && $authResult->getCode() == Zend_Auth_Result::SUCCESS
                    && $this->_config->ldap->enabled == 1
                ) {
                    /*
                     * u.woithe Change 2010-11-18 for Bug30718
                     */
                    $resultAuthLdap = new KreditCore_Class_Auth_Ldap(
                        $name,
                        $password,
                        $auth
                    );
                    $resultLdap = $resultAuthLdap->authenticate();
                    $resultCode = $resultLdap->getCode();

                    if ($resultCode != Zend_Auth_Result::SUCCESS) {
                        /*
                         * Search in LDAP was not successfull
                         */
                        $this->_logger->warn(
                            'Benutzerkonto \'' . $name .
                            '\' ist in der Datenbank nicht vorhanden oder ' .
                            'Passwort falsch.'
                        );

                        $authResult = clone($resultLdap);
                    }
                    // u.woithe End
                }

                if (!$authResult->isValid()) {
                    $this->_destroyIdendity();

                    $this->_redirector->gotoSimple(
                        'show-login',
                        'auth',
                        'kredit-admin',
                        array(
                            'error' => 'authfailed',
                            'msg'   => 'Logindaten fehlerhaft'
                        )
                    );
                    return;
                } else {
                    if ($authResult->getCode() != Zend_Auth_Result::SUCCESS) {
                        $this->_destroyIdendity();

                        $message = urlencode(
                            implode('::', $authResult->getMessages())
                        );

                        $this->_redirector->gotoSimple(
                            'show-login',
                            'auth',
                            'kredit-admin',
                            array(
                                'error' => 'authfailed',
                                'msg'   => $message
                            )
                        );
                        return;
                    } else {
                        $session = new Zend_Session_Namespace('KREDIT');
                        $session->identity = $authResult;
                        $this->_redirector->gotoSimple(
                            'index',
                            'index',
                            'kredit-admin'
                        );
                        return;
                    }
                }
            } else {
                $this->_destroyIdendity();

                $this->_redirector->gotoSimple(
                    'show-login',
                    'auth',
                    'kredit-admin',
                    array('error' => 'novalid')
                );
                return;
            }
        } else {
            $this->_destroyIdendity();

            $this->_redirector->gotoSimple(
                'show-login',
                'auth',
                'kredit-admin',
                array(
                    'error' => 'nopost'
                )
            );
            return;
        }
    }

    /**
     * Logout
     *
     * @return void
     */
    public function logoffAction()
    {
        $this->_destroyIdendity();

        if (!$this->_request->isGet() && !$this->_request->isPost()) {
            $this->broker('header')->setErrorHeaders();

            return;
        }

        $this->_redirector->gotoSimple(
            'index',
            'index',
            'kredit-admin',
            array(
                'logoff' => 1
            )
        );
    }

    /**
     * @return Zend_Form
     */
    private function _getForm()
    {
        $front     = \Zend\Controller\Front::getInstance();
        $basePath  = $front->getModuleDirectory('kredit-admin');

        $this->_config = new \Zend\Config\Ini($basePath .
                    '/configs/forms/login.ini', 'form');

        return new Zend_Form($this->_config);
    }

    /**
     * Logout
     *
     * @return void
     */
    private function _destroyIdendity()
    {
        $session = new Zend_Session_Namespace('KREDIT');

        $session->identity = null;
        Zend_Auth::getInstance()->clearIdentity();
    }
}