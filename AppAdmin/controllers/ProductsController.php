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
class KreditAdmin_ProductsController extends KreditCore_Controller_AdminAbstract
{
    /**
     * indexAction-Methode wird aufgerufen wenn keine Action angegeben wurde
     *
     * @return void
     */
    public function indexAction()
    {
        $portal     = (int) $this->_getParam('portal', 0, 'Int');
        $campaign   = (int) $this->_getParam('campaign', 0, 'Int');
        $sparte     = (int) $this->_getParam('sparte', 0, 'Int');
        $institutId = (int) $this->_getParam('institut', 0, 'Int');

        $modelApplications = new \AppCore\Model\Products();

        $pageNumber = $this->_getParam('page', 1, 'Int');

        $select = $modelApplications->select();

        if (null !== $select) {
            if ($portal) {
                $select->where(
                    ' idProducts IN (SELECT u.idProducts
                    FROM urls AS u WHERE u.p_id = ? )',
                    $portal
                );
            }
            if ($campaign) {
                $select->where(
                    ' idProducts IN (SELECT u.idProducts
                    FROM urls AS u WHERE u.idCampaigns = ? )',
                    $campaign
                );
            }
            if ($sparte) {
                $select->where(
                    ' idProducts IN (SELECT pc.idProducts
                    FROM productComponents AS pc WHERE pc.idCategories = ? )',
                    $sparte
                );
            }
            if ($institutId) {
                $select->where(' idInstitutes = ? ', $institutId);
            }
            $paginatorAdapter = new Zend_Paginator_Adapter_DbSelect(
                $select->order(array('idInstitutes', 'kp_desc'))
            );

            $this->createPagination(
                $paginatorAdapter, $pageNumber, 'getValidPaginationProducts'
            );
        }

        $this->view->newUrl = $this->view->basedUrl(
            array(
                'module' => 'kredit-admin',
                'controller' => 'products',
                'action' => 'edit',
                'product' => 0,
                'portal' => $portal,
                'sparte' => $sparte,
                'institut' => $institutId
            )
        );
        $this->view->editUrl = $this->view->basedUrl(
            array(
                'module' => 'kredit-admin',
                'controller' => 'products',
                'action' => 'edit',
                'product' => '###product###',
                'portal' => $portal,
                'sparte' => $sparte,
                'institut' => $institutId
            )
        );
        $this->view->headTitle('Products', 'PREPEND');
    }

    /**
     * erstellt eine Liste mit Werten zur Anzeige und filtert diese
     *
     * @param array $applications the paginator
     *
     * @return void
     * @access protected
     */
    protected function getValidPaginationProducts(
        array $applications = array())
    {
        $validApplications = array();

        foreach ($applications as $key => $row) {
            $validApplications[$key] = $row;

            //Get Content
            $validApplications[$key]->Content = array();

            $institutModel = new \AppCore\Model\Institute();

            $institut = $institutModel->find($validApplications[$key]->idInstitutes)
                ->current();

            if (is_object($institut)) {
                $validApplications[$key]->active = $institut->active;
                $validApplications[$key]->institut  = $institut->name;
            } else {
                $validApplications[$key]->active = false;
                $validApplications[$key]->institut  = '';
            }

            $categoriesModel = new \AppCore\Model\Sparten();
            $sparte       = $categoriesModel->find($validApplications[$key]->idCategories)
                ->current();
            $validApplications[$key]->s_active = $sparte->active;
            $validApplications[$key]->sparte   = $sparte->name;
        }

        return $validApplications;
    }

    /**
     * Action zur Bearbeitung eines Productss
     *
     * @return void
     */
    public function editAction()
    {
        $product = 0;

        if (isset($this->_requestData['product'])) {
            $product = $this->_getParam('product', 0, 'Int');
        } elseif (isset($this->_requestData['idProducts'])) {
            $product = $this->_getParam('idProducts', 0, 'Int');
        }

        $model = new \AppCore\Model\Products();
        $form  = $this->_getForm();
        $row   = $this->getEditedRow($model, $product);

        if ($this->getRequest()->isPost()
            && false !== $this->getRequest()->getParam('submit', false)
        ) {
            $params              = $this->getRequest()->getParams();
            $params['usages'] = implode(',', $params['usages']);

            if ($form->isValid($params)) {
                $params = $form->getValues();

                if ($product > 0) {
                    $row->setFromArray($params);
                } else {
                    unset($params['idProducts']);
                    $row = $model->createRow($params);
                }

                $row->save();

                $portal     = $this->_getParam('portal', 0, 'Int');
                $sparte     = $this->_getParam('sparte', 0, 'Int');
                $institutId = $this->_getParam('institut', 0, 'Int');

                $action = array();

                if ($portal) {
                    $action['portal'] =  (int) $portal;
                }

                if ($sparte) {
                    $action['sparte'] = (int) $sparte;
                }

                if ($institutId) {
                    $action['institut'] = (int) $institutId;
                }

                $this->_redirector->gotoSimple(
                    'index',
                    'products',
                    'kredit-admin',
                    $action
                );
                return;
            }
        } else {
            $sparte     = $this->_getParam('sparte', 0, 'Int');
            $institutId = $this->_getParam('institut', 0, 'Int');

            if ($sparte) {
                $row->idCategories = $sparte;
            }
            if ($institutId) {
                $row->idInstitutes = $institutId;
            }

            $row->usages = explode(',', $row->usages);

            $form->populate($row->toArray());
        }

        $this->view->form = $form;

        $this->view->headTitle('Produkt bearbeiten', 'PREPEND');
    }

    /**
     * Action zum Aktivieren/Deaktivieren eines Productss
     *
     * @return void
     */
    public function activateAction()
    {
        if (!$this->_request->isGet() && !$this->_request->isPost()) {
            $this->_helper->header->setNotFoundHeaders();

            return;
        }

        $product = $this->_getParam('product', 0, 'Int');

        if (0 < $product) {
            $active  = (int) ((boolean) $this->_getParam('aktiv', 1, 'Int'));
            $active  = 1 - $active;

            $model = new \AppCore\Model\Products();
            $model->update(
                array('active' => $active), 'idProducts = ' . $product
            );
        }

        $this->_redirector->gotoSimple(
            'index',
            'products',
            'kredit-admin'
        );
    }

    /**
     * Action zur Anzeige der Details zu einem Products
     *
     * @return void
     */
    public function detailAction()
    {
        if (!$this->_request->isGet() && !$this->_request->isPost()) {
            $this->_helper->header->setNotFoundHeaders();

            return;
        }

        $product = $this->_getParam('product', 0, 'Int');

        if (!$product) {
            $this->_redirector->gotoSimple(
                'index',
                'products',
                'kredit-admin'
            );
            return;
        }

        //URLs
        $sql = 'SELECT u.*, p.name AS portal
                FROM (urls AS u JOIN partnerSites AS p ON (u.p_id=p.idPartnerSites))
                WHERE u.idProducts = :id ORDER BY p.name';

        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':id', $product, \PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_OBJ);

        $this->view->allUrls = $rows;

        $sql  = 'SELECT COUNT(*) AS count FROM partnerSites';
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_OBJ);

        $this->view->maxUrls = $rows[0]->count;

        //Zinss�tze
        $sql = 'SELECT z.* FROM zins AS z WHERE z.idProducts = :id
                ORDER BY z.start DESC, z.betrag, z.laufzeit';

        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':id', $product, \PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_OBJ);

        $this->view->allZins = $rows;
        $this->view->product = $product;
        $this->view->paid = 'standard';
        $this->view->caid = 'standard';
    }

    /**
     * @return Zend_Form
     */
    private function _getForm()
    {
        $front     = \Zend\Controller\Front::getInstance();
        $basePath  = $front->getModuleDirectory('kredit-admin');

        // Form laden
        $config = new \Zend\Config\Ini(
            $basePath . '/configs/forms/product.ini',
            'form'
        );
        $form   = new Zend_Form($config);
        $action = $form->getAction();

        if (isset($this->_requestData['portal'])
            && (int) $this->_requestData['portal'] > 0
        ) {
            $action .= 'portal/' . (int) $this->_requestData['portal'] . '/';
        }

        if (isset($this->_requestData['sparte'])
            && (int) $this->_requestData['sparte'] > 0
        ) {
            $action .= 'sparte/' . (int) $this->_requestData['sparte'] . '/';
        }

        if (isset($this->_requestData['institut'])
            && (int) $this->_requestData['institut'] > 0
        ) {
            $action .= 'institut/'
                    . (int) $this->_requestData['institut'] . '/';
        }

        $form->setAction($action);

        $instituteModel = new \AppCore\Model\Institute();
        $oInstitute     = $instituteModel->fetchAll($instituteModel->getList());
        $institute      = array(0 => 'bitte w�hlen');

        foreach ($oInstitute as $actualInstitute) {
            $institute[$actualInstitute->idInstitutes] = $actualInstitute->name
            . ' (' . $actualInstitute->codename . ')';
        }

        $idInstitute = $form->getElement('idInstitutes');
        $idInstitute->setMultiOptions($institute);

        $usageModel = new \AppCore\Model\Usage();
        /*
        $oInstitute     = $usageModel->fetchAll($instituteModel->getList());
        $institute      = array(0 => 'bitte w�hlen');

        foreach ($oInstitute as $actualInstitute) {
            $institute[$actualInstitute->idInstitutes] = $actualInstitute->name
            . ' (' . $actualInstitute->codename . ')';
        }
        */

        $idUsage = $form->getElement('usages');
        $idUsage->setMultiOptions($usageModel->getList());

        /*
        // Liste aller Kampagnen erstellen
        $campaignModel = new \AppCore\Model\Campaigns();

        $select     = $campaignModel->select();
        $oCampaigns = $campaignModel->fetchAll();
        $campaigns  = array(0 => 'bitte w�hlen');

        foreach ($oCampaigns as $actualCampaign) {
            $campaigns[$actualCampaign->idCampaigns] = $actualCampaign->name;
        }

        // Kampagnen
        $idCampaignMain = $form->getElement('idCampaigns');
        $idCampaignMain->setMultiOptions($campaigns);
        */

        return $form;
    }
}