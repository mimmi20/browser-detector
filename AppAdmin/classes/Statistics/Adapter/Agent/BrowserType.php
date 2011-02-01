<?php
/**
 * Klasse zum Erstellen der Statistik nach Browser-Typen
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
 * Klasse zum Erstellen der Statistik nach Browser-Typen
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_Class_Statistics_Adapter_Agent_BrowserType
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

        $fields['browser'] = new \Zend\Db\Expr("CASE
            WHEN `b`.`Browser` = '' THEN 'unbekannt'
            WHEN `b`.`Browser` = 'keine Daten' THEN 'unbekannt'
            WHEN `b`.`Browser` LIKE 'Default Browser%' THEN 'unbekannt'
            WHEN `b`.`isBanned`=1    THEN 'Bad Spider'
            WHEN `b`.`Crawler`=1 THEN 'Spider'
            WHEN `b`.`isSyndicationReader`=1 THEN 'Syndication Reader'
            WHEN `b`.`isMobileDevice`=1  THEN 'Mobile Browser'
            ELSE 'normale Browser' END"
        );
        //$fields['b']       = new \Zend\Db\Expr('(NULL)');
        $fields['color']   = new \Zend\Db\Expr("CASE
            WHEN `b`.`isBanned`=1                      THEN 'f00'
            WHEN `b`.`Browser` = ''                    THEN 'b00'
            WHEN `b`.`Browser` = 'keine Daten'         THEN 'b00'
            WHEN `b`.`Browser` LIKE 'Default Browser%' THEN '400'
            WHEN `b`.`Crawler`=1                       THEN '800'
            WHEN `b`.`isSyndicationReader`=1           THEN '080'
            WHEN `b`.`isMobileDevice`=1                THEN '00f'
            ELSE '0f0' END"
        );

        $order = array(
            'la.zeit',
            $fields['browser']
        );

        $group = array($fields['browser']);

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