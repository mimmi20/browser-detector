<?php
/**
 * Funktionen für KZV-Berechnung
 *
 * PHP versions 4 and 5
 *
 * @category  Geld.de
 * @package   KZV
 * @author    Marko Schreiber <marko.schreiber@unister-gmbh.de>
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2008 Unister GmbH
 * @version   SVN: $Id$
 */

require_once LIB_PATH . 'Unister' . DS . 'Finance' . DS . 'Core' . DS . 'Abstract.php';

/**
 * Funktionen für KZV-Berechnung
 *
 * @category  Geld.de
 * @package   KZV
 * @author    Marko Schreiber <marko.schreiber@unister-gmbh.de>
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2008 Unister GmbH
 */
class Unister_Finance_Core_Kzv extends Unister_Finance_Core_Abstract
{
    /**
     * Enter description here...
     *
     * @param array $data
     * @param array $requestData
     *
     * @return array
     * @access protected
     */
    protected function getKzvOffer(array $data, array $requestData)
    {
        $i      = 0;
        $select = '`kzv_anbieter`,`tarif`,`alter`,';

        switch ($requestData['kzv']['gender']) {
        case "w": $select .= '`frau`'; break;
        default    : $select .= '`mann`'; break;
        }

        $date    = date("Y");
        $datemin = $date - 105; /* max 105 Jahre */
        $datemax = $date + 1; /* kein min */

        $alter = $date - $requestData['kzv']['birth'];
        $where = "WHERE"
               . " `alter` = " . $alter;

        $result = $this->_db->db_query("SELECT " . $select . " FROM tarife_kzv " . $where . "",__line__ . "<br/>" . __file__);

        $kzv = array();

        while ($row = $this->_db->db_fetch_assoc()) {
            $kzv[$i] = $row;

            switch ($kzv[$i]['kzv_anbieter']) {
            case "signal":
                $kzv[$i]['kzv_anbieter_name'] = 'SIGNAL IDUNA';
                break;
            default:
                break;
            }

            $kzv[$i]['price']        = ($kzv[$i]['mann'] ? $kzv[$i]['mann'] : $kzv[$i]['frau']);
            $tlnk                    = strtolower($this->prepareLink($kzv[$i]['tarif']));
            $kzv[$i]['tarifinfolnk'] = $row['kzv_anbieter'] . '-' . $tlnk;

            $i++;
        }

        return $kzv;
    }

    /**
     * Enter description here...
     *
     * @param array $data
     * @param array $requestData
     *
     * @return array
     * @access protected
     */
    protected function getKzvValid(array $data, array $requestData)
    {
        $i   = 0;
        $kzv = $requestData;

        $date    = date("Y");
        $datemin = $date - 105; /* max 105 Jahre */
        $datemax = $date + 1; /* kein min */

        for ($i = 1; $i <= 3; $i++) {
            if ($requestData['Geburtsdatum_year_VN'.$i] != '') {
                $select = '`kzv_anbieter`,`tarif`,`alter`,';

                switch ($requestData['Anrede_VN'.$i]) {
                case "Frau":
                    $select .= '`frau`';
                    break;
                default:
                    $select .= '`mann`';
                    break;
                }

                $alter  = $date - $requestData['Geburtsdatum_year_VN'.$i];
                $where  = "WHERE" . " `alter` = " . $alter;
                $result = $this->_db->db_query("SELECT " . $select . " FROM tarife_kzv " . $where . "",__line__ . "<br/>" . __file__);

                if ($row = $this->_db->db_fetch_assoc()) {
                    $kzv['offer']['VN'.$i] = $row;
                }
            }
        }

        $kzv['status'] = 'ok';#$this->validateKzvBlz($requestData);

        return $kzv;
    }

    /**
     * Enter description here...
     *
     * @param array $requestData
     *
     * @return string
     * @access protected
     */
    protected function validateKzvBlz(array $requestData)
    {
        $msg = 'bad';

        $result = $this->_db->db_query("SELECT * FROM `blz_liste_komplett` WHERE `blz`=" . intval($requestData['BLZ']), __line__ . __file__);

        if ($row = $this->_db->db_fetch_assoc()) {
            $msg = 'ok';
        }

        return $msg;
    }

    /**
     * Enter description here...
     *
     * @return array
     * @access public
     */
    public function kzvDates()
    {
        $kzv = array();

        $kzv['days']     = $GLOBALS['_GLOBAL_DATUM_TAGE'];
        $kzv['months']   = $GLOBALS['_GLOBAL_DATUM_MONATE_2'];
        $kzv['curmonth'] = date("m");

        /* versicherungsbeginn jahr */
        $year    = date("Y");
        $yearmin = $year - 105; /* max 105 Jahre */
        $yearmax = $year + 1; /* kein min */

        for ($yearmin; $yearmin < $yearmax; $yearmin++) {
            $kzv['birthday'][$yearmin] = $yearmin;
        }

        $kzv['versjahr'][substr($year, 2)] = $year;
        $kzv['versjahr'][substr(strval($year + 1), 2)] = strval($year + 1);

        if ($kzv['curmonth'] == '12') {
            $year = $year + 1;
        }

        $kzv['versjahrSelected'] = substr($year, 2);

        /* versicherungsbeginn monat */
        if (intval($kzv['curmonth']) == 12) {
            $kzv['versbeg'] = 1;
        } else {
            $kzv['versbeg'] = intval($kzv['curmonth']) + 1;
        }

        return $kzv;
    }

    /**
     * Enter description here...
     *
     * @param string $string
     *
     * @return string
     * @access public
     */
    public function prepareLink($string)
    {
        $sz = array(
                "?"         => "ae",
                "?"         => "ae",
                "?"         => "oe",
                "?"         => "oe",
                "?"         => "ue",
                "?"         => "ue",
                "?"         => "ss",
                "\""     => "",
                "?"         => "",
                ":"         => "",
                "."         => "",
                ","         => "",
                "%"        => "",
                "/ "     => "",
                " "         => "-",
                );

        while (list($key, $value) = each($sz)) {
            $string = str_replace($key, $value, trim($string));
        }

        $string = str_replace("---", "-", trim($string));
        return strtolower($string);
    }

} #END CLASS