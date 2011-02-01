<?php
/**
 * Klasse zum Erstellen der Statistik der festgestellten Betiebssysteme
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
 * Klasse zum Erstellen der Statistik der festgestellten Betiebssysteme
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_Class_Statistics_Adapter_Agent_Os
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

        $group = array('b.Platform');
        $order = array(
            'la.zeit',
            'b.isSyndicationReader',
            'b.isMobileDevice',
            'b.Crawler',
            'b.Platform'
        );

        $fields['browser'] = 'b.Platform';
        //$fields['b']       = new \Zend\Db\Expr('(NULL)');
        $fields['color']   = new \Zend\Db\Expr("CASE
            WHEN `b`.`Browser` = ''                    THEN 'f00'
            WHEN `b`.`Browser` = 'keine Daten'         THEN 'f00'
            WHEN `b`.`Browser` LIKE 'Default Browser%' THEN 'f00'
            WHEN `b`.`isBanned` = 1                    THEN 'f00'
            WHEN `b`.`Crawler` = 1                     THEN '800'
            WHEN `b`.`isSyndicationReader` = 1         THEN '080'
            WHEN `b`.`isMobileDevice` = 1              THEN '00f'
            WHEN `b`.`Platform` = 'Win7'               THEN '440'
            WHEN `b`.`Platform` = 'WinVista'           THEN 'bb0'
            WHEN `b`.`Platform` = 'WinXP'              THEN 'f40'
            WHEN `b`.`Platform` LIKE 'Win%'            THEN 'ff0'
            WHEN `b`.`Platform` = 'Linux'              THEN '0f0'
            WHEN `b`.`Platform` = 'Debian'             THEN '0d0'
            WHEN `b`.`Platform` = 'Android'            THEN '0b0'
            WHEN `b`.`Platform` = 'MacOSX'             THEN 'f0f'
            WHEN `b`.`Platform` = 'MacPPC'             THEN 'd0d'
            WHEN `b`.`Platform` = 'iPhone OSX'         THEN '808'
            WHEN `b`.`Platform` = 'MacPPC'             THEN 'd0d'
            WHEN `b`.`Platform` = 'SunOS'              THEN '404'
            WHEN `b`.`Platform` = 'WAP'                THEN '008'
            WHEN `b`.`Platform` = 'SymbianOS'          THEN '00b'
            WHEN `b`.`Platform` = 'webOS'              THEN '004'
            ELSE 'ddd' END"
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