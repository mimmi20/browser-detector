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
class KreditAdmin_ZinsController extends KreditCore_Controller_AdminAbstract
{
    /**
     * Action zur Bearbeitung eines Zinssatzes
     *
     * @return void
     */
    public function editAction()
    {
        if (!$this->_request->isGet() && !$this->_request->isPost()) {
            $this->_helper->header->setErrorHeaders();

            return;
        }

        if (isset($this->_requestData['product'])) {
            $product = (int) $this->_getParam('product', 0, 'Int');
        } elseif (isset($this->_requestData['idProducts'])) {
            $product = (int) $this->_getParam('idProducts', 0, 'Int');
        } else {
            $product = 0;
        }

        if (!$product) {
            $this->_redirector->gotoSimple(
                'index',
                'products',
                'kredit-admin'
            );
            return;
        }

        if (isset($this->_requestData['zins'])) {
            $zinsId = (int) $this->_getParam('zins', 0, 'Int');
        } elseif (isset($this->_requestData['uid'])) {
            $zinsId = (int) $this->_getParam('uid', 0, 'Int');
        } else {
            $zinsId = 0;
        }

        $model = new \AppCore\Model\Zins();
        $form  = $this->_getForm();

        $row = $this->getEditedRow($model, $zinsId);
        $row['idProducts'] = $product;

        if ($this->getRequest()->isPost()
            && false !== $this->getRequest()->getParam('submit', false)
        ) {
            if ($form->isValid($this->getRequest()->getParams())) {
                if ($zinsId > 0) {
                    $row->setFromArray($form->getValues());
                } else {
                    $values = $form->getValues();
                    unset($values['uid']);
                    $row = $model->createRow($values);
                }

                /*
                 * normalize values
                 * set to NULL if it is zero
                 */
                $row->zinssatz = $this->_helper->normalizeNumber(
                    $row->zinssatz
                );
                $row->zinssatzunten = $this->_helper->normalizeNumber(
                    $row->zinssatzunten
                );
                if (0 == $row->zinssatzunten) {
                    $row->zinssatzunten = null;
                }
                $row->zinssatzoben = $this->_helper->normalizeNumber(
                    $row->zinssatzoben
                );
                if (0 == $row->zinssatzoben) {
                    $row->zinssatzoben = null;
                }
                $row->zinssatz23 = $this->_helper->normalizeNumber(
                    $row->zinssatz23
                );
                if (0 == $row->zinssatz23) {
                    $row->zinssatz23 = null;
                }
                $row->zinssatzR = $this->_helper->normalizeNumber(
                    $row->zinssatzR
                );
                if (0 == $row->zinssatzR) {
                    $row->zinssatzR = null;
                }
                $row->zinssatzN = $this->_helper->normalizeNumber(
                    $row->zinssatzN
                );
                if (0 == $row->zinssatzN) {
                    $row->zinssatzN = null;
                }
                $row->start = $this->_helper->normalizeDate($row->start);

                $row->save();

                $this->_redirector->gotoSimple(
                    'detail',
                    'products',
                    'kredit-admin',
                    array(
                        'product' => $product
                    )
                );
                return;
            }
        } else {
            //Werte lokalisieren
            $row->zinssatz = $this->_helper->localizeNumber($row->zinssatz);
            $row->zinssatzunten = $this->_helper->localizeNumber(
                $row->zinssatzunten
            );
            $row->zinssatzoben = $this->_helper->localizeNumber(
                $row->zinssatzoben
            );
            $row->zinssatz23 = $this->_helper->localizeNumber(
                $row->zinssatz23
            );
            $row->zinssatzR = $this->_helper->localizeNumber(
                $row->zinssatzR
            );
            $row->zinssatzN = $this->_helper->localizeNumber(
                $row->zinssatzN
            );

            if (!$row->start) {
                $row->start = \Zend\Date\Date::now();
            }

            $row->start = $this->_helper->localizeDate($row->start);

            $form->populate($row->toArray());
        }

        $this->view->form = $form;
        $this->view->headTitle('Zinssatz bearbeiten', 'PREPEND');
    }

    /**
     * Action zum Löschen eines Zinssatzes
     *
     * @return void
     */
    public function deleteAction()
    {
        if (!$this->_request->isGet() && !$this->_request->isPost()) {
            $this->_helper->header->setErrorHeaders();

            return;
        }

        $product = (int) $this->_getParam('product', 0, 'Int');
        $zins    = (int) $this->_getParam('zins', 0, 'Int');

        if (!$product || !$zins) {
            $this->_redirector->gotoSimple(
                'index',
                'products',
                'kredit-admin'
            );
            return;
        }

        $model = new \AppCore\Model\Zins();
        $row   = $this->getEditedRow($model, $zins);
        $row->delete();

        $this->_redirector->gotoSimple(
            'detail',
            'products',
            'kredit-admin',
            array(
                'product' => $product
            )
        );
    }

    /**
     * @return Zend_Form
     */
    private function _getForm()
    {
        // Form laden
        $front     = \Zend\Controller\Front::getInstance();
        $basePath  = $front->getModuleDirectory('kredit-admin');

        $config = new \Zend\Config\Ini(
            $basePath . '/configs/forms/zins.ini',
            'form'
        );
        $form = new Zend_Form($config);

        if (isset($this->_requestData['zins'])
            && (int) $this->_requestData['zins'] > 0
        ) {
            $action = $form->getAction() .  'zins/'
                    . (int) $this->_requestData['zins'] . '/';

            $form->setAction($action);
        }

        return $form;
    }
}