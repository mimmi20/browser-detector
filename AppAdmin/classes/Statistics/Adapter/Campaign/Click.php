<?php
/**
 * Klasse zum Erstellen der Statistik
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
 * Klasse zum Erstellen der Statistik
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_Class_Statistics_Adapter_Campaign_Click
    extends KreditAdmin_Class_Statistics_Adapter_CampaignAbstract
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
        $expression = 'IFNULL(SUM(`se`.`anzahl`), 0) as `count`';

        return parent::calculateCampaign(
            $expression,
            $sparte,
            $type,
            $campaigns
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
        $expression = '';
        $format     = false;
        $summeAnz   = true;
        $grafisch   = true;

        return parent::createTable(
            $result,
            $format,
            $summeAnz,
            $grafisch,
            $expression
        );
    }
}