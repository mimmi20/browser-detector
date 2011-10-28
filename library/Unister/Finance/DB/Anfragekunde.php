<?php
require_once LIB_PATH . 'Unister' . DS . 'Finance' . DS . 'DB' . DS . 'Abstract.php';

/**
 * Datenbank-Klasse fuer alle Funktionen zur Verwaltung der RIESTER-Schnittstellen
 *
 * @author Thomas Mueller <thomas.mueller@unister-gmbh.de>
 */
class Unister_Finance_DB_Anfragekunde extends Unister_Finance_DB_Abstract
{
    /**
     * unique ID for the Request-Customer
     *
     * @var     integer
     * @access    protected
     */
    protected $AnfrageKundeId = null;

    /**
     * ID for the Customer, who created the Request (foreign ID)
     *
     * @var     integer
     * @access    protected
     */
    protected $Kunde_Id = null;

    /**
     *
     *
     * MySql Set
     * possible values are 'Herr', 'Frau' or 'Unbekannt'
     *
     * @var     string
     * @access    protected
     */
    protected $Anrede = null;

    /**
     * Title of the Requeser
     *
     * @var     string
     * @access    protected
     */
    protected $Titel = null;

    /**
     * Family Name
     *
     * @var     string
     * @access    protected
     */
    protected $Nachname = null;

    /**
     * First Name
     *
     * @var     string
     * @access    protected
     */
    protected $Vorname = null;

    /**
     * Street
     *
     * @var     string
     * @access    protected
     */
    protected $Strasse = null;

    /**
     * House Number
     *
     * @var     string (32Byte)
     * @access    protected
     */
    protected $Hausnummer = null;

    /**
     * Plz
     *
     * @var     string
     * @access    protected
     */
    protected $Plz = null;

    /**
     * Ort
     *
     * @var     string
     * @access    protected
     */
    protected $Ort = null;

    /**
     * TelefonVorwahl
     *
     * @var     string
     * @access    protected
     */
    protected $TelefonVorwahl = null;

    /**
     * TelefonNummer
     *
     * @var     string
     * @access    protected
     */
    protected $TelefonNummer = null;

    /**
     * TelefonMobilVorwahl
     *
     * @var     string
     * @access    protected
     */
    protected $TelefonMobilVorwahl = null;

    /**
     * TelefonMobilNummer
     *
     * @var     string
     * @access    protected
     */
    protected $TelefonMobilNummer = null;

    /**
     * Fax
     *
     * @var     string
     * @access    protected
     */
    protected $Fax = null;

    /**
     * EMail1
     *
     * @var     string
     * @access    protected
     */
    protected $EMail1 = null;

    /**
     * EMail2
     *
     * @var     string
     * @access    protected
     */
    protected $EMail2 = null;

    /**
     * Internet1
     *
     * @var     string
     * @access    protected
     */
    protected $Internet1 = null;

    /**
     * Internet2
     *
     * @var     string
     * @access    protected
     */
    protected $Internet2 = null;

    /**
     * BerufsStatus
     *
     * @var     string
     * @access    protected
     */
    protected $BerufsStatus = null;

    /**
     * BerufsBezeichnung
     *
     * @var     string
     * @access    protected
     */
    protected $BerufsBezeichnung = null;

    /**
     * OeffentlicherDienst
     *
     * @var     string
     * @access    protected
     */
    protected $OeffentlicherDienst = null;

    /**
     * Firma
     *
     * @var     string
     * @access    protected
     */
    protected $Firma = null;

    /**
     * GeburtsDatum
     *
     * @var     date
     * @access    protected
     */
    protected $GeburtsDatum = null;

    /**
     * GeburtsDatumKind1
     *
     * @var     date
     * @access    protected
     */
    protected $GeburtsDatumKind1 = null;

    /**
     * GeburtsDatumKind2
     *
     * @var     date
     * @access    protected
     */
    protected $GeburtsDatumKind2 = null;

    /**
     * Staatsangehoerigkeit
     *
     * @var     string
     * @access    protected
     */
    protected $Staatsangehoerigkeit = null;

    /**
     * GeschlechtKind1
     *
     * @var     string
     * @access    protected
     */
    protected $GeschlechtKind1 = null;

    /**
     * GeschlechtKind2
     *
     * @var     string
     * @access    protected
     */
    protected $GeschlechtKind2 = null;

    /**
     * FamilienStand
     *
     * @var     string
     * @access    protected
     */
    protected $FamilienStand = 'unbekannt';

    /**
     * AnzahlKinder
     *
     * @var     integer
     * @access    protected
     */
    protected $AnzahlKinder = null;

    /**
     * HatBankverbindung
     *
     * @var     boolean
     * @access    protected
     */
    protected $HatBankverbindung = null;

