<?php
/**
 * Klasse zum Erstellen der Statistik
 *
 * PHP version 5
 *
 * @category  CreditCalc
 * @package   Statistics
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * Klasse zum Erstellen der Statistik
 *
 * @category  CreditCalc
 * @package   Statistics
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_Class_Statistics_Adapter_Institute_Provision
    extends KreditAdmin_Class_Statistics_Adapter_InstituteAbstract
{
    /**
     * calculates the summary for statistics
     *
     * @param integer $sparte    the id for the sparte
     * @param string  $type      the type of logging
     * @param integer $summary   the kind of information
     * @param string  $campaigns a comma separated list of campaign ids
     *
     * @return array
     */
    public function calculate(
        $sparte = 1, $type = 'click', $summary = 0, $campaigns = '')
    {
        $expression = 'IFNULL(SUM(`se`.`pr`), 0) as `count`';

        return parent::calculateInstitute(
            $expression, $sparte, $type, $summary, $campaigns
        );
    }

    /**
     * Encode ResultSet for the View
     *
     * @param array   $result ??
     * @param integer $type   ??
     *
     * @return Json
     */
    public function createTable(
        array $result,
        $format = true,
        $summeAnz = true,
        $grafisch = false,
        $expression = ''
    )
    {
        $format     = true;
        $grafisch   = false;
        $expression = ' &euro;';
        $summeAnz   = true;

        return parent::createTable(
            $result, $format, $summeAnz, $grafisch, $expression
        );
    }
}