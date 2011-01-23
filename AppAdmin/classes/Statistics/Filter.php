<?php
/**
 * Klasse mit Backend-Funktionen zum Filtern von Daten in der Statistik
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Filter.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Klasse mit Backend-Funktionen zum Filtern von Daten in der Statistik
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_Class_Statistics_Filter
{

    const SESSION_NAMESPACE = 'KreditAdmin_Class_Statistics_Filter';

    const GROUP_VALUE_MONTH = 10;
    const GROUP_VALUE_WEEK  = 20;
    const GROUP_VALUE_DAY   = 30;
    const GROUP_VALUE_HOUR  = 40;
    const GROUP_VALUE_YEAR  = 50;

    /**
     * @var \Zend\Date\Date
     */
    private $_dateStart = null;

    /**
     * @var \Zend\Date\Date
     */
    private $_dateEnd = null;

    /**
     * @var Enum
     */
    private $_groupValue = null;

    /**
     * @var KreditAdmin_Class_Statistics_GroupsetInterface
     */
    private $_groupSet = null;

    /**
     * @var Zend_Session_Namespace
     */
    private $_session = null;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->_dateStart  = new \Zend\Date\Date();
        $this->_dateStart->setDay(1);
        $this->_dateEnd    = new \Zend\Date\Date();
        $this->_groupValue = self::GROUP_VALUE_MONTH;
        $this->_groupSet   = null;
        $this->_session    = new Zend_Session_Namespace('KREDIT');
    }

    /**
     * Set Filter Date Start
     *
     * @param string $dateString a date
     *
     * @return null|KreditAdmin_Class_Statistics_Filter
     */
    public function setDateStart($dateString)
    {
        if (!\Zend\Date\Date::isDate($dateString)) {
            return null;
        }

        $this->_dateStart->set($dateString);

        return $this->_store();
    }

    /**
     * Get Start Date as String
     *
     * @return String
     */
    public function getDateStartString()
    {
        return $this->_dateStart->toString('dd.MM.yyyy');
    }

    /**
     * Get Start Date as ISO String
     *
     * @return String
     */
    public function getDateStartIso()
    {
        return $this->_dateStart->toString('yyyy-MM-dd 00:00:00');
    }

    /**
     * Get Start Date as Object
     *
     * @return \Zend\Date\Date
     */
    public function getDateStart()
    {
        return $this->_dateStart;
    }

    /**
     * Set Filter Date End
     *
     * @param string $dateString a date
     *
     * @return null|KreditAdmin_Class_Statistics_Filter
     */
    public function setDateEnd($dateString)
    {
        if (!\Zend\Date\Date::isDate($dateString)) {
            return null;
        }

        $this->_dateEnd->set($dateString);

        return $this->_store();
    }

    /**
     * Get End Date as String
     *
     * @return String
     */
    public function getDateEndString()
    {
        return $this->_dateEnd->toString('dd.MM.yyyy');
    }

    /**
     * Get End Date as ISO String
     *
     * @return String
     */
    public function getDateEndIso()
    {
        return $this->_dateEnd->toString('yyyy-MM-dd 23:59:59');
        //return $this->getGroupSet()->getDateEndIso($this->_dateEnd);
    }

    /**
     * Get End Date as Object
     *
     * @return \Zend\Date\Date
     */
    public function getDateEnd()
    {
        return $this->_dateEnd;
    }

    /**
     * Set the GroupBy Value
     *
     * @param integer $groupValueEnum the new value
     *
     * @return KreditAdmin_Class_Statistics_Filter
     */
    public function setGroupValue($groupValueEnum)
    {
        $allowedValues = array(
            self::GROUP_VALUE_MONTH,
            self::GROUP_VALUE_WEEK,
            self::GROUP_VALUE_DAY,
            self::GROUP_VALUE_HOUR,
            self::GROUP_VALUE_YEAR
        );

        $groupValueEnum = (int) $groupValueEnum;

        if (!in_array($groupValueEnum, $allowedValues)) {
            /*
             * value is not allowed
             * -> set default
             */
            $groupValueEnum = self::GROUP_VALUE_MONTH;
        }

        $this->_groupValue = $groupValueEnum;
        $this->_processGroupSet();

        return $this->_store();
    }

    /**
     * Get the GroupBy Value
     *
     * @return Enum
     */
    public function getGroupValue()
    {
        return $this->_groupValue;
    }

    /**
     * Get GroupSet Object
     *
     * @return KreditAdmin_Class_Statistics_GroupsetInterface
     */
    public function getGroupSet()
    {
        if (null === $this->_groupSet) {
            $this->_processGroupSet();
        }

        return $this->_groupSet;
    }

    /**
     * Sanitize User input
     *
     * @return KreditAdmin_Class_Statistics_Filter
     */
    public function sanitize()
    {
        $this->getGroupSet()->sanitizeFilterDates(
            $this->_dateStart, $this->_dateEnd
        );

        return $this->_store();
    }

    /**
     * Store changed filters to Session
     *
     * @return KreditAdmin_Class_Statistics_Filter
     */
    private function _store()
    {
        $this->_session->dateStart = $this->_dateStart->toString(
            \Zend\Date\Date::ISO_8601
        );
        $this->_session->dateEnd = $this->_dateEnd->toString(
            \Zend\Date\Date::ISO_8601
        );
        $this->_session->groupValue = $this->_groupValue;

        return $this;
    }

    /**
     * Load the GroupSet Class by the given GroupValue
     *
     * @return KreditAdmin_Class_Statistics_Filter
     */
    private function _processGroupSet()
    {
        switch ($this->_groupValue) {
            case self::GROUP_VALUE_WEEK:
                $class = 'KreditAdmin_Class_Statistics_Groupset_Week';
                break;
            case self::GROUP_VALUE_DAY:
                $class = 'KreditAdmin_Class_Statistics_Groupset_Day';
                break;
            case self::GROUP_VALUE_HOUR:
                $class = 'KreditAdmin_Class_Statistics_Groupset_Hour';
                break;
            case self::GROUP_VALUE_YEAR:
                $class = 'KreditAdmin_Class_Statistics_Groupset_Year';
                break;
            default:
            case self::GROUP_VALUE_MONTH:
                $class = 'KreditAdmin_Class_Statistics_Groupset_Month';
                break;
        }

        $this->_groupSet = new $class();

        return $this;
    }
}