    /**
     * Bankleitzahl
     *
     * @var     integer
     * @access    protected
     */
    protected $Bankleitzahl = null;

    /**
     * Kontonummer
     *
     * @var     integer
     * @access    protected
     */
    protected $Kontonummer = null;

    /**
     * Bankname
     *
     * @var     string
     * @access    protected
     */
    protected $Bankname = null;

    /**
     * Kontoinhaber
     *
     * @var     string
     * @access    protected
     */
    protected $Kontoinhaber = null;

    /**
     * HatSchufa
     *
     * @var     boolean
     * @access    protected
     */
    protected $HatSchufa = null;

    /**
     * HatKreditkarte
     *
     * @var     boolean
     * @access    protected
     */
    protected $HatKreditkarte = null;

    /**
     * KreditkartenNummer
     *
     * @var     string
     * @access    protected
     */
    protected $KreditkartenNummer = null;

    /**
     * KreditkartenDatum
     *
     * @var     date
     * @access    protected
     */
    protected $KreditkartenDatum = null;

    /**
     * KreditkartenInhaber
     *
     * @var     string
     * @access    protected
     */
    protected $KreditkartenInhaber = null;

    /**
     * KreditkartenTyp
     *
     * @var     string
     * @access    protected
     */
    protected $KreditkartenTyp = null;

    /**
     * Hash
     *
     * @var     string
     * @access    protected
     */
    protected $Hash = null;

    /**
     * LeadExport
     *
     * @var     string
     * @access    protected
     */
    protected $LeadExport = null;

    /**
     * Konstruktor
     */
    public function __construct()
    {
        parent::__construct('riester_anfrage_kunde', 'AnfrageKundeId');
    }

    public function mapInput(User_Input $input)
    {
        if ($input->sex == 1) {
            $this->Anrede            = 'Herr';
        } else {
            $this->Anrede            = 'Frau';
        }
        $this->Titel                = $input->titel;
        $this->Nachname                = $input->nachname;
        $this->Vorname                = $input->vorname;
        $this->Strasse                = $input->strasse;
        $this->Hausnummer            = $input->hausnr;
        $this->Plz                    = $input->plz;
        $this->Ort                    = $input->ort;
        $this->TelefonNummer        = $input->telefonPrivat;
        $this->EMail1                = $input->email;
        $this->mapBeruf($input);
        $this->GeburtsDatum            = $this->formatDate($input->gebDatTag, $input->gebDatMonat, $input->gebDatJahr);

        $this->GeburtsDatumKind1    = $this->formatDate($input->gebDatTag2, $input->gebDatMonat2, $input->gebDatJahr2);
        $this->GeburtsDatumKind2    = $this->formatDate($input->gebDatTag3, $input->gebDatMonat3, $input->gebDatJahr3);

        if ($input->familienstand) {
            $this->FamilienStand    = $input->familienstand;
        } else {
            $this->FamilienStand    = 'Unbekannt';
        }

        if ((int) $input->versicherteKinder > 0 && (int) $input->versicherteKinder != 9) {
            $this->AnzahlKinder        = (int) $input->versicherteKinder;
        } else {
            $this->AnzahlKinder        = 0;
        }

        if (isset($input->kontovorname)) {
            $this->HatBankverbindung    = 1;
            $this->Bankleitzahl            = $input->BLZ;
            $this->Kontonummer            = $input->KTO;
            $this->Bankname                = $input->bank;
            $this->Kontoinhaber            = $input->kontovorname . ' ' . $input->kontoname;
        } else {
            $this->HatBankverbindung    = 0;
            $this->Bankleitzahl            = null;
            $this->Kontonummer            = null;
            $this->Bankname                = null;
            $this->Kontoinhaber            = null;
        }

        $this->HatSchufa            = null; //not used
        $this->HatKreditkarte        = null; //not used
        $this->KreditkartenNummer    = null; //not used
        $this->KreditkartenDatum    = null; //not used
        $this->KreditkartenInhaber    = null; //not used
        $this->KreditkartenTyp        = 'KEIN'; //not used
        $this->Hash                    = md5(strtolower($this->Nachname)."_".strtolower($this->Vorname)."_".$this->GeburtsDatum."_".$this->Plz);
        $this->LeadExport            = 0;    //not used yet

    }

    protected function formatDate($day, $month, $year)
    {
        $day   = substr('0' . $day, -2);
        $month = substr('0' . $month, -2);
        $date = $year . '-' . $month . '-' . $day;

        return $date;
    }

