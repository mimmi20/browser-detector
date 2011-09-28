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
            $this->broker('header')->setErrorHeaders();

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

        if (isset($this->_requestData['url'])) {
            $urlId = (int) $this->_getParam('url', 0, 'Int');
        } elseif (isset($this->_requestData['idUrls'])) {
            $urlId = (int) $this->_getParam('idUrls', 0, 'Int');
        } else {
            $urlId = 0;
        }

        $model = new \App\Model\Url();
        $form = $this->_getForm();

        $row = $this->getEditedRow($model, $urlId);
        $row['idProducts'] = $product;

        if ($this->getRequest()->isPost()
            && false !== $this->getRequest()->getParam('submit', false)
        ) {
            if ($form->isValid($this->getRequest()->getParams())) {
                if ($urlId > 0) {
                    $row->setFromArray($form->getValues());
                } else {
                    $values = $form->getValues();
                    unset($values['idUrls']);
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
            $this->broker('header')->setErrorHeaders();

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

        $sql = 'UPDATE urls SET teaser = :aktiv WHERE idUrls = :id';

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
            $this->broker('header')->setErrorHeaders();

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

        $sql = 'UPDATE urls SET internal = :aktiv WHERE idUrls= :id';

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
            $this->broker('header')->setErrorHeaders();

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
            $data = new \App\Model\Core_Url();
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
        $campaignModel = new \App\Model\Campaigns();

        $oCampaigns = $campaignModel->fetchAll();
        $campaigns  = array(0 => 'bitte wählen');

        foreach ($oCampaigns as $actualCampaign) {
            $campaigns[$actualCampaign->idCampaigns] = $actualCampaign->name;
        }

        // Kampagnen
        $idCampaignMain = $form->getElement('idCampaigns');
        $idCampaignMain->setMultiOptions($campaigns);

        return $form;
    }
}