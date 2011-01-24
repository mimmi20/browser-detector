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
 * @version   SVN: $Id: Exceptions.php 30 2011-01-06 21:58:02Z tmu $
 * @deprecated
 */

/**
 * Klasse zum Erstellen der Statistik der registrierten Fehler
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_Class_Statistics_Adapter_Summary_Exceptions
    extends KreditAdmin_Class_Statistics_Adapter_SummaryAbstract
{
    /**
     * calculates the quotes for statistics
     *
     * @param string  $sparte    the name for the sparte
     * @param string  $type      the type of logging
     * @param integer $summary   the kind of information
     * @param string  $campaigns a comma separated list of campaign ids
     *
     * @return array
     */
    public function calculate(
        $sparte = 'Kredit', $type = 'clickout', $summary = 0, $campaigns = '')
    {
        $now          = new \Zend\Date\Date();
        $threeDaysAgo = new \Zend\Date\Date();

        $this->_getMinMax($threeDaysAgo, $now);

        $colors = array(
            'development' => '#090',
            'local'       => '#37a',
            'live'        => '#009',
            'test'        => '#900',
            'test2'       => '#900',
            'localtest'   => '#b22',
            'localtest2'  => '#a73',
            'admin'       => '#d73',
            'admintest'   => '#00d'
        );

        $expression = 'count(*) AS `count`';

        $exceptionModel = new \AppCore\Model\Exception();
        $select         = $exceptionModel->select();
        $select->from(
            'exception',
            array(
                new \Zend\Db\Expr($expression),
                new \Zend\Db\Expr(
                    "DATE_FORMAT(`Throw`, '%Y-%m-%d %H') as `timespan`"
                ),
                new \Zend\Db\Expr('`Enviroment` AS `context`')
            )
        );
        
        $select->where(
            new \Zend\Db\Expr(
                '`Throw` BETWEEN \'' .
                $threeDaysAgo->toString('yyyy-MM-dd 00:00:00') . 
                '\' AND \'' .
                $now->toString('yyyy-MM-dd 23:59:59') . '\''
            )
        );
        //$select->where('`Throw` <  ?', );

        $select->group('Enviroment');
        $select->group(new \Zend\Db\Expr("DATE_FORMAT(`Throw`, '%Y%m%d%H')"));
        $select->order(array('Throw', 'Enviroment'));

        return $this->processQuery(
            $select, 'context',
            $campaigns, 2, $colors, $type
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
        $percent = false,
        $format = true,
        $expression = ''
    )
    {
        $percent    = false;
        $format     = false;
        $expression = '';

        return parent::createTable($result, $percent, $format, $expression);
    }

    /**
     * Process Prepared Select Object
     *
     * @param Zend_Db_Select $select     an sql query object
     * @param string         $field      ??
     * @param string         $type       ??
     * @param string         $sparte     ??
     * @param integer        $summary    ??
     * @param string         $expression an sql expression
     * @param string         $campaigns  a comma separated list of campaign ids
     * @param integer        $isAgent    if 1, user agents will be calculated
     *                                   if 0 or 2, clicks will be calculated
     * @param array|null     $colors     if NULL this parameter will be ignored
     *                                   otherwise an array is needed with the
     *                                   row names as keys
     *                                   only used when $isAgent is 2
     *
     * @return array
     * @access protected
     */
    protected function processQuery(
        Zend_Db_Select $select,
        $field = 'portal',
        $campaigns = '',
        $isAgent = 0,
        $colors = null)
    {
        //Fill Empty Date Range
        $dateStart = new \Zend\Date\Date();
        $dateEnd   = new \Zend\Date\Date();
        $groupSet  = new KreditAdmin_Class_Statistics_Groupset_Hour();

        $this->_getMinMax($dateStart, $dateEnd);

        return $this->process(
            $select,
            $dateStart,
            $dateEnd,
            $groupSet,
            $field,
            $campaigns,
            $isAgent,
            $colors
        );
    }

    /**
     * calculates the quotes for statistics
     *
     * @param \Zend\Date\Date $start ??
     * @param \Zend\Date\Date $end   ??
     *
     * @return array
     */
    private function _getMinMax(\Zend\Date\Date &$start, \Zend\Date\Date &$end)
    {
        $now          = new \Zend\Date\Date();
        $threeDaysAgo = new \Zend\Date\Date();

        $now->addDay(1);
        $now->setMinute(0);
        $now->setSecond(0);

        $threeDaysAgo->subDay(10);
        $threeDaysAgo->setMinute(0);
        $threeDaysAgo->setSecond(0);

        $end   = clone $now;
        $start = clone $threeDaysAgo;
    }
}