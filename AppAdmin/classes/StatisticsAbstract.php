<?php
/**
 * abstrakte Klasse mit Backend-Funktionen für die Statistik
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: StatisticsAbstract.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * abstrakte Klasse mit Backend-Funktionen für die Statistik
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @abstract
 */
abstract class KreditAdmin_Class_StatisticsAbstract
{
    /**
     * @var KreditAdmin_Class_Statistics_Filter
     */
    protected $_filter;

    /**
     * @var KreditAdmin_Class_Statistics_MandantResolver
     */
    protected $_mandant;

    /**
     * @var \\AppCore\\Model\Application
     */
    protected $_dbApplication;

    /**
     * @var Array
     */
    protected $_applicationStatus = array();

    protected $_logger = null;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->_filter  = new KreditAdmin_Class_Statistics_Filter();
        $this->_mandant = new KreditAdmin_Class_Statistics_MandantResolver();
        $this->_logger  = \Zend\Registry::get('log');

        $this->_dbApplication = new \AppCore\Model\StatEinfach();
    }

    /**
     * Get Filter Object
     *
     * @return KreditAdmin_Class_Statistics_Filter
     */
    public function getFilter()
    {
        return $this->_filter;
    }


    /**
     * Get Filter Object
     *
     * @return KreditAdmin_Class_Statistics_Filter
     */
    public function getSparten()
    {
        $sparten = new \AppCore\Model\Sparten();
        $select  = $sparten->select('sparten');

        if (null !== $select) {
            $select->columns('s_name')
                ->where('`active` = ? ', 1)
                ->setIntegrityCheck(false);

            $rows = $sparten->fetchAll($select);
            $rows = $rows->toArray();
        } else {
            $rows = array();
        }

        $s = array();
        foreach ($rows as $row) {
            $s[$row['s_name']] = $row['s_name'];
        }

        return $s;
    }

    /**
     * Set Filter Object
     *
     * @param KreditAdmin_Class_Statistics_Filter $filter ??
     *
     * @return KreditAdmin_Class_StatisticsAbstract
     */
    public function setFilter(KreditAdmin_Class_Statistics_Filter $filter)
    {
        $this->_filter = $filter;
        return $this;
    }

    /**
     * Get Mandant Whitelist Object
     *
     * @return KreditAdmin_Class_Statistics_MandantResolver
     */
    public function getWhitelist()
    {
        return $this->_mandant;
    }

    /**
     * Set Mandant Whitelist Object
     *
     * @param KreditAdmin_Class_Statistics_MandantResolver $list ??
     *
     * @return KreditAdmin_Class_StatisticsAbstract
     */
    public function setWhitelist(
        KreditAdmin_Class_Statistics_MandantResolver $list)
    {
        $this->_mandant = $list;
        return $this;
    }

    /**
     * Encode ResultSet for the View
     *
     * @param Array $result the calculation result as array
     *
     * @return string Json
     */
    public function encodeResult(array $result)
    {
        foreach ($result as $paId => $value) {
            if ($paId != 'table') {
                $result[$paId]['label'] = (isset($value['name'])
                                        ? $value['name'] : 'andere');

                $result[$paId]['color'] = (isset($value['color'])
                                        ? '#' . $value['color'] : '#ccc');

                unset($result[$paId]['name']);
                $swap = array();
                foreach ((array)$result[$paId]['data'] as $date => $count) {
                    $date = $this->_filter->getGroupSet()->toTimestamp($date);
                    $date = sprintf('%e', $date);

                    $swap[] = array($date, $count);
                }
                $result[$paId]['data'] = $swap;

                if (isset($result[$paId]['details'])) {
                    $swap = array();
                    foreach ((array)$result[$paId]['details'] as $date => $count
                    ) {
                        $date = $this->_filter->getGroupSet()
                                              ->toTimestamp($date);

                        $swap[] = array($date, $count);
                    }
                    $result[$paId]['details'] = $swap;
                }
            }
        }

        $normalized = array(
            'data'  => array(),
            'table' => ((isset($result['table'])) ? $result['table'] : '')
        );

        foreach ($result as $paId => $value) {
            if ($paId != 'table') {
                $normalized['data'][] = $value;
            }
        }

        return Zend_Json::encode($normalized);
    }

    /**
     * Prepare Select Statement
     *
     * @return Zend_Db_Select an sql query object
     */
    protected function prepareCalculation()
    {
        $select = $this->_dbApplication->select()->setIntegrityCheck(false);
        return $select;
    }

    /**
     * Add Mandant Expression to Query
     *
     * @param Zend_Db_Select $select an sql query object
     *
     * @return KreditAdmin_Class_StatisticsAbstract
     */
    protected function concatMandantWhitelist(Zend_Db_Select $select)
    {
        $referenceArray = $this->_mandant->getReferenceList();

        //Add Bogus Reference so we cant find any Rows if References are empty
        $referenceArray[] = 'xxx';
        $select->where('`a`.`portal` IN (?)', $referenceArray);
        return $this;
    }

    /**
     * Add Date Filter Expression to Query
     *
     * @param Zend_Db_Select $select an sql query object
     *
     * @return KreditAdmin_Class_StatisticsAbstract
     */
    protected function concatDateFilter(Zend_Db_Select $select)
    {
        $select->where(
            new \Zend\Db\Expr(
                '`la`.`zeit` BETWEEN \'' . $this->_filter->getDateStartIso() .
                '\' AND \'' . $this->_filter->getDateEndIso() . '\''
            )
        );

        return $this;
    }

    /**
     * Add Date Filter Expression to Query
     *
     * @param Zend_Db_Select $select an sql query object
     * @param string         $sparte the name of an sparte
     *
     * @return KreditAdmin_Class_StatisticsAbstract
     */
    protected function concatSparteFilter(Zend_Db_Select $select, $sparte)
    {
        $select->where('`a`.`sparte` = ?', $sparte);

        return $this;
    }

    /**
     * Add Date Filter Expression to Query
     *
     * @param Zend_Db_Select $select a sql query object
     * @param string         $type   one kind of type
     *
     * @return KreditAdmin_Class_StatisticsAbstract
     */
    protected function concatTypeFilter(Zend_Db_Select $select, $type)
    {
        //$select->where("`a`.`type` like '$type%'");

        switch ($type) {
            case 'sale':
                // Break intentionally omitted
            case 'pageimpression':
                // Break intentionally omitted
            case 'info':
                $select->where('`a`.`type` = \'' . $type . '\'');
                break;
            case 'clickout':
                // Break intentionally omitted
            case 'clickoutsale':
                $select->where(
                    "(`a`.`type` like 'clickout%' OR `a`.`type` IN " .
                    "('antrag2','antrag3'))"
                );
                break;
            case 'antrag':
                $select->where("`a`.`type` like 'antrag%'");
                $select->where("`a`.`type` NOT IN ('antrag2','antrag3')");
                break;
            default:
                // nothing to do here
                break;
        }

        return $this;
    }

    /**
     * Add Group By Expression
     *
     * @param Zend_Db_Select $select an sql query object
     *
     * @return KreditAdmin_Class_StatisticsAbstract
     */
    protected function concatGroupFilter(
        Zend_Db_Select $select, $field = 'portal')
    {
        $select->group(array('timespan', $field));
        return $this;
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
        $dateStart = clone($this->_filter->getDateStart());
        $dateEnd   = clone($this->_filter->getDateEnd());
        $groupSet  = $this->_filter->getGroupSet();

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
    protected function process(
        Zend_Db_Select $select,
        \Zend\Date\Date $dateStart,
        \Zend\Date\Date $dateEnd,
        $groupSet,
        $field = 'portal',
        $campaigns = '',
        $isAgent = 0,
        $colors = null)
    {
        //$this->_logger->info($select->assemble());

        $rows = $this->_dbApplication->fetchAll($select);

        //Group Result by Mandant
        $sr = array();

        while ($rows->valid()) {
            $row = $rows->current();

            $timespan = $groupSet->toCompare($row->timespan);

            if (!isset($sr[$row->$field]['data'][$timespan])) {
                $sr[$row->$field]['data'][$timespan] = 0;
            }

            $sr[$row->$field]['data'][$timespan] += $this->parseValue(
                $row->count
            );

            if ($isAgent === 1) {
                $sr[$row->$field]['color']  = $row->color;
                $sr[$row->$field]['name']   = $row->$field;
                $sr[$row->$field]['parent'] = array(
                    'name'  => ((isset($row->b)) ? (string)$row->b : ''),
                    'color' => $row->color
                );
            }

            $rows->next();
        }

        $model = new KreditAdmin_Class_Statistics_MandantResolver();

        if ($isAgent === 0) {
            $mandants = $model->getReferenceList($campaigns);
        } else {
            $mandants = array_keys($sr);
        }

        while ($groupSet->compareFilterDates($dateStart, $dateEnd)) {
            $curDateString = $dateStart->toString(
                $groupSet->getDateCompareFormat()
            );

            foreach ($mandants as $paid) {
                if ($isAgent === 0) {
                    $sr[$paid]['color']  = $model->getMandantColor($paid);
                    $sr[$paid]['name']   = $model->getMandantName($paid);
                    $sr[$paid]['parent'] = $model->getParent($paid);
                } elseif ($isAgent === 2) {
                    if ($colors === null
                        || !is_array($colors)
                        || !isset($colors[$paid])
                    ) {
                        $sr[$paid]['color']  = 'ddd';
                    } else {
                        if (substr($colors[$paid], 0, 1) == '#') {
                            $colors[$paid] = substr($colors[$paid], 1);
                        }

                        $sr[$paid]['color']  = $colors[$paid];
                    }
                    $sr[$paid]['name']   = $paid;
                    $sr[$paid]['parent'] = '';
                }

                $amount = ((isset($sr[$paid]['data'][$curDateString]))
                        ? $sr[$paid]['data'][$curDateString]
                        : 0);

                $sr[$paid]['data'][$curDateString] = $this->parseValue(
                    $amount
                );
            }

            $dateStart = $groupSet->addDateStep($dateStart);
        }

        //sort the data
        $keys = array_keys($sr);
        foreach ($keys as $paid) {
            ksort($sr[$paid]['data']);
        }

        ksort($sr);

        return $sr;
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
     *
     * @return array
     * @access protected
     */
    protected function processQueryDetail(Zend_Db_Select $select)
    {
        $rows = $this->_dbApplication->fetchAll($select)->toArray();

        $sr = array();

        if (count($rows)) {
            $i = 0;

            foreach ($rows as $row) {
                if ($row['count'] > 0) {
                    if ($i > 11) {
                        $sr[11] = array(
                            'institut' => 'andere',
                            'color'    => 'ddd',
                            'count'    => $sr[11]['count'] + $row['count']
                        );
                    } else {
                        $sr[$i] = $row;
                    }
                    $i++;
                }
            }
        }

        //ksort($sr);

        return $sr;
    }

    /**
     * Normalize the Numeric Statistic Value
     *
     * @param mixed $value the value to be parsed
     *
     * @return float
     */
    protected function parseValue($value)
    {
        return (float) $value;
    }

    /**
     * Disable View Renderer
     *
     * @return void
     */
    protected function initAjax()
    {
        $this->_helper->viewRenderer->setNoRender();
        //$this->_helper->layout->disableLayout();
    }

    /**
     * Encode ResultSet for the View
     *
     * @param array   $result ??
     * @param integer $type   ??
     *
     * @return Json
     */
    protected function createTableWithPercent(
        array $result,
        $percent = false,
        $format = true,
        $summeAnz = true,
        $grafisch = false,
        $expression = ''
    )
    {
        $sortData = array();

        foreach ($result as $value) {
            if (isset($value['parent'])) {
                $parent = $value['parent'];
            } else {
                $parent = array();
            }

            if (!isset($parent['name'])) {
                $parent['name'] = '';
            }

            if (!isset($sortData[$parent['name']])) {
                $sortData[$parent['name']] = array(
                    'parent' => $parent, 'details' => array()
                );
            }

            $sortData[$parent['name']]['details'][] = array(
                'data'  => $value['data'],
                'color' => ((isset($value['color'])) ? $value['color'] : 'ddd'),
                'name'  => ((isset($value['name'])) ? $value['name'] : '')
            );
        }

        $partner = array_keys($result);

        if (isset($partner[0]) && isset($result[$partner[0]])) {
            $spaltenAnzahl = count($result[$partner[0]]['data']);
            $titelRows     = array_keys($result[$partner[0]]['data']);
        } else {
            $spaltenAnzahl = 0;
            $titelRows     = array();
        }

        $txt = '<colgroup>
                <col class="fist" />
                <col class="rowSummary" />
                </colgroup>
                <colgroup>';

        foreach ($titelRows as $titelRow) {
            $txt .= '<col class="data" />';
        }

        $txt .= '
                </colgroup>
                <thead>
                <tr class="head">
                    <th class="first {sorter: \'text\'}">Portal / Kampagne</th>
                    <th class="rowSummary {sorter: \'deutscheZahl\'}">Summe</th>
                    ';

        foreach ($titelRows as $titelRow) {
            $txt .= '<th class="date {sorter: \'deutscheZahl\'}">'
                 . $titelRow . '</th>';
        }

        $txt .= '
                </tr></thead>';

        $txtBody  = '<tbody>';
        $txtFoot  = '';
        $rowCycle = 0;
        $summe    = array();

        foreach ($sortData as $parent => $partner) {
            $partnerSumme = array();

            foreach ($partner['details'] as $zeile) {
                $zeilenSumme = 0;
                $className   = ((($rowCycle % 2) == 0) ? 'odd' : 'even');
                $txtBody    .= '<tr class="' . $className
                             . '" onmouseover="this.className=\'highlight\'" '
                             . 'onmouseout="this.className=\'' . $className
                             . '\'"><td class="first">' . ($grafisch
                             ? '<div class="labelColor" style="background-col'
                             . 'or: #' . $zeile['color'] . ';"></div>' : '')
                             . $zeile['name']
                             . '</td><td class="rowSummary">###SUMMARY###</td>';

                foreach ($zeile['data'] as $spaltenIndex => $spalte) {
                    if (!isset($summe[$spaltenIndex])) {
                        $summe[$spaltenIndex] = 0;
                    }

                    if ($percent) {
                        // Quote -> in Prozent umrechnen
                        $spalte = $spalte * 100;
                    }

                    $summe[$spaltenIndex] += (float) $spalte;

                    if (!isset($partnerSumme[$spaltenIndex])) {
                        $partnerSumme[$spaltenIndex] = 0;
                    }
                    $partnerSumme[$spaltenIndex] += (float) $spalte;
                    $zeilenSumme += (float) $spalte;

                    $txtBody .= '<td class="data">'
                              . (((float) $spalte > 0) ? (($format)
                              ? number_format((float) $spalte, 2, ',', '.')
                              . $expression
                              : number_format((int) $spalte, 0, ',', '.'))
                              : '&nbsp;') . '</td>';
                }

                $txtBody = str_replace(
                    '###SUMMARY###',
                    (($summeAnz && (float) $zeilenSumme > 0)
                    ? (($format) ? number_format(
                        (float) $zeilenSumme, 2, ',',
                        '.'
                    ) . $expression : number_format(
                        (int) $zeilenSumme, 0,
                        ',', '.'
                    )) : '&nbsp;'),
                    $txtBody
                );

                $txtBody .= '</tr>';

                if (!$grafisch) {
                    $rowCycle++;
                }
            }

            if ($grafisch) {
                $rowCycle++;
            }
        }

        $txtBody .= '</tbody>';

        $txtFoot    = '<tfoot><tr class="summary"><td class="first">Gesamt</td>'
                    . '<td>###SUMMARY###</td>';
        $rowSummary = 0;

        foreach ($summe as $spaltenIndex => $spalte) {
            $rowSummary += (float) $spalte;
            $txtFoot    .= '<td class="data">'
                         . (($summeAnz && (float) $spalte > 0) ? (($format)
                         ? number_format((float) $spalte, 2, ',', '.')
                         . $expression : number_format(
                             (int) $spalte, 0, ',',
                             '.'
                         )) : '&nbsp;') . '</td>';
        }

        $txtFoot = str_replace(
            '###SUMMARY###',
            (($summeAnz && (float) $rowSummary > 0)
            ? (($format) ? number_format((float) $rowSummary, 2, ',', '.')
            . $expression : number_format((int) $rowSummary, 0, ',', '.'))
            : '&nbsp;'),
            $txtFoot
        );

        $txtFoot        .= '</tr></tfoot>';
        $txt            .= $txtFoot . $txtBody . '';
        $result['table'] = $txt;

        return $result;
    }

    /**
     * Set Application Status Type Id(s) for the next Calculation
     *
     * @param int|array $status the new status type
     *
     * @return KreditAdmin_Class_StatisticsAbstract
     */
    public function setApplicationStatus($status)
    {
        $this->_applicationStatus = (array)$status;

        return $this;
    }
}