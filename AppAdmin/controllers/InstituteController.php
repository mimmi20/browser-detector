<?php
/**
 * Controller-Klasse, die das Backend steuert
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
 * Controller-Klasse, die das Backend steuert
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_InstituteController
    extends KreditCore_Controller_AdminAbstract
{
    /**
     * indexAction-Methode wird aufgerufen wenn keine Action angegeben wurde
     *
     * @return void
     */
    public function indexAction()
    {
        $modelApplications = new \AppCore\Model\Institute();

        $pageNumber = $this->_getParam('page', 1, 'Int');
        $list       = $modelApplications->getList();

        if (false !== $list) {
            $paginatorAdapter = new Zend_Paginator_Adapter_DbSelect(
                $modelApplications->getList()
            );

            $this->createPagination($paginatorAdapter, $pageNumber);
        }

        $this->view->headTitle('Institute', 'PREPEND');
    }

    /**
     * Action zum Bearbeiten eines Institutes
     *
     * @return void
     */
    public function editAction()
    {
        $institut = 0;

        if (isset($this->_requestData['institut'])) {
            $institut = (int) $this->_getParam('institut', 0, 'Int');
        } elseif (isset($this->_requestData['idInstitutes'])) {
            $institut = (int) $this->_getParam('idInstitutes', 0, 'Int');
        }

        $model = new \AppCore\Model\Institute();
        $form  = $this->_getForm();

        $row = $this->getEditedRow($model, $institut);

        if ($this->getRequest()->isPost()
            && false !== $this->getRequest()->getParam('submit', false)
        ) {
            if ($form->isValid($this->getRequest()->getParams())) {
                if ($institut > 0) {
                    $row->setFromArray($form->getValues());
                } else {
                    $values = $form->getValues();
                    unset($values['idInstitutes']);
                    $row = $model->createRow($values);
                }

                $row->save();

                $this->_redirector->gotoSimple(
                    'index',
                    'institute',
                    'kredit-admin'
                );
                return;
            }
        } else {
            $form->populate($row->toArray());
        }

        $this->view->form = $form;

        $this->view->headTitle('Institut bearbeiten', 'PREPEND');
    }

    /**
     * Action zum Aktivieren/Deaktivieren eines Institutes
     *
     * @return void
     */
    public function activateAction()
    {
        if (!$this->_request->isGet() && !$this->_request->isPost()) {
            $this->_helper->header->setNotFoundHeaders();

            return;
        }

        $institut = (int) $this->_getParam('institut', 0, 'Int');

        if (0 < $institut) {
            $active   = (int) ((boolean) $this->_getParam('aktiv', 1, 'Int'));
            $active   = 1 - $active;

            $model = new \AppCore\Model\Institute();
            $model->update(
                array('active' => $active), 'idInstitutes = ' . $institut
            );
        }

        $this->_redirector->gotoSimple(
            'index',
            'institute',
            'kredit-admin'
        );
    }

    /**
     * @return Zend_Form
     */
    private function _getForm()
    {
        $front     = \Zend\Controller\Front::getInstance();
        $basePath  = $front->getModuleDirectory('kredit-admin');

        $config = new \Zend\Config\Ini($basePath .
            '/configs/forms/institut.ini', 'form');
        return new Zend_Form($config);
    }
}