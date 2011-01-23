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
 * @version   SVN: $Id: SummaryAbstract.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Klasse zum Erstellen der Statistik
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @abstract
 */
abstract class KreditAdmin_Class_Statistics_Adapter_SummaryAbstract
    extends KreditAdmin_Class_StatisticsAbstract
{
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
        $percent = false,
        $format = true,
        $expression = ''
    )
    {
        $summeAnz   = false;
        $grafisch   = true;

        return parent::createTableWithPercent(
            $result, $percent, $format, $summeAnz, $grafisch, $expression
        );
    }
}