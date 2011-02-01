<?php
/**
 * Klasse zum Gruppieren der Statistik nach Tagen
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * Klasse zum Gruppieren der Statistik nach Tagen
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @abstract
 */
class KreditAdmin_Class_Statistics_Groupset_Day
    implements KreditAdmin_Class_Statistics_GroupsetInterface
{
    /**
     * Get DB Expression for the Group Statement
     *
     * @return \Zend\Db\Expr
     */
    public function getGroupExpression($tableAlias = 'se')
    {
        if (!is_string($tableAlias)
            || !in_array($tableAlias, array('la', 'se'))
        ) {
            $tableAlias = 'se';
        }

        if ('se' == $tableAlias) {
            $field = '`' . $tableAlias . '`.`datum`';
        } else {
            $field = '`' . $tableAlias . '`.`zeit`';
        }

        return new \Zend\Db\Expr(
            'DATE_FORMAT(' . $field . ", '%Y%m%d')"
        );
    }

    /**
     * Get Db Expression for the Select Statement
     *
     * @return \Zend\Db\Expr
     */
    public function getTimespanExpression($tableAlias = 'se')
    {
        if (!is_string($tableAlias)
            || !in_array($tableAlias, array('la', 'se'))
        ) {
            $tableAlias = 'se';
        }

        if ('se' == $tableAlias) {
            $field = '`' . $tableAlias . '`.`datum`';
        } else {
            $field = '`' . $tableAlias . '`.`zeit`';
        }

        return new \Zend\Db\Expr(
            'DATE_FORMAT(' . $field . ", '%Y-%m-%d') as `timespan`"
        );
    }

    /**
     * Compare if dateStart is Earlier as dateEnd
     *
     * @param \Zend\Date\Date $dateStart the start date
     * @param \Zend\Date\Date $dateEnd   the end date
     *
     * @return Boolean
     */
    public function compareFilterDates(\Zend\Date\Date $dateStart, \Zend\Date\Date $dateEnd)
    {
        return ($dateStart->isEarlier($dateEnd, \Zend\Date\Date::TIMESTAMP) ||
                $dateStart->equals($dateEnd, \Zend\Date\Date::TIMESTAMP));
    }

    /**
     * Sanitize Filter Dates user Input
     *
     * @param \Zend\Date\Date &$dateStart the start date
     * @param \Zend\Date\Date &$dateEnd   the end date
     *
     * @return void
     */
    public function sanitizeFilterDates(
        \Zend\Date\Date &$dateStart, \Zend\Date\Date &$dateEnd)
    {
        $rangeDate = new \Zend\Date\Date();

        if ($dateEnd->isLater($rangeDate)) {
            $dateEnd = clone($rangeDate);
        }
    }

    /**
     * Add a Step to a Date
     *
     * @param \Zend\Date\Date $date the date to add to
     *
     * @return \Zend\Date\Date
     */
    public function addDateStep(\Zend\Date\Date $date)
    {
        return $date->addDay(1);
    }

    /**
     * Get Display Format for Date
     *
     * @return String
     */
    public function getDateCompareFormat()
    {
        return 'yyyy-MM-dd';
    }

    /**
     * converts the date into a timestamp
     *
     * @param string $date the date (as string) to convert
     *
     * @return integer the timestamp
     */
    public function toTimestamp($date)
    {
        return (strtotime($date) * 1000);
    }

    /**
     * converts the given date into another date (depending on groupset)
     *
     * @param string $date the date (ISO format) to convert
     *
     * @return string
     */
    public function toDate($date)
    {
        return $date;
    }

    /**
     * converts the given date into another date
     *
     * the output format is the same as the input format and depends on
     * {@link getDateCompareFormat()}
     *
     * this function is an workaround for the week groupset for the case that
     * the database returns a week number "00"
     *
     * @param string $date the date (ISO format) to convert
     *
     * @return string
     */
    public function toCompare($date)
    {
        return $date;
    }

    /**
     * get the end date in the ISO format
     *
     * @param \Zend\Date\Date $date the date to convert
     *
     * @return string
     */
    public function getDateEndIso(\Zend\Date\Date $date)
    {
        $dateIntern = $this->addDateStep($date);
        return $dateIntern->toString('yyyy-MM-dd 00:00:00');
    }
}