<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore;

/**
 * Klasse, die Funktionen enthält, die an verschiedenen Stellen benötigt werden,
 * aber nicht vererbt werden können
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * Klasse, die Funktionen enthält, die an verschiedenen Stellen benötigt werden,
 * aber nicht vererbt werden können
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Globals
{
    public static $generalStates = array(
        ''     => ' - Bitte ausw&auml;hlen - ',
        'AD' => 'Andorra',
        'AE' => 'Vereinigte Arabische Emirate',
        'AF' => 'Afghanistan',
        'AG' => 'Antigua & Barbuda',
        'AI' => 'Anguilla',
        'AL' => 'Albanien ',
        'AM' => 'Armenien ',
        'AN' => 'Niederl&auml;ndische Antillen',
        'AO' => 'Angola ',
        'AQ' => 'Antartik',
        'AR' => 'Argentinien',
        'AS' => 'Amerikanisch Samoa',
        'AT' => '&Ouml;sterreich',
        'AU' => 'Australien',
        'AW' => 'Aruba',
        'AZ' => 'Aserbaidschan ',
        'BA' => 'Bosnien Herzegowina ',
        'BB' => 'Barbados',
        'BD' => 'Bangladesch',
        'BE' => 'Belgien',
        'BF' => 'Burkina Faso',
        'BG' => 'Bulgarien ',
        'BH' => 'Bahrain',
        'BI' => 'Burundi',
        'BJ' => 'Benin',
        'BM' => 'Bermuda',
        'BN' => 'Brunei',
        'BO' => 'Bolivien',
        'BR' => 'Brasilien',
        'BS' => 'Bahamas',
        'BT' => 'Bhutan',
        'BV' => 'Bouvet Insel',
        'BW' => 'Botswana',
        'BY' => 'Wei&szlig;russland ',
        'BZ' => 'Belize',
        'CA' => 'Canada ',
        'CC' => 'Cocos Island',
        'CD' => 'Demokratische Republik Kongo',
        'CF' => 'Zentral Afrikanische Republik',
        'CG' => 'Congo ',
        'CH' => 'Schweiz ',
        'CI' => 'Elfenbeink&uuml;ste',
        'CK' => 'Cook Insel',
        'CL' => 'Chile',
        'CM' => 'Kamerun',
        'CN' => 'China',
        'CO' => 'Kolumbien',
        'CR' => 'Costa Rica',
        'CS' => 'Serbien Montenegro',
        'CU' => 'Kuba',
        'CV' => 'Kap Verde',
        'CX' => 'Christmas Islands',
        'CY' => 'Zypern',
        'CZ' => 'Tschechische Republik',
        'DE' => 'Deutschland',
        'DJ' => 'Dschibouti',
        'DK' => 'D&auml;nemark',
        'DM' => 'Dominika',
        'DO' => 'Dominikanische Republik',
        'DZ' => 'Algerien',
        'EC' => 'Ecuador',
        'EE' => 'Estland',
        'EG' => '&Auml;gypten',
        'EH' => 'West Sahara',
        'EI' => 'Irland',
        'ER' => 'Eritrea',
        'ES' => 'Spanien ',
        'ET' => '&Auml;thiopien',
        'FI' => 'Finnland',
        'FJ' => 'Fidschi',
        'FK' => 'Falkland',
        'FM' => 'Mikronesien',
        'FO' => 'Faroer ',
        'FR' => 'Frankreich',
        'GA' => 'Gabun',
        'GD' => 'Grenada',
        'GE' => 'Georgien',
        'GF' => 'Franz&ouml;sisch Guyana',
        'GH' => 'Ghana',
        'GI' => 'Gibraltar',
        'GL' => 'Gr&ouml;nland ',
        'GM' => 'Gambia',
        'GN' => 'Guinea',
        'GP' => 'Guadeloupe',
        'GQ' => '&Auml;quatorial Guinea',
        'GR' => 'Griechenland',
        'GS' => 'S&uuml;d Georgien und Sandwich Inseln',
        'GT' => 'Guatemala',
        'GU' => 'Guam',
        'GW' => 'Guinea-Bissau',
        'GY' => 'Guyana',
        'HK' => 'Hongkong',
        'HM' => 'Heard & McDonald Inseln',
        'HN' => 'Honduras',
        'HR' => 'Kroatien ',
        'HT' => 'Haiti',
        'HU' => 'Ungarn',
        'ID' => 'Indonesien ',
        'IL' => 'Israel ',
        'IN' => 'Indien ',
        'IO' => 'Britisch Indisch Ozean Territorium',
        'IQ' => 'Iraq ',
        'IR' => 'Iran ',
        'IS' => 'Island ',
        'IT' => 'Italien',
        'JM' => 'Jamaika',
        'JO' => 'Jordanien',
        'JP' => 'Japan',
        'KE' => 'Kenia ',
        'KG' => 'Kirgisistan ',
        'KH' => 'Kambodschia',
        'KI' => 'Kiribati',
        'KM' => 'Komoren',
        'KN' => 'Sankt Kitts und Nevis',
        'KP' => 'Nordkorea',
        'KR' => 'S&uuml;dkorea',
        'KW' => 'Kuwait',
        'KY' => 'Cayman Insel',
        'KZ' => 'Kasachstan',
        'LA' => 'Laos',
        'LB' => 'Libanon',
        'LC' => 'Sankt Lucia',
        'LI' => 'Lichstenstein',
        'LK' => 'Sri Lanka',
        'LR' => 'Liberia',
        'LS' => 'Lesotho',
        'LT' => 'Litauen ',
        'LU' => 'Luxemburg',
        'LV' => 'Lettland ',
        'LY' => 'Lybien ',
        'MA' => 'Marokko',
        'MC' => 'Monaco ',
        'MD' => 'Moldavien ',
        'MG' => 'Madagaskar',
        'MH' => 'Marschall Inseln',
        'MK' => 'Mazedonien ',
        'ML' => 'Mali',
        'MM' => 'Myanmar',
        'MN' => 'Mongolei',
        'MO' => 'Macau',
        'MP' => 'N&ouml;rdlische Mariannen Inseln',
        'MQ' => 'Martinique',
        'MR' => 'Mauretanien',
        'MS' => 'Montserrat',
        'MT' => 'Malta',
        'MU' => 'Mauritius',
        'MV' => 'Malediven',
        'MW' => 'Malawi',
        'MX' => 'Mexiko',
        'MY' => 'Malaysia',
        'MZ' => 'Mosambik',
        'NA' => 'Namibia ',
        'NC' => 'Neu Kaledonien',
        'NE' => 'Niger',
        'NF' => 'Norfolk Inseln',
        'NG' => 'Nigeria',
        'NI' => 'Nicaragua',
        'NL' => 'Niederlande ',
        'NO' => 'Norwegen ',
        'NP' => 'Nepal',
        'NR' => 'Nauru',
        'NU' => 'Niue',
        'NZ' => 'Neuseeland',
        'OM' => 'Oman',
        'PA' => 'Panama',
        'PE' => 'Peru',
        'PF' => 'Franz&ouml;sisch Polynesien',
        'PG' => 'Papua Neu Guinea',
        'PH' => 'Philippinen',
        'PK' => 'Pakistan',
        'PL' => 'Polen',
        'PM' => 'Sankt Pierre und Miquelon',
        'PN' => 'Pitcairn',
        'PR' => 'Puerto Rico',
        'PS' => 'Palestina',
        'PT' => 'Portugal ',
        'PW' => 'Palau ',
        'PY' => 'Paraguay ',
        'QA' => 'Katar ',
        'RE' => 'La Réunion',
        'RO' => 'Rum&auml;nien ',
        'RU' => 'Russische F&ouml;deration ',
        'RW' => 'Ruanda',
        'SA' => 'Saudi Arabien',
        'SB' => 'Salomonen',
        'SC' => 'Seychelles',
        'SD' => 'Sudan',
        'SE' => 'Schweden ',
        'SG' => 'Singapur ',
        'SH' => 'Sankt Helena',
        'SI' => 'Slowenien ',
        'SJ' => 'Svalbard und Jan Mayen',
        'SK' => 'Slowakische Republik',
        'SL' => 'Sierra Leone',
        'SM' => 'San Marino',
        'SN' => 'Senegal',
        'SO' => 'Somalia',
        'SR' => 'Suriname',
        'ST' => 'Sao Tome und Principe',
        'SV' => 'El Salvador',
        'SY' => 'Syrien',
        'SZ' => 'Swaziland',
        'TC' => 'Turks und Caicos Inseln',
        'TD' => 'Tschad',
        'TF' => 'Franz&ouml;sische S&uuml;d Territorien',
        'TG' => 'Togo',
        'TH' => 'Thailand',
        'TK' => 'Tokelau',
        'TJ' => 'Tadschikistan',
        'TM' => 'Turkmenistan ',
        'TN' => 'Tunesien ',
        'TO' => 'Tonga ',
        'TP' => 'Ost Timor',
        'TR' => 'T&uuml;rkei',
        'TT' => 'Trinidad und Tobago',
        'TV' => 'Tuvalu',
        'TW' => 'Taiwan',
        'TZ' => 'Tanzania',
        'UA' => 'Ukraine',
        'UG' => 'Uganda',
        'UK' => 'Gro&szlig;britannien ',
        'UM' => 'Inseln der USA',
        'US' => 'USA',
        'UY' => 'Uruguay',
        'UZ' => 'Usbekistan',
        'VA' => 'Vatikan',
        'VC' => 'Sankt Vincente und Grenadinen',
        'VE' => 'Venezuela',
        'VI' => 'Virgin Inseln',
        'VN' => 'Vietnam',
        'VU' => 'Vanatua',
        'WF' => 'Wallis und Futuna',
        'WS' => 'Samoa',
        'YE' => 'Yemen',
        'YT' => 'Mayotte',
        'YU' => 'Jugoslawien',
        'ZA' => 'S&uuml;d-Afrika',
        'ZM' => 'Zambia',
        'ZW' => 'Zimbabwe',
    );

    private static $_generalProfession = array(
        KREDIT_BERUFSGRUPPE_BITTE_WAEHLEN => ' - Bitte auswählen - ',
        'Angestellte/Arbeiter' => array(
            KREDIT_BERUFSGRUPPE_ARBEITER_ANGESTELLTER => 'Arbeiter/Angestellter',
            KREDIT_BERUFSGRUPPE_ANGESTELLTER  => 'Angestellte/r',
            KREDIT_BERUFSGRUPPE_LEITENDER_ANGESTELLTER  => 'leitende/r Angestellte/r',
            KREDIT_BERUFSGRUPPE_ANGESTELLTER_OEFFENTLICHER_DIENST => 'Angest. im öffent. Dienst',
            KREDIT_BERUFSGRUPPE_ANGESTELLT_IM_AUSLAND => 'Angest. im Ausland',
            KREDIT_BERUFSGRUPPE_ARBEITER => 'Arbeiter/in',
            KREDIT_BERUFSGRUPPE_ARBEITER_OEFFENTLICHER_DIENST => 'Arbeiter/in im öffent. Dienst',
            KREDIT_BERUFSGRUPPE_FACHARBEITER => 'Facharbeiter/in',
            KREDIT_BERUFSGRUPPE_HILFSARBEITER => 'Hilfsarbeiter/in'
        ),
        'Beamte' => array(
            KREDIT_BERUFSGRUPPE_BEAMTE_HOEHERER_DIENST  => 'Beamte/r im höheren Dienst',
            KREDIT_BERUFSGRUPPE_BEAMTE_GEHOBENER_DIENST  => 'Beamte/r im gehobenen Dienst',
            KREDIT_BERUFSGRUPPE_BEAMTE_MITTLERER_DIENST  => 'Beamte/r im mittleren Dienst',
            KREDIT_BERUFSGRUPPE_BEAMTE_EINFACHER_DIENST  => 'Beamte/r im einfachen Dienst',
            KREDIT_BERUFSGRUPPE_BEAMTE => 'Beamte'
        ),
        'Selbständige' => array(
            KREDIT_BERUFSGRUPPE_SELBST_FREIBERUFLER => 'Selbst. Freiberufler',
            KREDIT_BERUFSGRUPPE_SELBST_GESCHAEFTSFUEHRER => 'Selbst. Geschäftsführer/in',
            KREDIT_BERUFSGRUPPE_SELBST_GEWERBETREIBENDER => 'Selbst. Gewerbetreibende/r',
            KREDIT_BERUFSGRUPPE_VORSTAND_GESCHAEFTSFUEHRER  => 'Vorstand/Geschäftsführer/in',
            KREDIT_BERUFSGRUPPE_SELBSTAENDIGE => 'Selbständige'
        ),
        'Ausbildung' => array(
            KREDIT_BERUFSGRUPPE_AUSZUBILDENDER => 'Auszubildende/r',
            KREDIT_BERUFSGRUPPE_SCHUELER => 'Schüler/in',
            KREDIT_BERUFSGRUPPE_STUDENT => 'Student/in'
        ),
        'Soldaten' => array(
            KREDIT_BERUFSGRUPPE_WEHRPFLICHTIGER => 'Wehrplichtige/r',
            KREDIT_BERUFSGRUPPE_SOLDAT => 'Soldat/in',
            KREDIT_BERUFSGRUPPE_SOLDAT_AUF_ZEIT  => 'Soldat/in auf Zeit',
            KREDIT_BERUFSGRUPPE_BERUFSSOLDAT  => 'Berufssoldat/in'
        ),
        'sonstige' => array(
            KREDIT_BERUFSGRUPPE_MEISTER => 'Meister',
            KREDIT_BERUFSGRUPPE_HAUSFRAU_MANN => 'Hausfrau/-mann',
            KREDIT_BERUFSGRUPPE_RENTNER => 'Rentner/in',
            KREDIT_BERUFSGRUPPE_PENSIONAER => 'Pensionär/in',
            KREDIT_BERUFSGRUPPE_ARBEITSLOS_SOLZIALHILFEEMPFAENGER => 'Arbeitslose, Sozialehilfeempfänger, ohne Beschäftigung',
            KREDIT_BERUFSGRUPPE_SONSTIGE => 'sonstige'
        )
    );

    /*
    public static $generalBusiness = array(
        KREDIT_BRANCHE_BITTE_WAEHLEN   => ' - Bitte auswählen - ',
        '01' => 'Baugewerbe',
        '02' => 'Dienstleistungen',
        '03' => 'Energie, Wasser, Bergbau',
        '04' => 'Finanzierungen/Versicherungen',
        '18' => 'Gastgewerbe',
        '06' => 'Handel',
        '07' => 'Land-/Forstwirt., Fischerei',
        '08' => 'Organisation ohne Erwerbszweck',
        '09' => 'Schwerindustrie, Chemie',
        '10' => 'Staat, oeffentlicher Dienst',
        '11' => 'Telekomm./Neue Technologien',
        '17' => 'Tourismus',
        '12' => 'Verarb. Gewerbe, Handwerk',
        '13' => 'Verkehr - Gueter, Waren',
        '14' => 'Verkehr - Personen',
        '15' => 'Zeitarbeitsfirma',
        '16' => 'keine Angabe',
        '20' => 'Sonnenstudios',
        '21' => 'Videotheken',
        '22' => 'PC-Haendler',
        '23' => 'Schausteller',
        '24' => 'Taxiunternehmer',
    );
    */

    public static $generalBranches = array(
        KREDIT_BRANCHE_BITTE_WAEHLEN => ' - Bitte auswählen - ',
        KREDIT_BRANCHE_KEINE_ANGABE  => 'keine Angabe',
        KREDIT_BRANCHE_BANKEN  => 'Banken',
        KREDIT_BRANCHE_BAUGEWERBE => 'Baugewerbe',
        KREDIT_BRANCHE_BERGBAU => 'Bergbau',
        KREDIT_BRANCHE_BUNDESWEHR => 'Bundeswehr',
        KREDIT_BRANCHE_CHEMIEINDUSTRIE => 'Chemieindustrie',
        KREDIT_BRANCHE_ENERGIE_WASSER  => 'Energie / Wasser',
        KREDIT_BRANCHE_FARB_DRUCK_PAPIERINDUSTRIE  => 'Farb-, Druck- und Papierindustrie',
        KREDIT_BRANCHE_FISCHEREI  => 'Fischerei',
        KREDIT_BRANCHE_GASTRONOMIE => 'Gastronomie',
        KREDIT_BRANCHE_GROSS_EINZELHANDEL => 'Groß- und Einzelhandel',
        KREDIT_BRANCHE_HANDWERK => 'Handwerk',
        KREDIT_BRANCHE_HOLZINDUSTRIE => 'Holzindustrie',
        KREDIT_BRANCHE_HOTELGEWERBE => 'Hotelgewerbe',
        KREDIT_BRANCHE_HUETTEN_STAHLINDUSTRIE => 'Hütten- und Stahlindustrie',
        KREDIT_BRANCHE_KFZ_HERSTELLER => 'KFZ-Hersteller',
        KREDIT_BRANCHE_KINDERGARTEN => 'Kindergärten',
        KREDIT_BRANCHE_KRANKEN_PFLEGEANSTALT => 'Kranken- und Pflegeanstalten',
        KREDIT_BRANCHE_LAND_FORSTWIRTSCHAFT => 'Land- und Forstwirtschaft',
        KREDIT_BRANCHE_METALLINDUSTRIE => 'Metallindustrie',
        KREDIT_BRANCHE_NAHRUNGS_GENUSSMITTELINDUSTRIE => 'Nahrungs- und Genußmittelindustrie',
        KREDIT_BRANCHE_OEFFENTLICHER_DIENST => 'Öffentlicher Dienst',
        KREDIT_BRANCHE_REISEWIRTSCHAFT => 'Reisewirtschaft',
        KREDIT_BRANCHE_RUNDFUNK_FERNSEHANSTALTEN => 'Rundfunk- und Fernsehanstalten',
        KREDIT_BRANCHE_SCHIFFFAHRT => 'Schifffahrt',
        KREDIT_BRANCHE_TEXTILINDUSTRIE => 'Textilindustrie',
        KREDIT_BRANCHE_VERKEHR_GUETER_WAREN => 'Verkehr Güter / Waren',
        KREDIT_BRANCHE_VERKEHR_PERSONEN => 'Verkehr Personen',
        KREDIT_BRANCHE_VERLAGS_ZEITUNGSWESEN => 'Verlags- und Zeitungswesen',
        KREDIT_BRANCHE_VERSICHERUNGEN => 'Versicherungen',
        KREDIT_BRANCHE_WALZWERKE => 'Walzwerke',
        KREDIT_BRANCHE_ZEITARBEITSFIRMA => 'Zeitarbeitsfirma',
        KREDIT_BRANCHE_SONSTIGE => 'Sonstige'
    );

    public static $generalFamily = array(
        KREDIT_FAMILIENSTAND_BITTE_WAEHLEN => 'Familienstand',
        KREDIT_FAMILIENSTAND_LEDIG  => 'ledig',
        KREDIT_FAMILIENSTAND_EHEAEHNLICHE_LEBENSGEMEINSCHAFT  => 'eheähnliche Lebensgemeinschaft',
        KREDIT_FAMILIENSTAND_VERHEIRATET  => 'verheiratet',
        KREDIT_FAMILIENSTAND_GETRENNT_LEBEND  => 'getrennt lebend',
        KREDIT_FAMILIENSTAND_VERWITWET  => 'verwitwet',
        KREDIT_FAMILIENSTAND_GESCHIEDEN  => 'geschieden'
    );

    public static $generalMonths = array(
        ''   => 'Monat',
        '1'  => 'Januar',
        '2'  => 'Februar',
        '3'  => 'März',
        '4'  => 'April',
        '5'  => 'Mai',
        '6'  => 'Juni',
        '7'  => 'Juli',
        '8'  => 'August',
        '9'  => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Dezember'
    );

    public static $generalWohneigentum = array(
        KREDIT_WOHNEIGENTUM_KEIN_WOHNEIGENTUM  => 'kein Wohneigentum',
        KREDIT_WOHNEIGENTUM_EIGENTUMSWOHNUNG  => 'Eigentumswohnung',
        KREDIT_WOHNEIGENTUM_EINFAMILIENHAUS  => 'Einfamilienhaus',
        KREDIT_WOHNEIGENTUM_MEHRFAMILIENHAUS  => 'Mehrfamilienhaus',
        KREDIT_WOHNEIGENTUM_BUERO_GESCHAEFTSGEBAEUDE  => 'Büro-/Geschäftsgebäude',
        KREDIT_WOHNEIGENTUM_VERMIETETES_WOHNEIGENTUM  => 'vermietetes Wohneigentum'
    );

    public static $generalEcCards = array(
        KREDIT_KARTENTYP_KEINE          => 'keine EC- oder Kreditkarte(n)',
        KREDIT_KARTENTYP_EC_KARTE       => 'EC-Karte(n)',
        KREDIT_KARTENTYP_KREDITKARTE    => 'Kreditkarte(n)',
        KREDIT_KARTENTYP_EC_KREDITKARTE => 'EC- und Kreditkarte(n)'
    );

    public static $generalWohnsituation = array(
        KREDIT_WOHNSITUATION_BITTE_WAEHLEN  => '',
        KREDIT_WOHNSITUATION_MIETE  => 'zur Miete',
        KREDIT_WOHNSITUATION_MIETFREI  => 'mietfrei',
        KREDIT_WOHNSITUATION_BEI_DEN_ELTERN  => 'bei den Eltern',
        KREDIT_WOHNSITUATION_WOHNEIGENTUM  => 'im Wohneigentum'
    );

    const ITEMS_PER_PAGE = 10;

    /**
     * serialisation for an array
     *
     * @param array $data the data array to be serialized as xml
     *
     * @return string
     * @access public
     * @static
     */
    public static function serializeXml($data)
    {
        $xmlString = '<result />';

        if (!is_array($data)) {
            return $xmlString;
        }

        $xmlString = self::_ia2xml($data);

        //delete line breaks and spaces
        $xmlString = self::_compress($xmlString);

        //build wanted XML
        return '<?xml version="1.0"?><result>' . $xmlString . '</result>';
    }

    /**
     * Enter description here...
     *
     * @param string $response der XML-String
     *
     * @return array|string
     * @access public
     * @static
     */
    public static function unserializeXml($response)
    {
        $values = array();

        $parser = xml_parser_create('');
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option(
            $parser,
            XML_OPTION_TARGET_ENCODING,
            'iso-8859-1'
        );

        //trim spaces and blank lines
        $response = trim($response);

        //convert to utf-8
        $response = self::encode($response, false);

        xml_parse_into_struct($parser, $response, $values);
        $error = xml_get_error_code($parser);

        if ($error) {
            //log the error
            $message = xml_error_string($error)
                     . ' in File ' . __FILE__
                     . ' on Line ' . __LINE__;

            $logger = \Zend\Registry::get('log');
            $logger->warn($message);
        }

        $return = array();
        $level  = array();

        foreach ($values as $xlmElement) {
            $extra = null;

            if ($xlmElement['type'] == 'open') {
                if (array_key_exists('attributes', $xlmElement)) {
                    list($level[$xlmElement['level']], $extra) =
                        array_values($xlmElement['attributes']);
                } else {
                    $level[$xlmElement['level']] = $xlmElement['tag'];
                }
            }
            if ($xlmElement['type'] == 'complete') {
                $startLevel = 1;
                $phpStatment = '$return';
                while ($startLevel < $xlmElement['level']) {
                    $phpStatment .= '[$level[' . $startLevel . ']]';
                    $startLevel++;
                }
                $phpStatment .= '[$xlmElement[\'tag\']] = '
                              . '((isset($xlmElement[\'value\'])) ? '
                              . '$xlmElement[\'value\'] : \'\');';

                eval($phpStatment);
            }
        }

        xml_parser_free($parser);

        $keys = array_keys($return);
        $keys = ((isset($keys[0])) ? $keys[0] : 'zend');
        $return = ((isset($return[$keys])) ? $return[$keys] : '');

        return $return;
    }

    /**
     * serialisation for an array
     *
     * @param array   $array the data array to be serialized
     * @param integer $level the nesting level
     *
     * @return string
     * @access private
     * @static
     */
    private static function _ia2xml(array $array, $level = 0)
    {
        $xml         = '';
        $secondLevel = $level + 1;

        foreach ($array as $key => $value) {
            $xml .= self::_ia2xmlSingle($key, $value, $secondLevel);
        }

        return $xml;
    }

    /**
     * serialisation for an array
     *
     * @param array   $array the data array to be serialized
     * @param integer $level the nesting level
     *
     * @return string
     * @access private
     * @static
     */
    private static function _ia2xmlSingle($key, $value, $level = 0)
    {
        if (is_string($value) && $value == '') {
            return '<' . $key . '/>';
        }

        if (is_array($value)) {
            return '<' . $key . '>' . self::_ia2xml($value, $level)
                                    . '</' . $key . '>';
        }

        if (is_object($value)) {
            return self::_ia2xmlObject($key, $value, $level);
        }

        /*
         * replace &xdash; here
         * they will cause an error, which will end the string
         */
        $value  = str_replace(array('&ndash;', '&mdash;'), '-', $value);
        $helper = new \AppCore\Controller\Helper\Decode();
        $value  = $helper->direct((string) $value, false);

        return '<' . $key . '><![CDATA[' . $value . ']]></' . $key . '>';
    }

    /**
     * serialisation for an array
     *
     * @param array   $array the data array to be serialized
     * @param integer $level the nesting level
     *
     * @return string
     * @access private
     * @static
     */
    private static function _ia2xmlObject($key, $value, $level = 0)
    {
        if (!is_object($value)) {
            return '';
        }

        $class = get_class($value);

        if ($class == 'SimplexmlElement') {
            try{
                $xml = '<' . $key . '>' . $value->asXML() . '</' . $key . '>';
            } catch (Exception $e) {
                $logger = \Zend\Registry::get('log');
                $logger->err($e);

                $xml = '';
            }
        } elseif ($class == '\AppCore\Model\CalcResult'
            || is_subclass_of($value, '\AppCore\Model\CalcResult')
        ) {
            $xml = '<' . $key . '>'
                 . self::_ia2xml($value->toArray(), $level)
                 . '</' . $key . '>';
        } else {
            $xml = '<' . $key . '>'
                 . self::_ia2xml((array) $value, $level)
                 . '</' . $key . '>';
        }

        return $xml;
    }

    /**
     * encodes an value from iso to utf-8
     *
     * @param string  $text     the string to decode
     * @param boolean $entities (Optional) an flag,
     *                          if TRUE the string will be encoded with
     *                          html_entitiy_decode
     *
     * @return string
     * @access public
     * @static
     */
    public static function encode($text, $entities = true)
    {
        if (is_string($text) && $text != '') {
            if ($entities) {
                $text = html_entity_decode(
                    $text,
                    ENT_QUOTES,
                    'iso-8859-1'
                );
            }

            $encoding = mb_detect_encoding($text . ' ', 'UTF-8,ISO-8859-1');

            if ('ISO-8859-1' == $encoding) {
                $text = utf8_encode($text);
            }
        }

        return $text;
    }

    /**
     * returns all professions
     *
     * @return array
     * @static
     */
    public static function getProfession()
    {
        return self::$_generalProfession;
    }

    /**
     * defines the Image url for an campaign or the partner portal
     *
     * @param string $paid the portal code
     * @param string $caid the campaign code
     *
     * @return void
     * @access public
     * @static
     */
    public static function defineImageUrl($paid, $caid)
    {
        clearstatcache();

        $imageUrl = \Zend\Registry::get('_imageUrlRoot');
        $baseUrl  = \Zend\Registry::get('_home') . 'kampagne/';
        $basePath = HOME_PATH . DS . 'kampagne' . DS;

        if (file_exists($basePath . $caid . DS . 'images' . DS)) {
            //Campaign
            $imageUrl = $baseUrl . $caid . '/images/';
        } elseif (file_exists($basePath . $paid . DS . 'images' . DS)) {
            //Partner
            $imageUrl = $baseUrl . $paid . '/images/';
        }

        \Zend\Registry::set('_imageUrl', $imageUrl);

        //var_dump($paid, $caid, $imageUrl, $baseUrl, $basePath);
        // get Layout
        //$layout = \Zend\Layout\Layout::getMvcInstance();

        // get view from Layout
        //$view           = $layout->getView();
        //$view->imageUrl = $imageUrl;
        
        $viewRenderer = \Zend\Controller\Action\HelperBroker::getStaticHelper(
            'ViewRenderer'
        );
        $view = $viewRenderer->view;
        $view->imageUrl = $imageUrl;
        /**/
        //exit;
    }

    /**
     * erzeugt einen GET-String aus einem assoziierten Array
     *
     * @param array   $data das assoziierte Array mit POST-Daten
     * @param boolean $int  a flag
     *                      TRUE:  the link will be coded like /key/value/
     *                      FALSE: the link will be coded like ?key=value
     *
     * @return string
     * @access private
     * @static
     */
    private static function _postToGet(array $data, $int = true)
    {
        $gp = array();

        if ($int) {
            $bindKeyToValue = '/';
            $bindValuePairs = '/';
        } else {
            $bindKeyToValue = '=';
            $bindValuePairs = '&';
        }

        if (count($data) > 0) {
            $keys = array_keys($data);

            foreach ($keys as $key) {
                $value = $data[$key];

                if (is_array($value)) {
                    $value = array_pop($value);
                }

                if (!is_array($value) && $value != '') {
                    $gp[]  = $key . $bindKeyToValue . urlencode($value);
                }
            }
        }

        $gp = implode($bindValuePairs, $gp);

        if ($int && substr($gp, -1) != '/') {
            $gp .= '/';
        }

        $gp = str_replace('//', '/', $gp);
        $gp = str_replace(':/', '://', $gp);
        $gp = str_replace(':///', '://', $gp);

        return $gp;
    }

    /**
     * erzeugt einen GET-String aus einem assoziierten Array und fügt diesen an
     * eine vorhandene URL an
     *
     * @param string  $url  die gegebene URL
     * @param array   $data assoziiertes Array zum Erstellen des GET-Strings
     * @param boolean $int  a flag
     *                      TRUE:  the link will be coded like /key/value/
     *                      FALSE: the link will be coded like ?key=value
     *
     * @return string
     * @access public
     * @static
     */
    public static function postToGetUrl($url, array $data, $int = true)
    {
        $gpUrl = $url;

        if ($int) {
            $bindPre = '/';
            $bindKeyToValue = '/';
            $bindValuePairs = '/';
        } else {
            $bindPre = '?';
            $bindKeyToValue = '=';
            $bindValuePairs = '&';
        }

        if (count($data)) {
            if (!$int && strpos($gpUrl, $bindPre) !== false) {
                $gpUrl .= $bindValuePairs;
            } else {
                $gpUrl .= $bindPre;
            }

            $gpUrl .= self::_postToGet($data, $int);

            if ($int && substr($gpUrl, -1) != '/') {
                $gpUrl .= '/';
            }
        }

        $gpUrl = str_replace('//', '/', $gpUrl);
        $gpUrl = str_replace(':/', '://', $gpUrl);
        $gpUrl = str_replace(':///', '://', $gpUrl);

        return $gpUrl;
    }

    /**
     * Die Methode erstellt URLs je nach Art der Einbindung
     *
     * @param string  $controller Name des Controllers
     * @param string  $action     Name der Action
     * @param string  $module     Name des Modules, NULL für default
     * @param array   $postData   weitere URL-Parameter
     * @param boolean $int        a flag
     *                            TRUE:  the link will be coded like /key/value/
     *                            FALSE: the link will be coded like ?key=value
     * @param string  $url        url-Prefix
     *
     * @access public
     * @return String Fertige URL
     * @static
     */
    public static function buildURL(
        $controller,
        $action,
        $module = null,
        array $postData = array(),
        $int = true,
        $url = '')
    {
        $url = \Zend\Registry::get('_urlDir');

        if ($int
            || $controller == 'Hilfe'
            || \Zend\Registry::get('_urlType') == 'INT'
        ) {
            $url .= '/'
                  . (($module !== null) ? $module . '/' : '')
                  . $controller
                  . '/'
                  . $action;
        } else {
            $url .= (($url != '') ? '/' . $url : '')
                  . '?'
                  . (($module !== null) ? 'module=' . $module . '&' : '')
                  . 'controller='
                  . $controller
                  . '&action='
                  . $action;
        }

        $url = self::postToGetUrl($url, $postData, $int);

        if ($int && substr($url, -1) != '/') {
            $url .= '/';
        }

        return $url;
    }

    /**
     * liefert die microtime
     *
     * @return float
     * @access public
     * @static
     */
    public static function microtimeFloat()
    {
        if (version_compare(PHP_VERSION, '5.0.0', '>')) {
            return microtime(true);
        } else {
            list($usec, $sec) = explode(' ', microtime());
            return ((float) $usec + (float) $sec);
        }
    }

    /**
     * öffnet eine Datei und erstellt der Pfad, falls der Pfad nicht existiert
     *
     * @param string  $path  der Pfad, in dem die Datei geöffnet/erstellt werden
     *                       soll
     * @param string  $mode  der Mode, mit dem die Datei geöffnet werden soll
     *                       see {@link fopen} for more details
     * @param integer $chmod Modus
     *
     * @return FALSE|file the file resource, if the opening succeded, FALSE
     *                    otherwise
     * @access public
     * @static
     */
    public static function fopenRecursive($path, $mode, $chmod = 0777)
    {
        $matches = array();

        preg_match('`^(.+)/([a-zA-Z0-9_]+\.[a-z]+)$`i', $path, $matches);

        if (count($matches) < 3) {
            //Datei- /Verzeichnis-Name entspricht nicht dem Vorgabe-Schema
            return false;
        }

        $directory = $matches[1];

        if (!is_dir($directory)) {
            //Verzeichnis existiert nicht
            if (!mkdir($directory, $chmod, 1)) {
                /*
                 * Verzeichnis konnte nicht mit den gewünschten Rechten erstellt
                 * werden
                 */
                return false;
            } else {
                exec('chmod -R $chmod $directory');
            }
        }

        return fopen($path, $mode);
    }

    /**
     * formatiert ein Datum
     *
     * @param string $day   der Tag des Datums
     * @param string $month der Monat des Datums
     * @param string $year  das Jahr des Datums
     *
     * @return string
     * @access public
     * @static
     */
    public static function formatDate($day, $month, $year)
    {
        $day   = substr('0' . $day, -2);
        $month = substr('0' . $month, -2);

        $date = $day . '.' . $month . '.' . $year;

        return $date;
    }

    /**
     * updates an User Agent into Database
     *
     * @param string $useragent   the user agent string
     *
     * @return \\AppCore\\Model\Browser object
     * @access public
     * @static
     */
    public static function updateAgent($useragent)
    {
        $browscap = new KreditCore_Class_Browscap();

        /**
         * @var stdClass
         */
        $browser = $browscap->getBrowser($useragent, false);

        $browserModel = new \AppCore\Model\Browser();
        $oBrowser     = $browserModel->searchByBrowser(
            ((isset($browser->Browser)) ? $browser->Browser : ''),
            ((isset($browser->Version)) ? $browser->Version : ''),
            ((isset($browser->Platform)) ? $browser->Platform : '')
        );

        if (null === $oBrowser) {
            //user agent not available yet
            $oBrowser = $browserModel->createRow();
            $oBrowser->setFromArray((array) $browser);
            $oBrowser->save();
        }

        return $oBrowser;
    }

    /**
     * checks if an IP adress should be blocked
     *
     * @param string $ip the IP address
     *
     * @return boolean
     * @access public
     * @static
     */
    public static function isBlocked($ip)
    {
        $blockedIps = array('83.79.54.159');

        if (in_array($ip, $blockedIps)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * checks if an IP adress is used for testing
     *
     * @param string $ip the IP address
     *
     * @return boolean
     * @access public
     * @static
     */
    public static function isTest($ip)
    {
        $testIps = array('');

        if (in_array($ip, $testIps)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * returns the Name/Label for an ID of an Prefession
     *
     * @param integer $berufsgruppe (optional) the profession ID
     *
     * @return string|array if $berufsgruppe is null, all professions will be
     *                      returned
     * @access public
     * @static
     */
    public static function getBerufsgruppe(
        $berufsgruppe = null, $asArray = false)
    {
        if (null !== $berufsgruppe) {
            $berufsgruppe = (int) $berufsgruppe;
        }

        $b      = self::$_generalProfession;
        $berufe = array();
        foreach ($b as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $key => $valueTwo) {
                    $berufe[$key] = $valueTwo;
                }
            } else {
                $berufe[$key] = $value;
            }
        }

        if (null === $berufsgruppe) {
            $berufsgruppeLabel = $berufe;
        } elseif (isset($berufe[$berufsgruppe]) && $asArray) {
            $berufsgruppeLabel = array($berufsgruppe => $berufe[$berufsgruppe]);
        } elseif (isset($berufe[$berufsgruppe])) {
            $berufsgruppeLabel = $berufe[$berufsgruppe];
        } elseif ($asArray) {
            $berufsgruppeLabel = array('' => 'Sonstiges');
        } else {
            $berufsgruppeLabel = 'Sonstiges';
        }

        return $berufsgruppeLabel;
    }

    /**
     * returns the Name/Label for an ID of an Prefession
     *
     * @param integer $familyState (optional) die ID des Familienstandes
     *
     * @return string
     * @access public
     * @static
     */
    public static function getFamilyState(
        $familyState = KREDIT_FAMILIENSTAND_BITTE_WAEHLEN)
    {
        $familyState = (int) $familyState;
        $b           = self::$generalFamily;

        if (KREDIT_FAMILIENSTAND_BITTE_WAEHLEN == $familyState
            || !isset($b[$familyState])
        ) {
            return '';
        } else {
            return $b[$familyState];
        }
    }

    /**
     * returns the Name/Label for an ID of an Prefession
     *
     * @param integer $state (optional) eine ID
     *
     * @return string
     * @access public
     * @static
     */
    public static function getWohnsituation(
        $state = KREDIT_WOHNSITUATION_BITTE_WAEHLEN)
    {
        $state = (int) $state;

        $b = self::$generalWohnsituation;

        if (KREDIT_WOHNSITUATION_BITTE_WAEHLEN == $state
            || !isset($b[$state])
        ) {
            return '';
        } else {
            return $b[$state];
        }
    }

    /**
     * returns the Name/Label for an ID of an Prefession
     *
     * @param integer $state (optional) eine ID
     *
     * @return string
     * @access public
     * @static
     */
    public static function getBranche($state = KREDIT_BRANCHE_BITTE_WAEHLEN)
    {
        $state = (int) $state;

        $b      = self::$generalBranches;

        if (KREDIT_BRANCHE_BITTE_WAEHLEN == $state
            || !isset($b[$state])
        ) {
            return '';
        } else {
            return $b[$state];
        }
    }

    /**
     * returns the Name/Label for an ID of an Prefession
     *
     * @param integer $state (optional) eine ID
     *
     * @return string
     * @access public
     * @static
     */
    public static function getWohneigentum(
        $state = KREDIT_WOHNEIGENTUM_KEIN_WOHNEIGENTUM)
    {
        $state = (int) $state;

        $b = self::$generalWohneigentum;

        if (!isset($b[$state])) {
            $state = KREDIT_WOHNEIGENTUM_KEIN_WOHNEIGENTUM;
        }

        return $b[$state];
    }

    /**
     * defines an array of years
     *
     * @return array
     */
    public static function wohnhaftSeitJ()
    {
        $yearRange = range(
            \Zend\Date\Date::now()->toString('Y', 'php'),
            \Zend\Date\Date::now()->subYear(50)->toString('Y', 'php')
        );

        $years = array_combine($yearRange, $yearRange);
        return array('' => 'Jahr') + $years;
    }

    /**
     * logs an request into the database
     *
     * @param integer $requestId   The Id of the stored request
     * @param integer $productId   The product
     * @param string  $institut    The selected institute
     * @param string  $lnktype     The type of the request
     * @param integer $betrag      The amount for the calculation
     * @param integer $laufzeit    The timespan for the calculation
     * @param integer $zweck       The usage for the calculation
     * @param integer $partnerId   The Id for the campaign of the request
     * @param integer $sparteId    The sparte for the calculation
     * @param integer $agentId     The Id for the user agent
     * @param boolean $spider      The user is a spider
     * @param boolean $crawler     The user is a crawler (bad spider)
     * @param array   $requestData ??
     * @param integer $isTest      ??
     *
     * @return boolean
     * @access public
     * @static
     */
    public static function log(
        $requestId,
        $productId,
        $institut,
        $lnktype,
        $betrag,
        $laufzeit,
        $zweck,
        $campaignId,
        $sparteId,
        $agentId,
        $spider = false,
        $crawler = false,
        array $requestData = array(),
        $isTest = 0)
    {
        return true;
        
        /*
         * do not log anything while testing
         * -> causes errors when using sqlite (on clause)
         */
        if (APPLICATION_ENV == SERVER_ONLINE_TEST
            || APPLICATION_ENV == SERVER_ONLINE_TEST2
        ) {
            return true;
        }

        $modelInstitute = new \AppCore\Service\Institute();
        $instituteId    = $modelInstitute->getId($institut);
        $instituteName  = $institut;

        //ID des Browsers wird in Variable $agentId übergeben
        if (is_numeric($agentId) && 0 < $agentId) {
            self::_logAgentId(null, $agentId, $campaignId);
        }

        //Link-Typ auf neue Werte umschreiben
        $lnktype = self::_cleanLnkType($lnktype);

        if ($instituteId) {
            $modelCampaign = new \AppCore\Service\Campaigns();
            $paid          = null;
            $hostname      = null;
            $sparteName    = null;
            $isActive      = true;

            $ok = $modelCampaign->loadCaid(
                $campaignId,
                array(),
                '',
                $paid,
                $campaignId,
                $hostname,
                $isTest
            );

            /*
             * campaign missing or deactivated
             */
            if (!$ok) {
                $isActive = false;
            }
            
            if ($isActive && $productId) {
                $instituteName = null;
                $modelProduct  = new \AppCore\Service\Products();

                $isActive = $modelProduct->lade(
                    $productId, $instituteName, $sparteName
                );
            }
            
            if ($crawler) {
                $instituteName .= '-BADSPIDER';
            } elseif ($spider) {
                $instituteName .= '-SPIDER';
            }

            if (!$isActive) {
                $instituteName .= '-INACTIVE';
            } else {
                $modelUrl = new \AppCore\Model\Url();
                $url      = $modelUrl->getFromProduct($productId, $campaignId);
                $internal = false;

                $campaign = $modelCampaign->find($campaignId)->current();

                if ($campaign->externalLinks == 'intern') {
                    $internal = true;
                } elseif ($campaign->externalLinks == 'auto'
                    && null !== $url
                    && isset($url->internal)
                    && $url->internal
                ) {
                    $internal = true;
                }

                if ($internal) {
                    $instituteName .= '-INTERNAL';
                }

                if (null !== $url
                    && isset($url->teaser)
                    && $url->teaser
                ) {
                    $instituteName .= '-TEASER';
                }
            }
        }

        $modelInstitut = new \AppCore\Model\InstituteLog();
        $institut      = $modelInstitut->getId($instituteName);
        
        if (false === $institut) {
            /*
             * the institute-flag-combination was not found in the database
             */
            $data = array(
                'name' => $instituteName,
                'idInstitutes'    => $instituteId ? $instituteId : null
            );
            
            $institut = (int) $modelInstitut->insert($data);
        }

        $modelTypes = new \AppCore\Model\Types();
        $lnktype    = $modelTypes->getId($lnktype);
        
        /*
        //Statistik loggen
        self::_logDatasetStatistikEinfach(
            $lnktype,
            $institut,
            $campaignId,
            $sparteId,
            $betrag,
            $laufzeit
        );

        self::_logDatasetStatistik(
            $lnktype,
            $institut,
            $campaignId,
            $betrag,
            $zweck,
            $sparteId,
            $laufzeit
        );

        self::_logRequest(
            $requestId,
            $campaignId,
            $lnktype,
            $sparteId,
            $betrag,
            $laufzeit,
            $institut,
            $zweck,
            $requestData
        );
        /**/
        return true;
    }

    /**
     * reset the value to another value
     *
     * @param sring $lnktype the old value to be checked
     *
     * @return string the replaces value
     * @deprecated
     */
    private static function _cleanLnkType($lnktype)
    {
        switch (true) {
            case substr($lnktype, 0, 8) == 'clickout':
                // Break intentionally omitted
            case substr($lnktype, 0, 6) == 'antrag':
                // Break intentionally omitted
            case $lnktype == 'info':
                // Break intentionally omitted
            case $lnktype == 'sale':
                return $lnktype;
                break;
            case $lnktype == 'abschluss':
                return 'sale';
                break;
            case $lnktype == 'clickout (info)':
                // Break intentionally omitted
            case $lnktype == 'info_antrag':
                return 'clickout';
                break;
            default:
                return 'pageimpression';
                break;
        }
    }

    /**
     * Enter description here...
     *
     * @param integer $agentId    the Id for the user agent
     * @param integer $browserId  the Id for the Browser
     * @param integer $campaignId the Id for the camapign
     * @param string  $from       status
     *
     * @return void
     * @access private
     * @static
     */
    private static function _logAgentId(
        $agentId, $browserId, $campaignId, $from = 'C')
    {
        try {
            $db = \Zend\Db\Table\AbstractTable::getDefaultAdapter();
            
            $sql = 'INSERT INTO `logAgent` '
                 . '(`idBrowsers`,`idCampaigns`,`date`,`amount`) VALUES '
                 . '(\'' . (int) $browserId . '\',\''
                 . (int) $campaignId . '\', CURDATE(), 1)'
                 . ' ON DUPLICATE KEY UPDATE `amount`=`amount`+1';

            $db->query($sql);
            /**/
        } catch (Exception $e) {
            $logger = \Zend\Registry::get('log');
            $logger->err($e);
        }
    }

    /**
     * schreibt Logging-Daten in die Datenbank-Tabellen 'stat_einfach'
     *
     * @param mixed   $type      ??
     * @param string  $institut  ??
     * @param integer $partnerId ??
     * @param integer $sparte    ??
     * @param integer $betrag    ??
     * @param integer $laufzeit  ??
     *
     * @return void
     * @access private
     * @static
     */
    private static function _logDatasetStatistikEinfach(
        $type, $institut, $partnerId, $sparte, $betrag, $laufzeit)
    {
        /*
         * do not log statistik while testing
         * -> causes errors when using sqlite (on clause)
         */
        if (APPLICATION_ENV == SERVER_ONLINE_TEST
            || APPLICATION_ENV == SERVER_ONLINE_TEST2
        ) {
            return;
        }

        $provision = 0;

        $produktModel = new \AppCore\Model\Products();
        $outerSelect  = $produktModel->select();

        $institutModel   = new \AppCore\Model\InstituteLog();
        $instituteSelect = $institutModel->select();
        $instituteSelect->from(
            array('ifl' => 'institutesForLog'),
            array('ifl.idInstitutes')
        );
        $instituteSelect->where('`ifl`.`idInstitutesForLog` = ? ', $institut);

        $componentModel  = new \AppCore\Model\Products();
        $componentSelect = $componentModel->select()->setIntegrityCheck(false);
        $componentSelect->from(
            array('pc' => 'produkt_components'),
            array('pc.idProducts')
        );
        $componentSelect->where('`pc`.`idCategories` = ? ', $sparte);

        if ($type == KREDIT_LOG_SALE) {
            $outerSelect->from(
                array('p' => 'Products'),
                array('provision' => 'provisionSale')
            );
            $outerSelect->where(
                '`p`.`idInstitutes` = ( ? ) ', $instituteSelect->assemble()
            );
            $outerSelect->where(
                '`p`.`idProducts` IN ( ? ) ', $componentSelect->assemble()
            );

            $row = $produktModel->fetchRow($outerSelect);

            if (false !== $row && isset($row->provision)) {
                $provision = (float) $row->provision;
            }
        } elseif ($type == KREDIT_LOG_CLICKOUT
            || $type == KREDIT_LOG_CLICKOUT_INFO
        ) {
            $outerSelect->from(
                array('p' => 'Products'),
                array('provision' => 'provisionClick')
            );
            $outerSelect->where(
                '`p`.`idInstitutes` = ( ? ) ', $instituteSelect->assemble()
            );
            $outerSelect->where(
                '`p`.`idProducts` IN ( ? ) ', $componentSelect->assemble()
            );

            $row = $produktModel->fetchRow($outerSelect);

            if (false !== $row && isset($row->provision)) {
                $provision = (float) $row->provision;
            }
        } else {
            $betrag   = 0;
            $laufzeit = 0;
        }

        $sql = 'INSERT INTO `stat_einfach` (`datum`,`id_type`,`idInstitutesForLog`,'
             . '`idCampaigns`,`idCategories`,`anzahl`,`sum`,`lz`,`pr`) VALUES '
             . '(NOW(), \'' . $type . '\', \'' . $institut . '\', \''
             . $partnerId . '\',\'' . $sparte . '\',1,' . $betrag . ','
             . $laufzeit . ',' . $provision . ') '
             . 'ON DUPLICATE KEY UPDATE `anzahl`=`anzahl` + 1,`sum`=`sum` + '
             . $betrag . ', `lz`=`lz` + ' . $laufzeit
             . ',`pr`=`pr`+ ' . $provision;

        try {
            $db = \Zend\Db\Table\AbstractTable::getDefaultAdapter();
            $db->query($sql);
        } catch (Exception $e) {
            $logger = \Zend\Registry::get('log');
            $logger->err($e);
        }
    }

    /**
     * Enter description here...
     *
     * @return void
     * @access private
     */
    private static function _logRequest(
        $requestId,
        $partnerId,
        $type,
        $sparte,
        $betrag,
        $laufzeit,
        $institut,
        $zweck,
        array $requestData = array())
    {
        $referrerClient = strtolower(
            self::getParamFromArray(
                $requestData, 'referer', ''
            )
        );

        $referrerServer = self::getParamFromArray(
            $_SERVER, 'HTTP_REFERER', ''
        );

        $ipClient = self::getParamFromArray(
            $requestData, 'IP', '00.00.00.00'
        );

        $ipServer = self::getParamFromArray(
            $_SERVER, 'REMOTE_ADDR', '0.0.0.0'
        );

        $serverAgentId = self::getParamFromArray(
            $requestData, 'agentIdServer', 'NULL'
        );

        $clientAgentId = self::getParamFromArray(
            $requestData, 'agentIdClient', 'NULL'
        );

        $sql = 'INSERT INTO `log_requests` (`requestId`,`idCampaigns`,'
             . '`id_type`,`idCategories`,`betrag`,`laufzeit`,`idInstitutesForLog`,`zweck`,'
             . '`server_ip`,`client_ip`,`client_agent_id`,`server_agent_id`,'
             . '`client_referrer`,`server_referrer`) '
             . 'VALUES (\'' . $requestId . '\',\'' . $partnerId . '\','
             . '\'' . $type . '\',\'' . $sparte . '\',\'' . $betrag . '\','
             . '\'' . $laufzeit . '\',\'' . $institut . '\',\'' . $zweck . '\','
             . '\'' . $ipServer . '\',\'' . $ipClient . '\','
             . (int) $clientAgentId . ',' . (int) $serverAgentId . ','
             . '\'' . $referrerClient . '\',\'' . $referrerServer . '\')';

        try {
            $db = \Zend\Db\Table\AbstractTable::getDefaultAdapter();
            $db->query($sql);
        } catch (Exception $e) {
            $logger = \Zend\Registry::get('log');
            $logger->err($e);
        }
    }
    /**/

    /**
     * schreibt Logging-Daten in die Datenbank-Tabellen "kredit_statistik"
     *
     * @param mixed   $type      ??
     * @param string  $institut  ??
     * @param integer $partnerId ??
     * @param integer $betrag    ??
     * @param integer $zweck     ??
     * @param integer $sparte    ??
     * @param integer $laufzeit  ??
     *
     * @return void
     * @access private
     * @static
     */
    private static function _logDatasetStatistik(
        $type, $institut, $partnerId, $betrag, $zweck, $sparte, $laufzeit)
    {
        $sql = 'INSERT INTO `kredit_statistik` (`betrag`,`idInstitutesForLog`,'
             . '`idCampaigns`,`zweck`,`id_type`,`laufzeit`,`idCategories`,`zeit`,'
             . '`anzahl`) VALUES (\'' . $betrag . '\',\'' . $institut . '\','
             . '\'' . $partnerId . '\',\'' . $zweck . '\',\'' . $type . '\','
             . '\'' . $laufzeit . '\',\'' . $sparte . '\','
             . 'NOW(),1) '
             . 'ON DUPLICATE KEY UPDATE `anzahl`=`anzahl`+1';

        try {
            $db = \Zend\Db\Table\AbstractTable::getDefaultAdapter();
            $db->query($sql);
        } catch (Exception $e) {
            $logger = \Zend\Registry::get('log');
            $logger->err($e);
        }
    }

    /**
     * checkt die Partner-ID
     *
     * @param mixed $value der Wert, der geprüft werden soll
     *
     * @return boolean
     * @access public
     */
    public static function checkPaid($value)
    {
        $modelCampaign = new \AppCore\Service\Campaigns();

        if (is_numeric($value)) {
            $needClean = false;
        } else {
            $needClean = true;
        }

        if ($modelCampaign->checkCaid($value, $needClean)) {
            return true;
        }

        $modelPortal = new \AppCore\Service\PartnerSites();

        return $modelPortal->checkPaid($value);
    }

    /**
     * lädt die Partner/Campaign-ID
     *
     * @param mixed $value die Partner/Campaign-ID
     *
     * @return void
     * @access public
     * @static
     */
    public static function loadPaid(
        $value, array $requestData, &$paid, &$caid, &$hostName)
    {
        $agent = ((isset($_SERVER['HTTP_USER_AGENT']))
               ? trim($_SERVER['HTTP_USER_AGENT'])
               : '');

        $model  = new \AppCore\Service\Campaigns();
        $model->loadCaid(
            $value,
            $requestData,
            $agent,
            $paid,
            $caid,
            $hostName
        );
    }

    /**
     * liefert die beforzugte Laufzeit für eine Sparte
     *
     * @param string $sparte der Name der Sparte
     *
     * @return integer
     * @access public
     * @static
     */
    public static function getDefaultLaufzeit($sparte)
    {
        $model  = new \AppCore\Model\Sparten();

        return $model->getDefaultLaufzeit($sparte);
    }

    /**
     * reduces the size of a string by deleting spaces
     *
     * @param string  $text the content to compress
     *
     * @return string the formated output
     * @access private
     * @static
     */
    private static function _compress($text)
    {
        $text = str_replace(array("\r\n", "\r", "\n", "\t"), ' ', $text);
        $text = str_replace('&nbsp;', ' ', $text);
        $text = preg_replace('/\s\s+/', ' ', $text);
        $text = str_replace('> <', '><', $text);
        $text = trim($text);

        return $text;
    }

    /**
     * sends an Email within the mailquere
     *
     * @param string  $email   die E-Mail-Adresse des Empfängers
     * @param string  $text    der Mail-Content im Text-Format
     * @param string  $html    der Mail-Content im HTML-Format
     * @param array   $cc      die CC-EMail-Adressen
     * @param array   $bcc     die BCC-EMail-Adressen
     * @param string  $subject das Subjekt der E-Mail
     *
     * @return boolean FALSE, if the sending failed, TRUE otherwise
     * @access public
     * @static
     */
    public static function sendMail(
        $email = '',
        $text = '',
        $html = '',
        $cc = array(),
        $bcc = array(),
        $subject = '',
        $from = array())
    {
        if (!\Zend\Registry::isRegistered('_config')) {
            /*
             * _config is not defined at the moment
             * the error occured before finishing bootstrapping
             */
            return false;
        }

        $config = \Zend\Registry::get('_config');

        //check, if Email is enabled
        //-> do not try to send, if disabled (mostly it raises errors then)
        if (!isset($config->newmaildb->enabled)
            || !$config->newmaildb->enabled
        ) {
            return false;
        }

        //serialize the mail headers
        if (!is_array($email)) {
            $email = array($email);
        }

        if (!is_array($cc)) {
            if ($cc !== null) {
                $cc = array($cc);
            } else {
                $cc = array();
            }
        }

        if (!is_array($bcc)) {
            if ($bcc !== null) {
                $bcc = array($bcc);
            } else {
                $bcc = array();
            }
        }

        //$bcc[] = 'debug@geld.de';

        $fromName  = 'GELD.de-Service Kredite';
        $fromEmail = 'kredit@geld.de';

        //overwrite the default sender, if another one is set
        if (is_array($from)) {
            if (isset($from['name'])) {
                $fromName  = $from['name'];
            }

            if (isset($from['email'])) {
                $fromEmail = $from['email'];
            }
        }

        $mail = new KreditCore_Class_Mail();
        $mail->setSubject(urldecode($subject))
            ->setText(urldecode($text))
            ->setHtml(urldecode($html))
            ->setFromMail($fromEmail)
            ->setFromName($fromName)
            ->setReplyTo($fromEmail)
            ->setCC($cc)
            ->setBCC($bcc)
            ->setPrio(3)
            ->setPortal('geld.de');

        $count = count($email);
        $pass  = array();

        foreach ($email as $emailAdress) {
            /*
             * TODO: rewrite to use Zend_Mail with a Mail_Transport Object for
             * the MailQuere
             */

            $mail->setEmail($emailAdress);

            /*
             * speichern der mail
             * rueckgabe ist ein array mit:
             * 'Insert'=>true, bei erfolgreichen insert
             * oder
             * 'Parameter' => 'Fehlernachricht'
             */
            if ($mail->send()) {
                $pass[] = 1;
            } else {
                $message = 'eMail konnte nicht versandt werden an '
                         . $emailAdress;

                $logger = \Zend\Registry::get('log');
                $logger->warn($message);
            }
        }

        return (count($pass) == $count);
    }

    /**
     * build a one dimensioned array from an multi dimensioned array
     *
     * @param array  $data      the multi dimensioned array
     * @param string $masterKey the name of a master key
     *
     * @return array
     */
    public static function combineArrayKeys(array $data, $masterKey = null)
    {
        $newData = array();

        foreach ($data as $key => $value) {
            $newKey = ((is_null($masterKey)) ? '' : $masterKey . '.') . $key;

            if (is_array($value)) {
                foreach ($value as $keyTwo => $valueTwo) {
                    if (is_array($valueTwo)) {
                        $newData = array_merge(
                            $newData,
                            self::combineArrayKeys($value, $newKey)
                        );
                    } else {
                        $newData[$newKey . '.' . $keyTwo] = $valueTwo;
                    }
                }
            } else {
                $newData[$newKey] = $value;
            }
        }

        return $newData;
    }

    /**
     * erstellt eine CSV-Datei aus den Antragsdaten
     *
     * @param array     $rData      die Daten des Antragsstellers
     * @param integer   $reportNr   die ID des Antragsdatensatzes
     * @param string    $creditLine der Typ der Kredit-Linie
     * @param \Zend\View\View &$view      ein \Zend\View\View-Object zum Rendern der Emails
     *
     * @return string
     */
    private static function _mapXmlData($key, $value)
    {
        $key = strtolower($key);

        switch ($key) {
            case 'berufsgruppe':
                // Break intentionally omitted
            case 'berufsgruppe1':
                return self::getBerufsgruppe($value);
                break;
            case 'probezeit':
                if (is_numeric($value)) {
                    if ($value) {
                        return 'beendet';
                    } else {
                        return 'nicht beendet';
                    }
                } elseif (is_string($value)) {
                    return $value;
                } else {
                    return 'nicht beendet';
                }
                break;
            case 'gebdatum':
                $datum = explode('.', $value);
                return array(
                    'tag' => $datum[0],
                    'monat' => $datum[1],
                    'jahr' => $datum[2],
                    'komplett' => $value
                );
                break;
            case 'aufenthaltsgenehmigung':
                if ($value) {
                    return 'aufenthaltsgenehmigung nicht befristet';
                } else {
                    return 'aufenthaltsgenehmigung befristet';
                }
                break;
            case 'arbeitserlaubnis':
                if ($value) {
                    return 'arbeitserlaubnis nicht befristet';
                } else {
                    return 'arbeitserlaubnis befristet';
                }
                break;
            case 'wehrdienst':
                if ($value) {
                    return 'wehrdienst geleistet';
                } else {
                    return 'wehrdienst nicht geleistet';
                }
                break;
            case 'familie':
                return self::getFamilyState($value);
                break;
            case 'wohneigentum':
                return self::getWohneigentum($value);
                break;
            case 'wohnsituation':
                return self::getWohnsituation($value);
                break;
            case 'branche':
                return self::getBranche($value);
                break;
            case 'hatec':
                switch ($value) {
                    case 'ec':
                        return 'EC-Karte(n)';
                        break;
                    case 'kk':
                        return 'Kreditkarte(n)';
                        break;
                    case 'eckk':
                        return 'EC- und Kreditkarte(n)';
                        break;
                    default:
                        return 'keine EC- oder Kreditkarte(n)';
                        break;
                }
                break;
            case 'restschuld':
                switch ((int) $value) {
                    case 1:
                        return 'Restschuldversicherung bei Tod';
                        break;
                    case 2:
                        return 'Restschuldversicherung bei Tod und ' .
                               'Arbeitsunfähigkeit';
                        break;
                    case 3:
                        return 'Restschuldversicherung bei Tod, ' .
                               'Arbeitsunfähigkeit und Arbeitslosigkeit';
                        break;
                    case 0:
                        // Break intentionally omitted
                    default:
                        return 'keine Restschuldversicherung gewünscht';
                        break;
                }
                break;
            case 'mehrantrag':
                return (($value)
                    ? 'Anträge bei weiteren Instituten gewünscht'
                    : 'Anträge bei weiteren Instituten nicht gewünscht');
                break;
            case 'datumeinzug':
                return 'Einzug am ' . $value . '. des Monats';
                break;
            case 'hatpkw':
                // Break intentionally omitted
            case 'hatkrad':
                // Break intentionally omitted
            case 'arbefristet':
                // Break intentionally omitted
            case 'agbeinv':
                // Break intentionally omitted
            case 'gemeinsamerhaushalt':
                // Break intentionally omitted
            case 'gleicheadresse':
                // Break intentionally omitted
            case 'test':
                // Break intentionally omitted
            case 'gleicherkontakt':
                return (($value) ? 'JA' : 'NEIN');
                break;
            case 'anzkkg':
                // Break intentionally omitted
            case 'kinderhaushalt':
                // Break intentionally omitted
            case 'personenhaushalt':
                return (int) $value;
                break;
            case 'vzweck':
                // Break intentionally omitted
            case 'zweck':
                switch ((int) $value) {
                    case KREDIT_VERWENDUNGSZWECK_PKW_NEUKAUF:
                        return 'PKW Neukauf';
                        break;
                    case KREDIT_VERWENDUNGSZWECK_PKW_GEBRAUCH:
                        return 'PKW gebraucht';
                        break;
                    case KREDIT_VERWENDUNGSZWECK_MOEBEL_RENOVIERUNG:
                        return 'Möbel, Renovierung';
                        break;
                    case KREDIT_VERWENDUNGSZWECK_URLAUB:
                        return 'Urlaub';
                        break;
                    case KREDIT_VERWENDUNGSZWECK_PC_TV_HIFI_VIDEO:
                        return 'PC, TV, Hifi, Video';
                        break;
                    case KREDIT_VERWENDUNGSZWECK_KREDIT_ABLOESEN:
                        return 'Ablösung anderer Kredite';
                        break;
                    case KREDIT_VERWENDUNGSZWECK_AUSGLEICH_GIROKONTO:
                        return 'Ausgleich Girokonto';
                        break;
                    case KREDIT_VERWENDUNGSZWECK_SONSTIGES:
                        // Break intentionally omitted
                    default:
                        return 'Sonstiges';
                        break;
                }
                break;
            case 'dreimonate':
                if ($value) {
                    return 'länger als 3 Monate';
                } else {
                    return 'noch nicht 3 Monate';
                }
                break;
            case 'paid':
                $campaignModel = new \AppCore\Service\Campaigns();
                $campaignId    = $campaignModel->getId($value);
                return $campaignModel->find($campaignId)->current()->name;
                break;
            default:
                return $value;
                break;
        }
    }

    /**
     * erstellt eine CSV-Datei aus den Antragsdaten
     *
     * @param array     $rData      die Daten des Antragsstellers
     * @param integer   $reportNr   die ID des Antragsdatensatzes
     * @param string    $creditLine der Typ der Kredit-Linie
     * @param \Zend\View\View $view       ein \Zend\View\View-Object zum Rendern der Emails
     *
     * @return string
     * @access private
     */
    public static function createXML(
        array $rData = array(),
        $reportNr = null,
        $creditLine = 'oneStep',
        \Zend\View\View $view = null)
    {
        /*
        if ($reportNr === null) {
            return '';
        }
        */

        $data = array();
        $keys = array_keys($rData);

        foreach ($keys as $key) {
            $value = $rData[$key];
            $key   = strtolower($key);

            if (isset($data[$key])) {
                continue;
            }

            switch ($key) {
                case 'kn1':
                    // Break intentionally omitted
                case 'kn2':
                    if (!is_array($value)) {
                        continue;
                    }

                    $keysTwo = array_keys($value);

                    foreach ($keysTwo as $k) {
                        $v = $value[$k];
                        $k = strtolower($k);

                        if (isset($data[$key][$k])) {
                            continue;
                        }

                        $data[$key][$k] = self::_mapXmlData($k, $v);
                    }
                    break;
                default:
                    $data[$key] = self::_mapXmlData($key, $value);
                    break;
            }
        }

        $view->reportNr = $reportNr;
        $view->uuid     = time() . '_' . substr(md5(microtime(true)), 0, 2);
        $view->rData    = $data;

        $view->kreditArten = array(
            KREDIT_KREDITART_KONSUMERKREDIT => 'Konsumentenkredit',
            KREDIT_KREDITART_RAHMENKREDIT => 'Rahmenkredit',
            KREDIT_KREDITART_ABRUFKREDIT => 'Abrufkredit',
            KREDIT_KREDITART_DISPOSITIONSKREDIT => 'Dispositionskredit',
            KREDIT_KREDITART_KREDITKARTE => 'Kreditkarte',
            KREDIT_KREDITART_AUTOKREDIT => 'Autokredit',
            KREDIT_KREDITART_LEASING => 'Leasing',
            KREDIT_KREDITART_ARBEITGEBERDARLEHEN => 'Arbeitgeberdarlehen',
            KREDIT_KREDITART_NULL_PROZENT_FINANZIERUNG => '0%-Finanzierung'
        );

        $xmlTemplate = 'mail/xml.phtml';

        if ('long' == $creditLine) {
            $xmlTemplate = 'mail/xml-long.phtml';
            /*
            if ($this->_checkForGoodBoni()) {
                $xmlTemplate = 'mail/xml-short.phtml';
            }
            */
        } elseif ('short' == $creditLine) {
            $xmlTemplate = 'mail/xml-short.phtml';
        }

        $xml = $view->render($xmlTemplate);

        return $xml;
    }
}