<?php
/**
 * Controller-Klasse, zur Verwaltung der Partner-Portale und Kampagnen
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
 * Controller-Klasse, zur Verwaltung der Partner-Portale und Kampagnen
 *
 * @category  CreditCalc
 * @package   Controller
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_MandantController extends KreditCore_Controller_AdminAbstract
{
    /**
     * (non-PHPdoc)
     *
     * @see    library/Zend/Controller/Zend_Controller_Action#preDispatch()
     * @return void
     * @access public
     */
    public function preDispatch()
    {
        parent::preDispatch();

        if (!$this->_request->isGet() && !$this->_request->isPost()) {
            $this->broker('header')->setErrorHeaders();

            return;
        }
    }

    /**
     * show all partners
     *
     * @return void
     */
    public function partnerAction()
    {
        $dbPartner  = new \App\Model\PartnerSites();
        $parentList = $dbPartner->fetchList();

        //array mit allen Partnern
        $aPa = array();

        if (false !== $parentList) {
            foreach ($parentList as $oPartner) {
                $pid = $oPartner->p_id;

                $aPa[$pid] = $oPartner->toArray();
                $aPa[$pid]['childs'] = array();
                $aPa[$pid]['css']    = false;
                $aPa[$pid]['pic']    = 'nok';
                $aPa[$pid]['color']  = '';

                $cssPfad = APPLICATION_PATH . DS . '_campaigns' . DS .
                           $aPa[$pid]['name'] . '.css';
                if (file_exists($cssPfad)) {
                    $aPa[$pid]['css'] = true;
                }

                if ($aPa[$pid]['active']) {
                    $aPa[$pid]['pic'] = 'ok';
                }

                $campaignList = $dbPartner->getChildList($oPartner);

                foreach ($campaignList as $oCampaign) {
                    $cid = $oCampaign->idCampaigns;

                    $aPa[$pid]['childs'][$cid] = $oCampaign->toArray();
                    $aPa[$pid]['childs'][$cid]['css']    = false;
                    $aPa[$pid]['childs'][$cid]['pic']    = 'nok';
                    $aPa[$pid]['childs'][$cid]['status'] = 'nicht aktiv';
                    $aPa[$pid]['childs'][$cid]['color']  = $oCampaign->color;

                    $cssPfad = APPLICATION_PATH . DS
                             . '_campaigns' . DS
                             . $aPa[$pid]['childs'][$cid]['name']
                             . '.css';
                    if (file_exists($cssPfad)) {
                        $aPa[$pid]['childs'][$cid]['css'] = true;
                    }

                    if (!$aPa[$pid]['active']) {
                        $aPa[$pid]['childs'][$cid]['pic'] = 'lock';
                        $aPa[$pid]['childs'][$cid]['status'] = 'gesperrt';
                    } elseif ($aPa[$pid]['childs'][$cid]['active']) {
                        $aPa[$pid]['childs'][$cid]['pic'] = 'ok';
                        $aPa[$pid]['childs'][$cid]['status'] = 'aktiv';
                    }
                }
            }
        }

        $this->view->partner = $aPa;
        $this->view->headTitle('Partner', 'PREPEND');
    }

    /**
     * edit a portal
     *
     * @return void
     */
    public function editportalAction()
    {
        $portal = 0;

        if (isset($this->_requestData['portal'])) {
            $portal = $this->_getParam('portal', 0, 'Int');
        } elseif (isset($this->_requestData['p_id'])) {
            $portal = $this->_getParam('p_id', 0, 'Int');
        }

        $model = new \App\Model\PartnerSites();
        $form  = $this->_getPortaleForm();
        $row   = $this->getEditedRow($model, $portal);

        $this->_getForm($form, $model, $row, $portal, 'p_id');

        $this->view->headTitle('Partner bearbeiten', 'PREPEND');
    }

    /**
     * activate a portal
     *
     * @return void
     */
    public function activateportalAction()
    {
        if (!$this->_request->isGet() && !$this->_request->isPost()) {
            $this->broker('header')->setErrorHeaders();

            return;
        }

        $portal = $this->_getParam('portal', 0, 'Int');

        if (0 < $portal) {
            $active = (int) ((boolean) $this->_getParam('aktiv', 1, 'Int'));
            $active = 1 - $active;

            $model = new \App\Model\PartnerSites();
            $model->update(array('active' => $active), 'p_id = ' . $portal);
        }

        $this->_redirector->gotoSimple(
            'partner',
            'mandant',
            'kredit-admin'
        );
    }

    /**
     * edit a campaign
     *
     * @return void
     */
    public function editcampaignAction()
    {
        $campaign = 0;
        $portal   = 0;

        if (isset($this->_requestData['campaign'])) {
            $campaign = $this->_getParam('campaign', 0, 'Int');
        } elseif (isset($this->_requestData['idCampaigns'])) {
            $campaign = $this->_getParam('idCampaigns', 0, 'Int');
        }

        if (isset($this->_requestData['portal'])) {
            $portal = $this->_getParam('portal', 0, 'Int');
        } elseif (isset($this->_requestData['p_id'])) {
            $portal = $this->_getParam('p_id', 0, 'Int');
        }

        $model = new \App\Model\Campaigns();
        $form  = $this->_getCampaignForm();

        if ($campaign > 0) {
            $row = $model->find($campaign)->current();
        } else {
            $row = $model->createRow();
            $row->p_id = $portal;
        }

        $this->_getForm($form, $model, $row, $campaign, 'idCampaigns');

        $this->view->headTitle('Kampagne bearbeiten', 'PREPEND');
    }

    /**
     * activate a campaign
     *
     * @return void
     */
    public function activatecampaignAction()
    {
        if (!$this->_request->isGet() && !$this->_request->isPost()) {
            $this->broker('header')->setErrorHeaders();

            return;
        }

        $campaign = $this->_getParam('campaign', 0, 'Int');

        if (0 < $campaign) {
            $active   = (int) ((boolean) $this->_getParam('aktiv', 0, 'Int'));
            $active   = 1 - $active;

            $model = new \App\Model\Campaigns();
            $model->update(
                array('active' => $active), 'idCampaigns = ' . $campaign
            );
        }

        $this->_redirector->gotoSimple(
            'partner',
            'mandant',
            'kredit-admin'
        );
    }

    /**
     * validates the form data
     *
     * @param Zend_Form                         $form
     * @param \\AppCore\\Model\ModelAbstract $model
     * @param mixed                             $row
     * @param mixed                             $field
     * @param mixed                             $deleteField
     *
     * @return void
     */
    private function _getForm(
        Zend_Form $form, \\AppCore\\Model\ModelAbstract $model, $row, $field,
        $deleteField)
    {
        if ($this->getRequest()->isPost()
            && false !== $this->getRequest()->getParam('submit', false)
        ) {
            if ($form->isValid($this->getRequest()->getParams())) {
                if ($field > 0) {
                    $row->setFromArray($form->getValues());
                } else {
                    $values = $form->getValues();
                    unset($values[$deleteField]);
                    $row = $model->createRow($values);
                }

                $row->save();

                $this->_redirector->gotoSimple(
                    'partner',
                    'mandant',
                    'kredit-admin'
                );
                return;
            }
        } else {
            $form->populate($row->toArray());
        }

        $this->view->form = $form;
    }

    /**
     * @return Zend_Form
     */
    private function _getPortaleForm()
    {
        $front     = \Zend\Controller\Front::getInstance();
        $basePath  = $front->getModuleDirectory('kredit-admin');
        $config    = new \Zend\Config\Ini($basePath .
            '/configs/forms/portal.ini', 'form');
        return new Zend_Form($config);
    }

    /**
     * @return Zend_Form
     */
    private function _getCampaignForm()
    {
        // Liste aller Kampagnen erstellen
        $campaignModel = new \App\Model\Campaigns();

        $oCampaigns = $campaignModel->fetchAll();
        $campaigns  = array(0 => 'bitte wählen');

        foreach ($oCampaigns as $actualCampaign) {
            $campaigns[$actualCampaign->idCampaigns] = $actualCampaign->name;
        }

        // Form laden
        $front     = \Zend\Controller\Front::getInstance();
        $basePath  = $front->getModuleDirectory('kredit-admin');
        $config    = new \Zend\Config\Ini($basePath .
            '/configs/forms/campaign.ini', 'form');
        $form   = new Zend_Form($config);

        // Kampagnen
        $idCampaignMain = $form->getElement('idCampaignMain');
        $idCampaignMain->setMultiOptions($campaigns);

        $idCampaignTest = $form->getElement('idCampaignTest');
        $idCampaignTest->setMultiOptions($campaigns);

        return $form;
    }
}