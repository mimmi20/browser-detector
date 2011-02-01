<?php
/**
 * Klasse zum Erstellen der Statistik für alle Browser die sonst nicht erfasst
 * sind
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
 * Klasse zum Erstellen der Statistik für alle Browser die sonst nicht erfasst
 * sind
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_Class_Statistics_Adapter_Agent_Others
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
        $where = new \Zend\Db\Expr("(`b`.`isMobileDevice` = '0') AND "
               . "(`b`.`Browser` NOT IN ('Firefox','IE','Opera','Safari'))"
               . " AND (`b`.`Browser` NOT LIKE 'Chrome%')"
        );

        return parent::calculate($sparte, $type, $summary, $campaigns, $where);
    }
}