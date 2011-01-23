<?php
/**
 * Klasse mit Backend-Funktionen für Events
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Event.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Klasse mit Backend-Funktionen für Events
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_Class_Statistics_Event
{
    /**
     * @var \Credit\Core\Model\Event
     */
    private $_dbEvent;

    /**
     * @var \Credit\Core\Model\EventType
     */
    private $_dbEventType;

    /**
     * @var KreditAdmin_Class_Statistics_Filter
     */
    protected $_filter;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->_dbEvent     = new \Credit\Core\Model\Event();
        $this->_dbEventType = new \Credit\Core\Model\EventType();
    }

    /**
     * Get Complete List of Events
     *
     * @return \Zend\Db\Table\Rowset
     */
    public function getEventList()
    {
        $start = null;
        $end   = null;

        if ($this->_filter instanceof KreditAdmin_Class_Statistics_Filter) {
            $start = $this->_filter->getDateStartIso() . ':00:00';
            $end   = $this->_filter->getDateEndIso() . ':00:00';
        }

        return $this->_dbEvent->fetchList($start, $end);
    }

    /**
     * Get List as JSON
     *
     * @return String
     */
    public function getEncodedList()
    {
        $rows   = $this->getEventList();
        $result = array();

        if (false !== $rows) {
            while ($rows->valid()) {
                $current = $rows->current();
                $date    = new \Zend\Date\Date($current->InsertAt);
                $eId     = $current->EventId;
                $result[$eId][0] = $date->toString(\Zend\Date\Date::TIMESTAMP)*1000;
                $result[$eId][1] = $current->Color;
                $result[$eId][2] = $current->Icon;
                $item = (
                    mb_detect_encoding(
                        $current->Desc . ' ',
                        'UTF-8,ISO-8859-1'
                    ) == 'ISO-8859-1' ? utf8_encode($current->Desc)
                                      : $current->Desc
                );
                $result[$eId][3] = $item;
                $result[$eId][4] = $current->EventTypeId;
                $rows->next();
            }
        }

        return Zend_Json::encode($result);
    }

    /**
     * Get Filter Object
     *
     * @return KreditAdmin_Class_Statistics_Filter
     */
    public function getFilter()
    {
        if (null === $this->_filter) {
            $filter = new KreditAdmin_Class_Statistics_Filter();

            $this->setFilter($filter);
        }

        return $this->_filter;
    }

    /**
     * Set Filter Object
     *
     * @param KreditAdmin_Class_Statistics_Filter $filter a new filter
     *
     * @return KreditAdmin_Class_StatisticsAbstract
     */
    public function setFilter(KreditAdmin_Class_Statistics_Filter $filter)
    {
        $this->_filter = $filter;

        return $this;
    }
}