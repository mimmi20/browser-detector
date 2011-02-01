<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Model;

/**
 * Model
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * Model
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Kunde extends ModelAbstract
{
    /**
     * Name of the table in the db schema relating to child class
     *
     * @var    string
     * @access protected
     */
    protected $_name = 'kunde';

    /**
     * Name of the primary key field in the table
     *
     * @var    string
     * @access protected
     */
    protected $_primary = 'KundeId';

    /**
     * sets the data for an new customer
     *
     * @param array $input the data about the customer
     *
     * @return \\AppCore\\Model\Kunde
     */
    public function mapInput(array $input, $customerId = null)
    {
        $dataSet = $this->updateInput($input, $customerId);

        $dataSet->Nachname = $input['nachname'];
        $dataSet->Vorname  = $input['vorname'];
        $dataSet->EMail1   = $input['email'];

        /*
         * reset hash
         */
        $dataSet->Hash = md5(
            strtolower($dataSet->Nachname) . '_' .
            strtolower($dataSet->Vorname) . '_' .
            $dataSet->GeburtsDatum . '_' .
            $dataSet->Plz
        );

        return $dataSet;
    }

    /**
     * updates the customer data for a new or an existing customer
     *
     * @param array $input the data about the customer
     *
     * @return \\AppCore\\Model\Kunde
     */
    public function updateInput(array $input, $customerId = null)
    {
        if (null === $customerId) {
            $dataSet = $this->createRow();
        } else {
            $dataSet = $this->find($customerId)->current();
        }

        $dataSet->Anrede         = $input['anrede'];
        $dataSet->Titel          = $input['titel'];
        $dataSet->Strasse        = $input['strasse'];
        $dataSet->Hausnummer     = $input['hausnr'];
        $dataSet->Plz            = $input['plz'];
        $dataSet->Ort            = $input['ort'];
        $dataSet->TelefonVorwahl = $input['vorwahl'];
        $dataSet->TelefonNummer  = $input['telefon'];

        $dataSet->TelefonMobilVorwahl = $input['vorwahlmobil'];
        $dataSet->TelefonMobilNummer  = $input['mobilfunk'];

        $dataSet = $this->_mapBeruf($dataSet, $input);

        $dataSet->GeburtsDatum = $this->_formatDate(
            $input['gebdatumTag'],
            $input['gebdatumMonat'],
            $input['gebdatumJahr']
        );

        if (isset($input['verheiratet']) && $input['verheiratet']) {
            $dataSet->FamilienStand    = $input['verheiratet'];
        } else {
            $dataSet->FamilienStand    = 'unbekannt';
        }

        $dataSet->Staatsangehoerigkeit = $input['land'];

        $dataSet->Hash = md5(
            strtolower($dataSet->Nachname) . '_' .
            strtolower($dataSet->Vorname) . '_' .
            $dataSet->GeburtsDatum . '_' .
            $dataSet->Plz
        );

        return $dataSet;
    }

    /**
     * formats the date
     *
     * @param integer $day
     * @param integer $month
     * @param integer $year
     *
     * @return string
     */
    private function _formatDate($day, $month, $year)
    {
        $day   = substr('00' . $day, -2);
        $month = substr('00' . $month, -2);
        $year  = substr('2000' . $year, -4);

        $date = $year . '-' . $month . '-' . $day;

        return $date;
    }

    /**
     * maps the profession to values given by Portalservice
     *
     * @param \Zend\Db\Table\Row $dataSet the actual dataset
     * @param array             $input   a data array
     *
     * @return void
     * @access protected
     */
    private function _mapBeruf(\Zend\Db\Table\Row $dataSet, array $input)
    {
        if (!isset($input['berufsgruppe'])) {
            return;
        }

        $berufsstatus = (int) $input['berufsgruppe'];

        $beruf = \AppCore\Globals::getBerufsgruppe($berufsstatus);
        $dataSet->BerufsBezeichnung   = $beruf;

        switch ($berufsstatus) {
            case KREDIT_BERUFSGRUPPE_VORSTAND_GESCHAEFTSFUEHRER:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_SELBST_GEWERBETREIBENDER:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_SELBST_FREIBERUFLER:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_SELBST_GESCHAEFTSFUEHRER:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_SELBSTAENDIGE:
                $dataSet->BerufsStatus        = 'Selbststaendiger';
                $dataSet->OeffentlicherDienst = 'nein';
                break;
            case KREDIT_BERUFSGRUPPE_LEITENDER_ANGESTELLTER:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_ANGESTELLTER:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_SOLDAT_AUF_ZEIT:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_MEISTER:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_FACHARBEITER:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_ARBEITER:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_ANGESTELLTER_OEFFENTLICHER_DIENST:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_ANGESTELLT_IM_AUSLAND:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_ARBEITER_OEFFENTLICHER_DIENST:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_HILFSARBEITER:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_WEHRPFLICHTIGER:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_SOLDAT:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_ARBEITER_ANGESTELLTER:
                $dataSet->BerufsStatus        = 'Angestellter';
                $dataSet->OeffentlicherDienst = 'nein';
                break;
            case KREDIT_BERUFSGRUPPE_BEAMTE_GEHOBENER_DIENST:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_BEAMTE_HOEHERER_DIENST:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_BEAMTE_MITTLERER_DIENST:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_BEAMTE_EINFACHER_DIENST:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_BERUFSSOLDAT:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_BEAMTE:
                $dataSet->BerufsStatus        = 'Beamter';
                $dataSet->OeffentlicherDienst = 'ja';
                break;
            case KREDIT_BERUFSGRUPPE_STUDENT:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_SCHUELER:
                $dataSet->BerufsStatus        = 'Student';
                $dataSet->OeffentlicherDienst = 'nein';
                break;
            case KREDIT_BERUFSGRUPPE_AUSZUBILDENDER:
                $dataSet->BerufsStatus        = 'Azubi';
                $dataSet->OeffentlicherDienst = 'nein';
                break;
            case KREDIT_BERUFSGRUPPE_HAUSFRAU_MANN:
                $dataSet->BerufsStatus        = 'Hausfrau';
                $dataSet->OeffentlicherDienst = 'nein';
                break;
            case KREDIT_BERUFSGRUPPE_RENTNER:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_PENSIONAER:
                $dataSet->BerufsStatus        = 'Rentner';
                $dataSet->OeffentlicherDienst = 'nein';
                break;
            case KREDIT_BERUFSGRUPPE_ARBEITSLOS_SOLZIALHILFEEMPFAENGER:
                $dataSet->BerufsStatus        = 'Arbeitsloser';
                $dataSet->OeffentlicherDienst = 'nein';
                break;
            case KREDIT_BERUFSGRUPPE_SONSTIGE:
                $dataSet->BerufsStatus        = 'Sonstiger';
                $dataSet->OeffentlicherDienst = 'nein';
                break;
            default:
                $dataSet->BerufsStatus        = 'Angestellter';
                $dataSet->OeffentlicherDienst = 'nein';
                break;
        }

        return $dataSet;
    }

    /**
     * searches a dataset
     *
     * @param array $input
     *
     * @return array
     */
    public function search(array $input)
    {
        $select = $this->select();
        $select->from($this->_name)
            ->distinct()
            ->where('Nachname = ?', $input['nachname'])
            ->where('Vorname = ?', $input['vorname'])
            ->where('EMail1 = ?', $input['email'])
            ->order($this->_primary)
            ->limit(1);

        try {
            return $this->fetchAll($select)->toArray();
        } catch (Exception $e){
            $this->_logger->err($e);

            return array();
        }
    }

    /**
     * Prueft ob bereits ein Kunde mit aehnlichen Daten existiert
     *
     * @param Kunde $kunde
     * @return Integer ID des Kunden
     */
    public function existiertKunde(\\AppCore\\Model\Kunde $kunde)
    {
        $md = md5(
            strtolower($kunde->Nachname) . '_' .
            strtolower($kunde->Vorname) . '_' .
            $kunde->GeburtsDatum . '_' .
            $kunde->Plz
        );

        //$result = Doctrine_Core::getTable($this->_name)->findByHash($md);

        $select = $this->select();
        $select->from($this->_name)
            ->distinct()
            ->where('Hash = ?', $md)
            ->limit(1);

        try {
            $result = $this->fetchAll($select)->current();
        } catch (Exception $e){
            $this->_logger->err($e);

            return false;
        }

        if (isset($result->KundeId) && $result->KundeId) {
            return true;
        } else {
            return false;
        }
    }
}