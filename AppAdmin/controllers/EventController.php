<?php
/**
 * Controller-Klasse, zur Verwaltung von Ereignissen
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
 * Controller-Klasse, zur Verwaltung von Ereignissen
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_EventController extends KreditCore_Controller_AdminAbstract
{
    /**
     * Index Action
     * Display List of Events
     *
     * @return void
     */
    public function indexAction()
    {
        $event = new KreditAdmin_Class_Statistics_Event();
        $list  = $event->getEventList();

        if (false === $list) {
            $this->view->events = array();
        } else {
            $this->view->events = $list->toArray();
        }

        $this->view->headTitle('Events', 'PREPEND');
    }

    /**
     * Add new Event Form
     *
     * @return void
     */
    public function addAction()
    {
        $form = $this->_getForm();

        if ($this->getRequest()->isPost()
            && false !== $this->getRequest()->getParam('submit', false)
        ) {
            $form->populate($this->_request->getParams());

            if ($form->isValid($this->_request->getParams())) {
                $model = new \App\Model\Event();
                $row   = $model->createRow($form->getValues());
                $row->save();

                $this->_redirector->gotoSimple(
                    'index',
                    'event',
                    'kredit-admin'
                );
                return;
            }
        }

        $this->view->form = $form;

        $this->view->headTitle('neues Event', 'PREPEND');

    }

    /**
     * @return Zend_Form
     */
    private function _getForm()
    {
        // Liste aller Laufzeiten erstellen
        $dbEventType = new \App\Model\EventType();
        $events      = array();
        $select      = $dbEventType->select();

        if (null !== $select) {
            $select->where('EventTypeId <> ?', 7); // no Triggers

            $rows = $dbEventType->fetchAll($select);

            while ($rows->valid()) {
                $row = $rows->current();

                $events[$row->EventTypeId] = $row->Name;
                $rows->next();
            }
        }

        // Form laden
        $front     = \Zend\Controller\Front::getInstance();
        $basePath  = $front->getModuleDirectory('kredit-admin');

        $config = new \Zend\Config\Ini(
            $basePath . '/configs/forms/event.ini',
            'form'
        );
        $form = new Zend_Form($config);

        // Kampagnen
        $type = $form->getElement('EventTypeId');
        $type->setMultiOptions($events);

        return $form;
    }
}