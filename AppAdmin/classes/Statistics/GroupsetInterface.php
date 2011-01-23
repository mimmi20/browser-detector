<?php
/**
 * the interface for all groupsets
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: GroupsetInterface.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * the interface for all groupsets
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
interface KreditAdmin_Class_Statistics_GroupsetInterface
{
    /**
     * Get DB Expression for the Group Statement
     *
     * @return \Zend\Db\Expr
     */
    public function getGroupExpression();

    /**
     * Get Db Expression for the Select Statement
     *
     * @return \Zend\Db\Expr
     */
    public function getTimespanExpression();

    /**
     * Compare if dateStart is Earlier as dateEnd
     *
     * @param \Zend\Date\Date $dateStart the start date
     * @param \Zend\Date\Date $dateEnd   the end date
     *
     * @return Boolean
     */
    public function compareFilterDates(
        \Zend\Date\Date $dateStart, \Zend\Date\Date $dateEnd);

    /**
     * Sanitize Filter Dates user Input
     *
     * @param \Zend\Date\Date &$dateStart the start date
     * @param \Zend\Date\Date &$dateEnd   the end date
     *
     * @return void
     */
    public function sanitizeFilterDates(
        \Zend\Date\Date &$dateStart, \Zend\Date\Date &$dateEnd);

    /**
     * Add a Step to a Date
     *
     * @param \Zend\Date\Date $date the date to add to
     *
     * @return \Zend\Date\Date
     */
    public function addDateStep(\Zend\Date\Date $date);

    /**
     * Get Display Format for Date
     *
     * @return String
     */
    public function getDateCompareFormat();

    /**
     * converts the date into a timestamp
     *
     * @param string $date the date (as string) to convert
     *
     * @return integer the timestamp
     */
    public function toTimestamp($date);

    /**
     * converts the given date into another date
     *
     * @param string $date the date (ISO format) to convert
     *
     * @return string
     */
    public function toDate($date);

    /**
     * converts the given date into another date
     *
     * the output format is the same as the input format and depends on
     * {@link getDateCompareFormat()}
     *
     * this function is an workaround for the week groupset for the case that
     * the database returns a week number '00'
     *
     * @param string $date the date (ISO format) to convert
     *
     * @return string
     */
    public function toCompare($date);

    /**
     * get the end date in the ISO format
     *
     * @param \Zend\Date\Date $date the date to convert
     *
     * @return string
     */
    public function getDateEndIso(\Zend\Date\Date $date);
}