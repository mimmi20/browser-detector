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
 * @version   SVN: $Id: UrlController.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Controller-Klasse, die das Backend steuert
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_UrlController extends KreditCore_Controller_AdminAbstract
{
    /**
     * Action zur Bearbeitung einer Url
     *
     * @return void
     */
    public function editAction()
    {
        if (!$this->_request->isGet() && !$this->_request->isPost()) {
            $this->_helper->header->setNotFoundHeaders();

            return;
        }

        if (isset($this->_requestData['product'])) {
            $product = (int) $this->_getParam('product', 0, 'Int');
        } elseif (isset($this->_requestData['kp_id'])) {
            $product = (int) $this->_getParam('kp_id', 0, 'Int');
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

        if (isset($this->_requestData['url'])) {
            $urlId = (int) $this->_getParam('url', 0, 'Int');
        } elseif (isset($this->_requestData['tku_id'])) {
            $urlId = (int) $this->_getParam('tku_id', 0, 'Int');
        } else {
            $urlId = 0;
        }

        $model = new \AppCore\Model\Url();
        $form = $this->_getForm();

        $row = $this->getEditedRow($model, $urlId);
        $row['kp_id'] = $product;

        if ($this->getRequest()->isPost()
            && false !== $this->getRequest()->getParam('submit', false)
        ) {
            if ($form->isValid($this->getRequest()->getParams())) {
                if ($urlId > 0) {
                    $row->setFromArray($form->getValues());
                } else {
                    $values = $form->getValues();
                    unset($values['tku_id']);
                    $row = $model->createRow($values);
                }

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
            $form->populate($row->toArray());
        }

        $this->view->form = $form;
        $this->view->headTitle('URL bearbeiten', 'PREPEND');
    }

    /**
     * Action zum Setzen/Löschen der Teaser-Markierung für eine Url
     *
     * @return void
     */
    public function setteaserAction()
    {
        if (!$this->_request->isGet() && !$this->_request->isPost()) {
            $this->_helper->header->setNotFoundHeaders();

            return;
        }

        $url     = (int) $this->_getParam('url', 0, 'Int');
        $product = (int) $this->_getParam('produkt', 0, 'Int');

        if (!$url || !$product) {
            $this->_redirector->gotoSimple(
                'index',
                'products',
                'kredit-admin'
            );
            return;
        }

        $active = (int) ((boolean) $this->_getParam('teaser', 1, 'Int'));
        $active = 1 - $active;

        $sql = 'UPDATE urls SET tku_teaser = :aktiv WHERE tku_id = :id';

        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':aktiv', $active, \PDO::PARAM_INT);
        $stmt->bindParam(':id', $url, \PDO::PARAM_INT);
        $stmt->execute();

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
     * Action zum Setzen/Löschen der Internal-Markierung für eine Url
     *
     * @return void
     */
    public function setinternalAction()
    {
        if (!$this->_request->isGet() && !$this->_request->isPost()) {
            $this->_helper->header->setNotFoundHeaders();

            return;
        }

        $url     = (int) $this->_getParam('url', 0, 'Int');
        $product = (int) $this->_getParam('produkt', 0, 'Int');

        if (!$url || !$product) {
            $this->_redirector->gotoSimple(
                'index',
                'products',
                'kredit-admin'
            );
            return;
        }

        $active = (int) ((boolean) $this->_getParam('internal', 1, 'Int'));
        $active = 1 - $active;

        $sql = 'UPDATE urls SET tku_internal = :aktiv WHERE tku_id= :id';

        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':aktiv', $active, \PDO::PARAM_INT);
        $stmt->bindParam(':id', $url, \PDO::PARAM_INT);
        $stmt->execute();

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
     * Action zum Löschen einer Url
     *
     * @return void
     */
    public function deleteAction()
    {
        if (!$this->_request->isGet() && !$this->_request->isPost()) {
            $this->_helper->header->setNotFoundHeaders();

            return;
        }

        $product = (int) $this->_getParam('product', 0, 'Int');
        $url     = (int) $this->_getParam('url', 0, 'Int');

        if (!$product || !$url) {
            $this->_redirector->gotoSimple(
                'index',
                'products',
                'kredit-admin'
            );
            return;
        }

        if ($url) {
            $data = new \AppCore\Model\Core_Url();
            $data->load($url);
            $data->delete($url);
        }

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
            $basePath . '/configs/forms/url.ini',
            'form'
        );
        $form = new Zend_Form($config);

        if (isset($this->_requestData['url'])
            && (int) $this->_requestData['url'] > 0
        ) {
            $action = $form->getAction() .  'url/'
                    . (int) $this->_requestData['url'] . '/';

            $form->setAction($action);
        }

        // Liste aller Kampagnen erstellen
        $campaignModel = new \AppCore\Model\Campaigns();

        $oCampaigns = $campaignModel->fetchAll();
        $campaigns  = array(0 => 'bitte wählen');

        foreach ($oCampaigns as $actualCampaign) {
            $campaigns[$actualCampaign->id_campaign] = $actualCampaign->p_name;
        }

        // Kampagnen
        $idCampaignMain = $form->getElement('id_campaign');
        $idCampaignMain->setMultiOptions($campaigns);

        return $form;
    }
}