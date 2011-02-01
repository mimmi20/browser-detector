<?php
/**
 * Klasse zum Erstellen der Statistik der festgestellten Browser ohne
 * Berücksichtgung von Version, Betriebssystem usw.
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
 * Klasse zum Erstellen der Statistik der festgestellten Browser ohne
 * Berücksichtgung von Version, Betriebssystem usw.
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_Class_Statistics_Adapter_Agent_Browser
    extends KreditAdmin_Class_Statistics_Adapter_AgentAbstract
{
    /**
     * calculates the summary for user agents for statistics
     *
     * @param string  $sparte    the name for the sparte
     * @param string  $type      the type of logging
     * @param integer $summary   the kind of information
     * @param string  $campaigns a comma separated list of campaign ids
     *
     * @return array
     */
    public function calculate(
        $sparte = 'Kredit', $type = 'click', $summary = 0, $campaigns = '')
    {
        $fields = array();

        $expression = 'IFNULL(SUM(`la`.`anzahl`), 0) as `count`';

        /*
        $fields['bits'] = new \Zend\Db\Expr(
            "CASE WHEN b.Win64 = 1 THEN '64'
                  WHEN b.Win32 = 1 THEN '32'
                  WHEN b.Win16 = 1 THEN '16'
                  ELSE 'unknown' END"
        );
        */

        $fields['browser'] = 'b.Browser';
        //$fields['b']       = new \Zend\Db\Expr('(NULL)');
        $fields['color']   = new \Zend\Db\Expr("CASE
            WHEN `b`.`Browser` = ''                    THEN 'f00'
            WHEN `b`.`Browser` = 'keine Daten'         THEN 'f00'
            WHEN `b`.`Browser` LIKE 'Default Browser%' THEN 'f00'
            WHEN `b`.`isBanned`=1                      THEN 'f00'
            WHEN `b`.`Crawler`=1                       THEN '800'
            WHEN `b`.`isSyndicationReader`=1           THEN '080'
            WHEN `b`.`isMobileDevice`=1                THEN '00f'
            WHEN `b`.`Browser` = 'IE'                  THEN 'ff0'
            WHEN `b`.`Browser` = 'Firefox'             THEN '0ff'
            WHEN `b`.`Browser` = 'Iceweasel'           THEN '0bb'
            WHEN `b`.`Browser` = 'Mozilla'             THEN '088'
            WHEN `b`.`Browser` LIKE 'Safari%'          THEN 'f0f'
            WHEN `b`.`Browser` LIKE 'Opera%'           THEN '808'
            WHEN `b`.`Browser` LIKE 'Chrome%'          THEN 'b0b'
            WHEN `b`.`Browser` = 'Flock'               THEN '404'
            WHEN `b`.`Browser` = 'Iron'                THEN '008'
            WHEN `b`.`Browser` = 'K-Meleon'            THEN '00b'
            WHEN `b`.`Browser` = 'Konqueror'           THEN '004'
            WHEN `b`.`Browser`='AOL'                   THEN 'bbb'
            ELSE 'ddd' END"
        );

        $group      = array($fields['browser']);
        $order      = array(
            'la.zeit',
            'b.isSyndicationReader',
            'b.isMobileDevice',
            'b.Crawler',
            $fields['browser']
        );

        return parent::calculateAgent(
            $expression,
            $group,
            $order,
            $fields,
            $sparte,
            $campaigns
        );
    }
}