    protected function mapBeruf(User_Input $input)
    {
        $berufsstatus = $input->berufsstatus;
        switch ($berufsstatus) {
        case 1:
            $this->BerufsBezeichnung = 'Arbeitnehmer(in) Angestellt (rentenversicherungspflichtig)';
            $this->BerufsStatus = 'Angestellter';
            $this->OeffentlicherDienst = 0;
            break;
        case 2:
            $this->BerufsBezeichnung = 'Arbeitnehmer(in) Arbeiter (rentenversicherungspflichtig)';
            $this->BerufsStatus = 'Arbeiter';
            $this->OeffentlicherDienst = 0;
            break;
        case 3:
            $this->BerufsBezeichnung = 'Arbeiter(in) und Angestellte(r) im öffentlichen Dienst';
            $this->BerufsStatus = 'Angestellter';
            $this->OeffentlicherDienst = 1;
            break;
        case 4:
            $this->BerufsBezeichnung = 'Beamtin/Beamter';
            $this->BerufsStatus = 'Beamter';
            $this->OeffentlicherDienst = 1;
            break;
        case 5:
            $this->BerufsBezeichnung = 'Auszubildende(r) Angestellt';
            $this->BerufsStatus = 'Azubi';
            $this->OeffentlicherDienst = 0;
            break;
        case 6:
            $this->BerufsBezeichnung = 'Auszubildende(r) Arbeiter';
            $this->BerufsStatus = 'Azubi';
            $this->OeffentlicherDienst = 0;
            break;
        case 7:
            $this->BerufsBezeichnung = 'Geringf. Beschäftigte(r) (Verzicht auf Versicherungsfreiheit)';
            $this->BerufsStatus = 'geringVerdiener';
            $this->OeffentlicherDienst = 0;
            break;
        case 8:
            $this->BerufsBezeichnung = 'Geringf. Beschäftigte(r)';
            $this->BerufsStatus = 'geringVerdiener';
            $this->OeffentlicherDienst = 0;
            break;
        case 9:
            $this->BerufsBezeichnung = 'Selbstständige(r) (rentenversicherungspflichtig)';
            $this->BerufsStatus = 'Selbststaendiger';
            $this->OeffentlicherDienst = 0;
        case 10:
            $this->BerufsBezeichnung = 'Selbstständige(r) (nicht rentenversicherungspflichtig)';
            $this->BerufsStatus = 'Selbststaendiger';
            $this->OeffentlicherDienst = 0;
            break;
        case 11:
            $this->BerufsBezeichnung = 'Wehr-/Zivildienstleistende';
            $this->BerufsStatus = 'Wehrdienst';
            $this->OeffentlicherDienst = 0;
            break;
        case 12:
            $this->BerufsBezeichnung = 'Bezieher(in) von Arbeitslosengeld I und II';
            $this->BerufsStatus = 'Arbeitsloser';
            $this->OeffentlicherDienst = 0;
            break;
        case 13:
            $this->BerufsBezeichnung = 'Landwirt(in)';
            $this->BerufsStatus = 'Landwirt';
            $this->OeffentlicherDienst = 0;
            break;
        case 14:
            $this->BerufsBezeichnung = 'Künstler(in)/Publizist(in) (rentenversicherungspflichtig)';
            $this->BerufsStatus = 'Freiberufler';
            $this->OeffentlicherDienst = 0;
            break;
        case 15:
            $this->BerufsBezeichnung = 'Kindererziehungszeit (3 Jahre nach Geburt)';
            $this->BerufsStatus = 'Hausfrau';
            $this->OeffentlicherDienst = 0;
            break;
        case 16:
            $this->BerufsBezeichnung = 'Student(in) (der/die weniger als 400 € im Monat verdienen)';
            $this->BerufsStatus = 'Student';
            $this->OeffentlicherDienst = 0;
            break;
        case 17:
            $this->BerufsBezeichnung = 'Student(in) (der/die mehr als 400 € im Monat verdienen)';
            $this->BerufsStatus = 'Student';
            $this->OeffentlicherDienst = 0;
            break;
        case 18:
            $this->BerufsBezeichnung = 'Hausfrau/-mann';
            $this->BerufsStatus = 'Hausfrau';
            $this->OeffentlicherDienst = 0;
            break;
        case 19:
            $this->BerufsBezeichnung = 'Rentner(in)/EU-Rentner(in)';
            $this->BerufsStatus = 'Rentner';
            $this->OeffentlicherDienst = 0;
            break;
        case 20:
            $this->BerufsBezeichnung = 'Freiwillig versichert';
            $this->BerufsStatus = 'Sonstiger';
            $this->OeffentlicherDienst = 0;
            break;
        case 21:
            $this->BerufsBezeichnung = 'Pflichtversicherte(r) im berufständigen Versorgungswerk';
            $this->BerufsStatus = 'Sonstiger';
            $this->OeffentlicherDienst = 0;
            break;
        default:
            $this->BerufsStatus = 'Angestellter';
            $this->OeffentlicherDienst = 0;
            break;
        }
    }
}
?>