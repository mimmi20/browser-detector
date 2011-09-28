<?php
/**
 * Controller-Klasse, die das Backend steuert
 *
 * PHP version 5
 *
 * @category  CreditCalc
 * @package   Controller
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * Controller-Klasse, die das Backend steuert
 *
 * @category  CreditCalc
 * @package   Controller
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_CategoriesController extends KreditCore_Controller_AdminAbstract
{
    /**
     * indexAction-Methode wird aufgerufen wenn keine Action angegeben wurde
     *
     * @return void
     */
    public function indexAction()
    {
        $modelApplications = new \App\Model\Categories();

        $pageNumber = $this->_getParam('page', 1, 'Int');
        $select     = $modelApplications->select();

        if (null !== $select) {
            $paginatorAdapter = new Zend_Paginator_Adapter_DbSelect(
                $select->order('name')
            );

            $this->createPagination($paginatorAdapter, $pageNumber);
        }

        $this->view->headTitle('Categories', 'PREPEND');
    }

    /**
     * Action zur Bearbeitung einer Category
     *
     * @return void
     */
    public function editAction()
    {
        $sparte = 0;

        //idCategories is set in update form
        // -> prefer idCategories
        if (isset($this->_requestData['idCategories'])) {
            $sparte = $this->_getParam('idCategories', 0, 'Int');
        } elseif (isset($this->_requestData['sparte'])) {
            $sparte = $this->_getParam('sparte', 0, 'Int');
        }

        $model = new \App\Model\Categories();
        $form  = $this->_getForm();

        $row = $this->getEditedRow($model, $sparte);

        if ($this->getRequest()->isPost()
            && false !== $this->getRequest()->getParam('submit', false)
        ) {
            if ($form->isValid($this->getRequest()->getParams())) {
                if ($sparte > 0) {
                     $model->update($form->getValues(), 'idCategories = ' . $sparte);
                } else {
                    $values = $form->getValues();
                    unset($values['idCategories']);
                    $model->insert($values);
                }

                $this->_redirector->gotoSimple(
                    'index',
                    'categories',
                    'kredit-admin'
                );
                return;
            }
        } else {
            $form->populate($row->toArray());
        }

        $this->view->form = $form;

        $this->view->headTitle('Category bearbeiten', 'PREPEND');
    }

    /**
     * Action zum Aktivieren/Deaktivieren einer Category
     *
     * @return void
     */
    public function activateAction()
    {
        if (!$this->_request->isGet() && !$this->_request->isPost()) {
            $this->broker('header')->setErrorHeaders();

            return;
        }

        $sparte = (int) $this->_getParam('sparte', 0, 'Int');

        if (0 < $sparte) {
            $active = (boolean) $this->_getParam('aktiv', 1, 'Int');
            $active = 1 - (int) $active;

            $model = new \App\Model\Categories();
            $model->update(array('active' => $active), 'idCategories = ' . $sparte);
        }

        $this->_redirector->gotoSimple(
            'index',
            'categories',
            'kredit-admin'
        );
    }

    /**
     * @return Zend_Form
     */
    private function _getForm()
    {
        // Liste aller Laufzeiten erstellen
        $loanPeriodModel = new \App\Model\Laufzeit();
        $select        = $loanPeriodModel->select()->order('value');
        $oLaufzeiten   = $loanPeriodModel->fetchAll($select);
        $loanPeriods    = array(0 => 'bitte wählen');

        foreach ($oLaufzeiten as $aktLaufzeit) {
            $loanPeriods[$aktLaufzeit->loanPeriod_id] = $aktLaufzeit->name;
        }

        // Form laden
        $front     = \Zend\Controller\Front::getInstance();
        $basePath  = $front->getModuleDirectory('kredit-admin');

        $config = new \Zend\Config\Ini(
            $basePath . '/configs/forms/sparte.ini',
            'form'
        );
        $form   = new Zend_Form($config);

        // Kampagnen
        $defaultLaufzeit = $form->getElement('defaultLaufzeit');
        $defaultLaufzeit->setMultiOptions($loanPeriods);

        return $form;
    }
}