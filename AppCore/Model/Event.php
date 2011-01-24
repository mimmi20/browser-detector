<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Model;

/**
 * Model
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Event.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Model
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Event extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'event';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'EventId';

    /**
     * ??
     * @var array
     */
    protected $_referenceMap = array(
       'EventType'  => array(
           'columns'           =>  array('EventTypeId'),
           'refTableClass'     =>  '\\AppCore\\Model\EventType',
           'refColumns'        =>  array('EventTypeId')
       )
    );

    /**
     * Fetch complete List with Type, ordered by Insert Date
     *
     * @param mixed $start the start-date
     * @param mixed $end   the end-date
     *
     * @return \Zend\Db\Table\Rowset
     * @access public
     */
    public function fetchList($start = null, $end = null)
    {
        $select = $this->select()
            ->setIntegrityCheck(false)
            ->from(array('e' => $this->_name), '*')
            ->join(array('et' => 'eventtype'), 'e.EventTypeId = et.EventTypeId')
            ->order('e.InsertAt DESC');

        if ($start !== null
            && \Zend\Date\Date::isDate($start, 'yyyy-MM-dd HH:mm:ss')
        ) {
            $select->where('e.InsertAt >= ?', $start);
        }
        if ($end !== null && \Zend\Date\Date::isDate($end, 'yyyy-MM-dd HH:mm:ss')) {
            $select->where('e.InsertAt <= ?', $end);
        }

        return $this->fetchAll($select);
    }
}