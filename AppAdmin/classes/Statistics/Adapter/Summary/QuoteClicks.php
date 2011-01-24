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
 * @version   SVN: $Id: QuoteClicks.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Klasse zum Erstellen der Statistik für die Quote Clickout/Pageimpression bzw.
 * Sales/Clickouts
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_Class_Statistics_Adapter_Summary_QuoteClicks
    extends KreditAdmin_Class_Statistics_Adapter_SummaryAbstract
{
    /**
     * calculates the summary for statistics
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
        if (is_numeric($sparte)) {
            $modelSparte = new \AppCore\Model\Sparten();
            $s           = $modelSparte->find($sparte)->current();
            if (is_object($s)) {
                $sparte = $s->s_name;
            } else {
                return array();
            }
        }
        if ($type == 'sale') {
            $cType = 'clickout';
        } else {
            $cType = 'pageimpression';
        }

        $calculator = new KreditAdmin_Class_Statistics_Adapter_Campaign_Click();
        $calculator->setFilter($this->getFilter());

        $clicks = $calculator->calculate($sparte, $cType, $summary, $campaigns);
        $details = $calculator->calculate($sparte, $type, $summary, $campaigns);

        $quote = array();

        foreach ($details as $partner => $detail) {
            $detailData = $detail['data'];

            foreach ($detailData as $timestamp => $dCount) {
                $q = 0.0;

                if (isset($clicks[$partner]['data'][$timestamp])
                    && $clicks[$partner]['data'][$timestamp] > 0
                ) {

                    $cCount = $clicks[$partner]['data'][$timestamp];

                    if ($cCount > 0) {
                        $q = $dCount / $cCount;
                    }
                }

                $quote[$partner]['data'][$timestamp] = $q;

                $quote[$partner]['name']   = ((isset($detail['name']))
                                           ? $detail['name']
                                           : '');
                $quote[$partner]['color']  = ((isset($detail['color']))
                                           ? $detail['color']
                                           : 'ddd');
                $quote[$partner]['parent'] = ((isset($detail['parent']))
                                           ? $detail['parent']
                                           : '');
            }
        }

        return $quote;
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
        $percent    = true;
        $format     = true;
        $expression = ' %';

        return parent::createTable($result, $percent, $format, $expression);
    }
}