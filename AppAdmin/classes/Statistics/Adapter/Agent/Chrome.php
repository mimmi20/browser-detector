<?php
/**
 * Klasse zum Erstellen der Statistik für den Browser Chrome
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Chrome.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Klasse zum Erstellen der Statistik für den Browser Chrome
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_Class_Statistics_Adapter_Agent_Chrome
    extends KreditAdmin_Class_Statistics_Adapter_Agent_BrowserAbstract
{
    /**
     * calculates the summary for user agents for statistics
     *
     * @param string  $sparte    the name for the sparte
     * @param string  $type      the type of logging
     * @param integer $summary   the kind of information
     * @param string  $campaigns a comma separated list of campaign ids
     * @param string  $where     a where condition
     *
     * @return array
     */
    public function calculate(
        $sparte = 'Kredit',
        $type = 'click',
        $summary = 0,
        $campaigns = '',
        $where = ''
    )
    {
        $where = "(`b`.`Browser` like 'Chrome%')";

        return parent::calculate($sparte, $type, $summary, $campaigns, $where);
    }
}