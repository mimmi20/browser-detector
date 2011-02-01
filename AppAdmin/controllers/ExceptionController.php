<?php
/**
 * Controller-Klasse, zur Verwaltung von Fehlern und Exceptions
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
 * Controller-Klasse, zur Verwaltung von Fehlern und Exceptions
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_ExceptionController
    extends KreditCore_Controller_AdminAbstract
{
    private $_paginator = null;

    private $_colors = array(
        'development' => '#f00',
        'local'       => '#37a',
        'live'        => '#0f0',
        'test'        => '#080',
        'staging'     => '#080',
        'localtest'   => '#b22',
        'localtest2'  => '#a73',
        'localtest3'  => '#a73',
        'admin'       => '#00f',
        'admintest'   => '#008'
    );

    private $_pageNumber = null;

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

        $this->loadJs();

        $this->_pageNumber = $this->_getParam('page', 1, 'Int');
        $this->view->page  = $this->_pageNumber;
    }

    /**
     * Index Action
     *
     * @return void
     */
    public function indexAction()
    {
        $this->createErrorList();

        $now          = new \Zend\Date\Date();
        $threeDaysAgo = new \Zend\Date\Date();

        $now->addDay(1);
        $now->setMinute(0);
        $now->setSecond(0);

        $threeDaysAgo->subDay(10);
        $threeDaysAgo->setMinute(0);
        $threeDaysAgo->setSecond(0);

        $min = $threeDaysAgo->toString(\Zend\Date\Date::TIMESTAMP);
        $max = $now->toString(\Zend\Date\Date::TIMESTAMP);

        $this->view->min = $min;
        $this->view->max = $max;

        $this->view->headTitle('Fehler', 'PREPEND');
    }

    /**
     * Index Action
     *
     * @return void
     */
    public function getErrorListAction()
    {
        $this->initAjax();
        $this->createErrorList();

        $content = array();

        if (is_object($this->_paginator)) {
            $items = $this->_paginator->getItemsByPage(
                $this->_paginator->getCurrentPageNumber()
            );

            foreach ($items as $i) {
                $contentElement = array();

                $contentElement['trace']      = nl2br(htmlentities($i->Trace));
                $contentElement['request']    = print_r(
                    unserialize($i->Request),
                    true
                );
                $contentElement['time']       = $i->Throw;
                $contentElement['enviroment'] = $i->Enviroment;
                $contentElement['message']    = $i->Message;
                $contentElement['level']      = $i->level;

                if (isset($this->_colors[$i->Enviroment])) {
                    $contentElement['color'] = $this->_colors[$i->Enviroment];
                } else {
                    $contentElement['color']       = '#ddd';
                    $contentElement['enviroment'] .= ' (no color)';
                }

                $content[] = $contentElement;
            }
        }

        $details = Zend_Json::encode((object) $content);
        $this->getResponse()->setBody($details);
    }

    /**
     * generiert eine Liste der letzten 200 Fehler
     *
     * @return void
     * @access protected
     */
    protected function createErrorList()
    {
        $modelException = new \AppCore\Model\Exception();
        $select         = $modelException->select();
        $select->order('Throw DESC');
        $select->limit(20, $this->_pageNumber * 20);

        $this->view->colors = $this->_colors;

        if (null !== $select) {
            $paginatorAdapter = new Zend_Paginator_Adapter_DbSelect(
                $select
            );

            $this->_paginator = new Zend_Paginator($paginatorAdapter);
            $this->_paginator->setItemCountPerPage(20);
            $this->_paginator->setCurrentPageNumber($this->_pageNumber);
        }

        $this->view->paginator  = $this->_paginator;
    }
}