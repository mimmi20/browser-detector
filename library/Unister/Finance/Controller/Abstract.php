<?php
require_once LIB_PATH . 'Zend' . DS . 'Controller' . DS . 'Action.php';
require_once LIB_PATH . 'Unister' . DS . 'Acl.php';
require_once MODEL_PATH . 'Navigation.php';
require_once MODEL_PATH . 'Datensatz.php';
require_once LIB_PATH . 'Unister' . DS . 'Auth' . DS . 'Adapter.php';
require_once LIB_PATH . 'Unister' . DS . 'Auth' . DS . 'User.php';

/**
 * Abstrakte Controller-Klasse
 *
 * @author Thomas Mueller <thomas.mueller@unister-gmbh.de>
 */
class Unister_Finance_Controller_Abstract extends Zend_Controller_Action{
    /**
     * @var Validation Objekt zur Pruefung der Benutzereingaben
     */
    protected $_validation;

    protected $_generalStates = array(
        ""     => " - Bitte ausw&auml;hlen - ",
        "AD" => "Andorra",
        "AE" => "Vereinigte Arabische Emirate",
        "AF" => "Afghanistan",
        "AG" => "Antigua & Barbuda",
        "AI" => "Anguilla",
        "AL" => "Albanien ",
        "AM" => "Armenien ",
        "AN" => "Niederl&auml;ndische Antillen",
        "AO" => "Angola ",
        "AQ" => "Antartik",
        "AR" => "Argentinien",
        "AS" => "Amerikanisch Samoa",
        "AT" => "&Ouml;sterreich",
        "AU" => "Australien",
        "AW" => "Aruba",
        "AZ" => "Aserbaidschan ",
        "BA" => "Bosnien Herzegowina ",
        "BB" => "Barbados",
        "BD" => "Bangladesch",
        "BE" => "Belgien",
        "BF" => "Burkina Faso",
        "BG" => "Bulgarien ",
        "BH" => "Bahrain",
        "BI" => "Burundi",
        "BJ" => "Benin",
        "BM" => "Bermuda",
        "BN" => "Brunei",
        "BO" => "Bolivien",
        "BR" => "Brasilien",
        "BS" => "Bahamas",
        "BT" => "Bhutan",
        "BV" => "Bouvet Insel",
        "BW" => "Botswana",
        "BY" => "Wei&szlig;russland ",
        "BZ" => "Belize",
        "CA" => "Canada ",
        "CC" => "Cocos Island",
        "CD" => "Demokratische Republik Kongo",
        "CF" => "Zentral Afrikanische Republik",
        "CG" => "Congo ",
        "CH" => "Schweiz ",
        "CI" => "Elfenbeink&uuml;ste",
        "CK" => "Cook Insel",
        "CL" => "Chile",
        "CM" => "Kamerun",
        "CN" => "China",
        "CO" => "Kolumbien",
        "CR" => "Costa Rica",
        "CS" => " Serbien Montenegro",
        "CU" => "Kuba",
        "CV" => "Kap Verde",
        "CX" => "Christmas Islands",
        "CY" => "Zypern",
        "CZ" => "Tschechische Republik",
        "DE" => "Deutschland ",
        "DJ" => "Dschibouti",
        "DK" => "D&auml;nemark",
        "DM" => "Dominika",
        "DO" => "Dominikanische Republik",
        "DZ" => "Algerien",
        "EC" => "Ecuador",
        "EE" => "Estland",
        "EG" => "&Auml;gypten",
        "EH" => "West Sahara",
        "EI" => "Irland ",
        "ER" => "Eritrea",
        "ES" => "Spanien ",
        "ET" => "&Auml;thiopien",
        "FI" => "Finnland",
        "FJ" => "Fidschi",
        "FK" => "Falkland",
        "FM" => "Mikronesien",
        "FO" => "Faroer ",
        "FR" => "Frankreich",
        "GA" => "Gabun",
        "GD" => "Grenada",
        "GE" => "Georgien",
        "GF" => "Franz&ouml;sisch Guyana",
        "GH" => "Ghana",
        "GI" => "Gibraltar",
        "GL" => "Gr&ouml;nland ",
        "GM" => "Gambia",
        "GN" => "Guinea",
        "GP" => "Guadeloupe",
        "GQ" => "&Auml;quatorial Guinea",
        "GR" => "Griechenland",
        "GS" => "S&uuml;d Georgien und Sandwich Inseln",
        "GT" => "Guatemala",
        "GU" => "Guam",
        "GW" => "Guinea-Bissau",
        "GY" => "Guyana",
        "HK" => "Hongkong",
        "HM" => "Heard & McDonald Inseln",
        "HN" => "Honduras",
        "HR" => "Kroatien ",
        "HT" => "Haiti",
        "HU" => "Ungarn",
        "ID" => "Indonesien ",
        "IL" => "Israel ",
        "IN" => "Indien ",
        "IO" => "Britisch Indisch Ozean Territorium",
        "IQ" => "Iraq ",
        "IR" => "Iran ",
        "IS" => "Island ",
        "IT" => "Italien",
        "JM" => "Jamaika",
        "JO" => "Jordanien",
        "JP" => "Japan",
        "KE" => "Kenia ",
        "KG" => "Kirgisistan ",
        "KH" => "Kambodschia",
        "KI" => "Kiribati",
        "KM" => "Komoren",
        "KN" => "Sankt Kitts und Nevis",
        "KP" => "Nordkorea",
        "KR" => "S&uuml;dkorea",
        "KW" => "Kuwait",
        "KY" => "Cayman Insel",
        "KZ" => "Kasachstan",
        "LA" => "Laos",
        "LB" => "Libanon",
        "LC" => "Sankt Lucia",
        "LI" => "Lichstenstein",
        "LK" => "Sri Lanka",
        "LR" => "Liberia",
        "LS" => "Lesotho",
        "LT" => "Litauen ",
        "LU" => "Luxemburg",
        "LV" => "Lettland ",
        "LY" => "Lybien ",
        "MA" => "Marokko",
        "MC" => "Monaco ",
        "MD" => "Moldavien ",
        "MG" => "Madagaskar",
        "MH" => "Marschall Inseln",
        "MK" => "Mazedonien ",
        "ML" => "Mali",
        "MM" => "Myanmar",
        "MN" => "Mongolei",
        "MO" => "Macau",
        "MP" => "N&ouml;rdlische Mariannen Inseln",
        "MQ" => "Martinique",
        "MR" => "Mauretanien",
        "MS" => "Montserrat",
        "MT" => "Malta",
        "MU" => "Mauritius",
        "MV" => "Malediven",
        "MW" => "Malawi",
        "MX" => "Mexiko",
        "MY" => "Malaysia",
        "MZ" => "Mosambik",
        "NA" => "Namibia ",
        "NC" => "Neu Kaledonien",
        "NE" => "Niger",
        "NF" => "Norfolk Inseln",
        "NG" => "Nigeria",
        "NI" => "Nicaragua",
        "NL" => "Niederlande ",
        "NO" => "Norwegen ",
        "NP" => "Nepal",
        "NR" => "Nauru",
        "NU" => "Niue",
        "NZ" => "Neuseeland",
        "OM" => "Oman",
        "PA" => "Panama",
        "PE" => "Peru",
        "PF" => "Franz&ouml;sisch Polynesien",
        "PG" => "Papua Neu Guinea",
        "PH" => "Philippinen",
        "PK" => "Pakistan",
        "PL" => "Polen",
        "PM" => "Sankt Pierre und Miquelon",
        "PN" => "Pitcairn",
        "PR" => "Puerto Rico",
        "PS" => "Palestina",
        "PT" => "Portugal ",
        "PW" => "Palau ",
        "PY" => "Paraguay ",
        "QA" => "Katar ",
        "RE" => "La Réunion",
        "RO" => "Rum&auml;nien ",
        "RU" => "Russische F&ouml;deration ",
        "RW" => "Ruanda",
        "SA" => "Saudi Arabien",
        "SB" => "Salomonen",
        "SC" => "Seychelles",
        "SD" => "Sudan",
        "SE" => "Schweden ",
        "SG" => "Singapur ",
        "SH" => "Sankt Helena",
        "SI" => "Slowenien ",
        "SJ" => "Svalbard und Jan Mayen",
        "SK" => "Slowakische Republik",
        "SL" => "Sierra Leone",
        "SM" => "San Marino",
        "SN" => "Senegal",
        "SO" => "Somalia",
        "SR" => "Suriname",
        "ST" => "Sao Tome und Principe",
        "SV" => "El Salvador",
        "SY" => "Syrien",
        "SZ" => "Swaziland",
        "TC" => "Turks und Caicos Inseln",
        "TD" => "Tschad",
        "TF" => "Franz&ouml;sische S&uuml;d Territorien",
        "TG" => "Togo",
        "TH" => "Thailand",
        "TK" => "Tokelau",
        "TJ" => "Tadschikistan",
        "TM" => "Turkmenistan ",
        "TN" => "Tunesien ",
        "TO" => "Tonga ",
        "TP" => "Ost Timor",
        "TR" => "T&uuml;rkei",
        "TT" => "Trinidad und Tobago",
        "TV" => "Tuvalu",
        "TW" => "Taiwan",
        "TZ" => "Tanzania",
        "UA" => "Ukraine",
        "UG" => "Uganda",
        "UK" => "Gro&szlig;britannien ",
        "UM" => "Inseln der USA",
        "US" => "USA",
        "UY" => "Uruguay",
        "UZ" => "Usbekistan",
        "VA" => "Vatikan",
        "VC" => "Sankt Vincente und Grenadinen",
        "VE" => "Venezuela",
        "VI" => "Virgin Inseln",
        "VN" => "Vietnam",
        "VU" => "Vanatua",
        "WF" => "Wallis und Futuna",
        "WS" => "Samoa",
        "YE" => "Yemen",
        "YT" => "Mayotte",
        "YU" => "Jugoslawien",
        "ZA" => "S&uuml;d-Afrika",
        "ZM" => "Zambia",
        "ZW" => "Zimbabwe",
    );

    protected $_generalProfession = array(
        ""   => " - Bitte auswählen - ",
        "1"  => "Vorstand/Geschäftsführer",
        "2"  => "leitender Angestellter",
        "3"  => "Angestellter",
        "4"  => "Beamter im gehobenen Dienst",
        "5"  => "Beamter im höheren Dienst",
        "6"  => "Beamter im mittleren Dienst",
        "7"  => "Beamter im einfachen Dienst",
        "8"  => "Zeitsoldat",
        "9"  => "Berufssoldat",
        "10" => "Meister",
        "11" => "Selbständig",
        "12" => "Facharbeiter",
        "13" => "Arbeiter",
        "14" => "Student",
        "15" => "Schüler",
        "16" => "Auszubildender",
        "17" => "Hausfrau/-mann",
        "18" => "Rentner/Pensionär",
        "19" => "ohne Beschäftigung",
    );

    protected $_generalBusiness = array(
        ""      => " - Bitte auswählen - ",
        "01" => "Baugewerbe",
        "02" => "Dienstleistungen",
        "03" => "Energie, Wasser, Bergbau",
        "04" => "Finanzierungen/Versicherungen",
        "18" => "Gastgewerbe",
        "06" => "Handel",
        "07" => "Land-/Forstwirt., Fischerei",
        "08" => "Organisation ohne Erwerbszweck",
        "09" => "Schwerindustrie, Chemie",
        "10" => "Staat, oeffentlicher Dienst",
        "11" => "Telekomm./Neue Technologien",
        "17" => "Tourismus",
        "12" => "Verarb. Gewerbe, Handwerk",
        "13" => "Verkehr - Gueter, Waren",
        "14" => "Verkehr - Personen",
        "15" => "Zeitarbeitsfirma",
        "16" => "keine Angabe",
        "20" => "Sonnenstudios",
        "21" => "Videotheken",
        "22" => "PC-Haendler",
        "23" => "Schausteller",
        "24" => "Taxiunternehmer",
    );

    /**
     * @var Acl Objekt zur Verwaltung der Zugriffe
     */
    protected $_acl;

    /**
     * @var Zend_Session Session-Objekt der Authentifizierung
     */
    protected $_authSession;

    /**
     * @var Zend_Session Benutzer-Session-Objekt
     */
    protected $_session;

    /**
     * @var Auth_User Authentifizierungs-Objekt des Benutzers
     */
    protected $_user;

    /**
     * @var String Name des aktuellen Hauptmenu-Bereiches
     */
    protected $_mainNavName;

    /**
     * @var String Ressourcen-Name
     */
    protected $_resName;

    /**
     * @var Array Navigation
     */
    protected $_navigation;

    /**
     * @var Object the actual request
     */
    protected $_request;

    /**
     * @var string the actual controller
     */
    protected $_controller;

    /**
     * @var string the actual action
     */
    protected $_action;

    /**
     * @var string the actual module
     */
    protected $_module;

    /**
     * @var string the actual identity
     */
    protected $_identity;

    /**
     * Class constructor
     *
     * The request and response objects should be registered with the
     * controller, as should be any additional optional arguments; these will be
     * available via {@link getRequest()}, {@link getResponse()}, and
     * {@link getInvokeArgs()}, respectively.
     *
     * When overriding the constructor, please consider this usage as a best
     * practice and ensure that each is registered appropriately; the easiest
     * way to do so is to simply call parent::__construct($request, $response,
     * $invokeArgs).
     *
     * After the request, response, and invokeArgs are set, the
     * {@link $_helper helper broker} is initialized.
     *
     * Finally, {@link init()} is called as the final action of
     * instantiation, and may be safely overridden to perform initialization
     * tasks; as a general rule, override {@link init()} instead of the
     * constructor to customize an action controller's instantiation.
     *
     * @param Zend_Controller_Request_Abstract $request
     * @param Zend_Controller_Response_Abstract $response
     * @param array $invokeArgs Any additional invocation arguments
     * @return void
     */
    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        parent::__construct($request, $response, $invokeArgs);

        $this->_request    = $this->getRequest();
        $this->_action     = strtolower($this->_request->getActionName());
        $this->_controller = strtolower($this->_request->getControllerName());
        $this->_module     = strtolower($this->_request->getModuleName());
    }

    public function init()
    {
        $this->initView();
    }

    /**
     * Pseudo-Konstruktor des Zend-Frameworks
     *
     * @access public
     * @return void
     */
    public function preDispatch()
    {
        parent::preDispatch();

        Zend_Registry::set('_POST' , $_POST);
        Zend_Registry::set('_GET'  , $_GET);

        if ($this->_controller == 'backend') {
            $this->_acl = new Unister_Acl();

            // Holt die Sessions aus der Registry und stellt sie den Controller-Klassen zur Verfuegung
            $this->_authSession = Zend_Registry :: get('_authSession');
            $this->_session      = Zend_Registry :: get('_USER_SESSION');

            // Prueft ob ein Auth_User-Objekt in der AUTH_SESSION liegt und legt es an wenn es fehlt (dann als Gast)
            if (!isset($this->_authSession->user) && ($this->_authSession->user instanceof Unister_Auth_User) === false) {
                $auth = new Unister_Auth_Adapter();
                $this->_authSession->user = $auth->getUser();
            }

            // Erstellt Ressourcen-Name
            $this->_resName = $this->_controller;
            if ($this->_action != '') {
                $this->_resName .= '_'.$this->_action;
            }

            // Prueft ob aktueller Benutzer Zugriff auf Ressource hat
            try {
                if (!$this->_acl->isAllowed($this->_authSession->user->role, $this->_resName)) {
                    $this->_forward("Login", "Backend");
                    //var_dump($this->_acl);exit;
                }
            } catch (Exception $e) {
                $this->_forward("Login", "Backend");
                //var_dump($e->getMessage());
                //var_dump($e->getTrace());exit;
            }
        }
        /**/
    }

    /**
     * Pseudo-Destructor des Zend-Frameworks
     *
     * @access public
     * @return void
     */
    public function postDispatch()
    {
        parent::postDispatch();

        // Erstellt die Navigation
        if ($this->_createNavigation($this->_mainNavName)) {
            $this->_vars['navigation'] = $this->_navigation;
        }

        $this->_vars['acl']     = $this->_acl;
        $this->_vars['user']    = $this->_authSession->user;

        if ($this->_request->isDispatched()) {
            if (!isset($this->_vars['_controller'])) {
                $this->_vars['_controller'] = $this->_getResourceId();
            }
        }
    }

    /**
     * Die Methode erstellt URLs je nach Art der Einbindung
     *
     * @param string  $controller Name des Controllers
     * @param string  $action     Name der Action
     * @param array   $postData   weitere URL-Parameter
     * @param boolean $int        a flag
     *                            TRUE:  the link will be coded like /key/value/
     *                            FALSE: the link will be coded like ?key=value
     *
     * @access public
     * @return String Fertige URL
     */
    public function buildURL($controller, $action, array $postData = array(), $int = true)
    {
        if ($int === false) {
            $url = URL_DIR . '?controller=' . $controller . '&amp;action=' . $action;
        } elseif (defined('URL_TYPE') && URL_TYPE == 'INT') {
            $url = HOME_URL . $controller . '/' . $action;
        } elseif ($int || $controller == "Hilfe") {
            $url = HOME_URL . $controller . '/' . $action;
        } else {
            $url = URL_DIR . '?controller=' . $controller . '&amp;action=' . $action;
        }

        $url = $this->_postToGetUrl($url, $postData, $int);

        if ($int && substr($url, -1) != '/') {
            $url .= '/';
        }

        return $url;
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
     * @access protected
     */
    protected function _postToGet(array $data, $int = true)
    {
        $gp = array();

        if ($int) {
            $bind0 = '/';
            $bind1 = '/';
            $bind2 = '/';
        } else {
            $bind0 = '?';
            $bind1 = '=';
            $bind2 = '&amp;';
        }

        if (count($data) > 0) {
            $keys = array_keys($data);

            foreach ($keys as $key) {
                $value = $data[$key];

                if (is_array($value)) {
                    $value = array_pop($value);
                }

                if (!is_array($value) && $value != '') {
                    $gp[]  = $key . $bind1 . urlencode($value);
                }
            }
        }

        $gp = implode($bind2, $gp);

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
     * @access protected
     */
    protected function _postToGetUrl($url, array $data, $int = true)
    {
        $gpUrl = $url;

        if ($int) {
            $bind0 = '/';
            $bind1 = '/';
            $bind2 = '/';
        } else {
            $bind0 = '?';
            $bind1 = '=';
            $bind2 = '&amp;';
        }

        if (count($data)) {
            //Zend_Debug::dump($data);

            #if ($int && substr($gpUrl, -1) == '/') {
            #    $gpUrl = substr($gpUrl, 0, -1);
            #}

            if (!$int && strpos($gpUrl, $bind0) !== false) {
                $gpUrl .= $bind2;
            } else {
                $gpUrl .= $bind0;
            }

            $gpUrl .= $this->_postToGet($data, $int);

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
     * liefert die microtime
     *
     * @return float
     * @access protected
     */
    protected function _microtimeFloat()
    {
        if (version_compare(PHP_VERSION, '5.0.0', '>')) {
            return microtime(true);
        } else {
            list($usec, $sec) = explode(" ", microtime());
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
     *
     * @access protected
     * @return File handler
     */
    protected function _fopenRecursive($path, $mode, $chmod=0777)
    {
        $matches = array();

        preg_match('`^(.+)/([a-zA-Z0-9_]+\.[a-z]+)$`i', $path, $matches);

        if (count($matches) < 3) {
            //Datei- /Verzeichnis-Name entspricht nicht dem Vorgabe-Schema
            return false;
        }

        $directory = $matches[1];
        $file      = $matches[2];

        if (!is_dir($directory)) {
            //Verzeichnis existiert nicht
            if (!mkdir($directory, 0777, 1)) {
                //Verzeichnis konnte nicht mit den gewünschten Rechten erstellt werden
                return false;
            } else {
                exec("chmod -R 777 $directory");
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
     * @access protected
     */
    protected function _formatDate($day, $month, $year)
    {
        $day   = substr('0' . $day, -2);
        $month = substr('0' . $month, -2);

        $date = $day . '.' . $month . '.' . $year;

        return $date;
    }

    /**
     * erstellt eine CSV-Datei aus den Antragsdaten
     *
     * @param array   $requestData die Daten des Antragsstellers
     * @param integer $reportNr    die ID des Antragsdatensatzes
     *
     * @return string
     * @access protected
     */
    protected function _createCSV(array $requestData = array(), $reportNr = null)
    {
        if ($reportNr === null) {
            return '';
        }

        //$csv = implode(';', $requestData);
        $csv  = "<xml dataset=\"$reportNr\">";
        foreach ($requestData as $key => $value) {
            $csv .= "<$key>$value</$key>";
        }
        $csv .= "</xml>";



        return $csv;
    }

    /**
     * erstellt eine CSV-Datei aus den Antragsdaten
     *
     * @param array   $rData    die Daten des Antragsstellers
     * @param integer $reportNr die ID des Antragsdatensatzes
     *
     * @return string
     * @access protected
     */
    protected function _createXML(array $rData = array(), $reportNr = null)
    {
        if ($reportNr === null) {
            return '';
        }

        //unset($rData['anfrageDat']);
        unset($rData['kredit_antrag']);
        unset($rData['partner_id']);
        unset($rData['ccstart']);
        unset($rData['nav_id']);
        unset($rData['datei_name']);
        unset($rData['lnktype']);

        //var_dump($rData);

        $csv  = "<xml dataset=\"$reportNr\">--br--\n";
        foreach ($rData as $key => $value) {
            $key  = strtolower($key);

            if ($key == 'kredit_antrag' ||
                $key == 'partner_id' ||
                $key == 'ccstart' ||
                $key == 'nav_id' ||
                $key == 'datei_name' ||
                $key == 'lnktype') {

                continue;
            }

            if ($key == 'berufsgruppe') {
                $berufsgruppe = (int) $value;

                if ($berufsgruppe == 1) {
                    $berufsgruppe_label = "Vorstand/Geschäftsführer";
                } elseif ($berufsgruppe == 2) {
                    $berufsgruppe_label = "leitender Angestellter";
                } elseif ($berufsgruppe == 3) {
                    $berufsgruppe_label = "Angestellter";
                } elseif ($berufsgruppe == 4) {
                    $berufsgruppe_label = "Beamter im gehobenen Dienst";
                } elseif ($berufsgruppe == 5) {
                    $berufsgruppe_label = "Beamter im höheren Dienst";
                } elseif ($berufsgruppe == 6) {
                    $berufsgruppe_label = "Beamter im mittleren Dienst";
                } elseif ($berufsgruppe == 7) {
                    $berufsgruppe_label = "Beamter im einfachen Dienst";
                } elseif ($berufsgruppe == 8) {
                    $berufsgruppe_label = "Zeitsoldat";
                } elseif ($berufsgruppe == 9) {
                    $berufsgruppe_label = "Berufssoldat";
                } elseif ($berufsgruppe == 10) {
                    $berufsgruppe_label = "Meister";
                } elseif ($berufsgruppe == 11) {
                    $berufsgruppe_label = "Selbständig";
                } elseif ($berufsgruppe == 12) {
                    $berufsgruppe_label = "Facharbeiter";
                } elseif ($berufsgruppe == 13) {
                    $berufsgruppe_label = "Arbeiter";
                } elseif ($berufsgruppe == 14) {
                    $berufsgruppe_label = "Student";
                } elseif ($berufsgruppe == 15) {
                    $berufsgruppe_label = "Schüler";
                } elseif ($berufsgruppe == 16) {
                    $berufsgruppe_label = "Auszubildender";
                } elseif ($berufsgruppe == 17) {
                    $berufsgruppe_label = "Hausfrau/-mann";
                } elseif ($berufsgruppe == 18) {
                    $berufsgruppe_label = "Rentner/Pensionär";
                } elseif ($berufsgruppe == 19) {
                    $berufsgruppe_label = "ohne Beschäftigung";
                } else {
                    $berufsgruppe_label = "Sonstiges";
                }

                $value = $berufsgruppe_label;
            } elseif ($key == 'berufsgruppe1') {
                $berufsgruppe = (int) $value;

                if ($berufsgruppe == 1) {
                    $berufsgruppe_label = "Vorstand/Geschäftsführer";
                } elseif ($berufsgruppe == 2) {
                    $berufsgruppe_label = "leitender Angestellter";
                } elseif ($berufsgruppe == 3) {
                    $berufsgruppe_label = "Angestellter";
                } elseif ($berufsgruppe == 4) {
                    $berufsgruppe_label = "Beamter im gehobenen Dienst";
                } elseif ($berufsgruppe == 5) {
                    $berufsgruppe_label = "Beamter im höheren Dienst";
                } elseif ($berufsgruppe == 6) {
                    $berufsgruppe_label = "Beamter im mittleren Dienst";
                } elseif ($berufsgruppe == 7) {
                    $berufsgruppe_label = "Beamter im einfachen Dienst";
                } elseif ($berufsgruppe == 8) {
                    $berufsgruppe_label = "Zeitsoldat";
                } elseif ($berufsgruppe == 9) {
                    $berufsgruppe_label = "Berufssoldat";
                } elseif ($berufsgruppe == 10) {
                    $berufsgruppe_label = "Meister";
                } elseif ($berufsgruppe == 11) {
                    $berufsgruppe_label = "Selbständig";
                } elseif ($berufsgruppe == 12) {
                    $berufsgruppe_label = "Facharbeiter";
                } elseif ($berufsgruppe == 13) {
                    $berufsgruppe_label = "Arbeiter";
                } elseif ($berufsgruppe == 14) {
                    $berufsgruppe_label = "Student";
                } elseif ($berufsgruppe == 15) {
                    $berufsgruppe_label = "Schüler";
                } elseif ($berufsgruppe == 16) {
                    $berufsgruppe_label = "Auszubildender";
                } elseif ($berufsgruppe == 17) {
                    $berufsgruppe_label = "Hausfrau/-mann";
                } elseif ($berufsgruppe == 18) {
                    $berufsgruppe_label = "Rentner/Pensionär";
                } elseif ($berufsgruppe == 19) {
                    $berufsgruppe_label = "ohne Beschäftigung";
                } else {
                    $berufsgruppe_label = "Sonstiges";
                }

                $value = $berufsgruppe_label;
            } elseif ($key == 'vzweck') {
                $this->zweck = (int) $value;
                if ($this->zweck == 1) {
                    $vzweck_label = "PKW Neukauf";
                } elseif ($this->zweck == 2) {
                    $vzweck_label = "PKW gebraucht";
                } elseif ($this->zweck == 3) {
                    $vzweck_label = "Möbel, Renovierung";
                } elseif ($this->zweck == 4) {
                    $vzweck_label = "Urlaub";
                } elseif ($this->zweck == 5) {
                    $vzweck_label = "PC, TV, Hifi, Video";
                } elseif ($this->zweck == 6) {
                    $vzweck_label = "Ablösung anderer Kredite";
                } elseif ($this->zweck == 7) {
                    $vzweck_label = "Ausgleich Girokonto";
                } else {
                    $vzweck_label = "Sonstiges";
                }

                $value = $vzweck_label;
            } elseif ($key == 'probezeit') {
                $probezeit = (int) $value;
                if ($probezeit == 1) {
                    $label = "beendet";
                } else {
                    $label = "nicht beendet";
                }

                $value = $label;
            } elseif ($key == 'dreimonate') {
                $dreimonate = (int) $value;
                if ($dreimonate == 1) {
                    $label = "länger als 3 Monate";
                } else {
                    $label = "noch nicht 3 Monate";
                }

                $value = $label;
            }

            $csv .= "--sp--<$key>$value</$key>--br--\n";
        }

        $uniqueId = time() . '_' . substr(md5(microtime(true)),0,2);
        $csv .= "--sp--<uuid>".$uniqueId."</uuid>--br--\n";
        $csv .= "</xml>";

        //echo $csv; die();

        return str_replace('--br--', '<br />', str_replace('--sp--', '&nbsp;&nbsp;&nbsp;&nbsp;', htmlentities($csv)));
    }

    /**
     * serialisation for an array
     *
     * @param array $data
     *
     * @return string
     * @access protected
     */
    protected function _serializeXml(array $data)
    {
        $xmlString = '<result />';

        try {
            if (is_array($data)) {
                $xmlString = $this->_ia2xml($data);
            } else {
                $xmlString = '';
            }
            $xmlString = "<result>" . $xmlString . "</result>";
            //Zend_Debug::dump($xmlString);
        } catch (Exception $e) {
            trigger_error($e->getMessage() . "['$xmlString']", E_USER_NOTICE);
            Zend_Debug::dump($e->getMessage());
            return '<result />';
        }

        try {
            $xml = new SimpleXMLElement($xmlString);
        } catch (Exception $e) {
            trigger_error($e->getMessage() . "['$xmlString']", E_USER_NOTICE);
            Zend_Debug::dump($e->getMessage());
            return '<result />';
        }

        $SerializedData = $xml->asXML();

        //throw new exception("XML_Serializer nicht da");
        return $SerializedData;
    }

    /**
     * serialisation for an array
     *
     * @param array   $data
     * @param integer $level
     *
     * @return string
     * @access protected
     */
    protected function _ia2xml(array $array, $level = 0)
    {
        $xml    = "";
        $level2 = $level + 1;

        foreach ($array as $key => $value) {
            //Zend_Debug::dump($value);
            if (is_array($value)) {
                $xml .= '<' . $key . '>' . $this->_ia2xml($value, $level2) . '</' . $key . '>';
            } elseif (is_object($value)) {
                $class = get_class($value);
                if ($class == 'SimplexmlElement') {
                    $xml .= '<' . $key . '>' . $value->asXML() . '</' . $key . '>';
                } else {
                    $xml .= '<' . $key . '>' . $this->_ia2xml((array) $value, $level2) . '</' . $key . '>';
                }
            } elseif ($value == '') {
                $xml .= "<$key />";
            } else {
                //Zend_Debug::dump($value);
                if (is_string($value)) {
                    $value = $this->decode($value);
                    //Zend_Debug::dump($value);
                    if (version_compare(PHP_VERSION, '5.2.3', '>')) {
                        $value = htmlentities($value, ENT_QUOTES, ENCODING, false);
                    } else {
                        $value = htmlentities($value, ENT_QUOTES, ENCODING);
                    }
                    //Zend_Debug::dump($value);
                    $value = str_replace('€', '&amp;euro;', $value);
                    $value = str_replace('&amp;amp;amp;', '&amp;amp;', $value);
                    $value = str_replace('&amp;amp;uuml;', '&amp;uuml;', $value);
                    $value = str_replace('&amp;amp;auml;', '&amp;auml;', $value);
                    $value = str_replace('&amp;amp;ouml;', '&amp;ouml;', $value);
                    $value = str_replace('&amp;amp;szlig;', '&amp;szlig;', $value);
                    $value = str_replace('&amp;amp;Uuml;', '&amp;Uuml;', $value);
                    $value = str_replace('&amp;amp;Auml;', '&amp;Auml;', $value);
                    $value = str_replace('&amp;amp;Ouml;', '&amp;Ouml;', $value);
                    //Zend_Debug::dump($value);
                }

                $xml  .= '<' . $key . '>' . $value . '</' . $key . '>';
            }
        }

        return $xml;
    }

    /**
     * decodes an value from utf-8 to iso
     *
     * @param string  $item     the string to decode
     * @param boolean $entities an flag,
     *                          if TRUE the string will be encoded with
     *                          htmlentities
     *
     * @return string
     * @access public
     */
    public function decode($item, $entities = true)
    {
        if (!defined('ISO')) {
            define('ISO', 'iso-8859-1');
        }

        if (is_string($item) && $item != '') {
            if (ENCODING == ISO &&
                mb_detect_encoding($item . ' ', 'UTF-8,ISO-8859-1') == 'UTF-8') {
                $item = utf8_decode($item);
            }

            if ($entities) {
                if (version_compare(PHP_VERSION, '5.2.3', '>')) {
                    $item = htmlentities($item, ENT_QUOTES, ENCODING, true);
                } else {
                    $item = htmlentities($item, ENT_QUOTES, ENCODING);
                }
            }
        }

        return $item;
    }

    /**
     * encodes an value from iso to utf-8
     *
     * @param string  $item     the string to decode
     * @param boolean $entities (Optional) an flag,
     *                          if TRUE the string will be encoded with
     *                          html_entitiy_decode
     *
     * @return string
     * @access public
     */
    public function encode($item, $entities = true)
    {
        if (!defined('UTF8')) {
            define('UTF8', 'utf-8');
        }

        if (is_string($item) && $item != '') {
            if ($entities) {
                $item = html_entity_decode($item, ENT_QUOTES, ENCODING);
            }

            if (ENCODING == UTF8 &&
                mb_detect_encoding($item . ' ', 'UTF-8,ISO-8859-1') == 'ISO-8859-1') {
                $item = utf8_encode($item);
            }
        }

        return $item;
    }

    /**
     * Gets a parameter from the {@link $_request Request object}.  If the
     * parameter does not exist, NULL will be returned.
     *
     * If the parameter does not exist and $default is set, then
     * $default will be returned instead of NULL.
     *
     * If $validator is set, the value of the parameter will be validated. If the
     * validation fails, $default will be returned.
     * The following values are possible as $validator:
     * 1 a string containing an type, if you want to use an Zend_Validator object
     *   e.g. 'Int' for using Zend_Validate_Int'
     * 2 a string containing an type, with an underscore added as first character, if
     *   you want to use a custom validator
     *   e.g. '_Unister_Finance_Validate_Plz'
     * 3 an validator object
     * 4 an array containing strings or objects like in numbers 1-3
     *
     * @param array  $requestData assoziative array of all given params
     * @param string $paramName   the name of the param
     * @param mixed  $default     the default value
     * @param mixed  $validator   the type for an validator, an validator object or
     *                            an array of validatortypes/validatorobjects
     *
     * @return mixed
     * @access protected
     */
    protected function _getParamFromArray(array $requestData = array(), $paramName = null, $default = null, $validator = null)
    {
        if ($paramName === null || count($requestData) == 0) {
            return $default;
        }

        if (isset($requestData[$paramName]) && $requestData[$paramName] !== null) {
            if (is_array($requestData[$paramName])) {
                $value = array_pop($requestData[$paramName]);
                $value = strip_tags(trim($value));
            } else {
                $value = strip_tags(trim($requestData[$paramName]));
            }
        } else {
            return $default;
        }

        $data = array();

        //create Validator Object, if Validator Type is set
        if ($validator !== null) {
            if (is_array($validator)) {
                $v0        = $validator;
                $validator = new Zend_Validate();

                foreach ($v0 as $v1) {
                    if (is_string($v1)) {
                        if (substr($v1, 0, 1) == '_') {
                            $v2 = substr($v1, 1);
                            include_once LIB_PATH . str_replace('_', DS, $v2) . '.php';
                        } else {
                            $v2 = 'Zend_Validate_' . $v1;
                        }
                        $validator->addValidator(new $v2());
                    } elseif (is_object($v1) && is_subclass_of($v1, 'Zend_Validate_Abstract')) {
                        $validator->addValidator($v1);
                    }
                }
            } elseif (is_string($validator)) {
                if (substr($validator, 0, 1) == '_') {
                    $v2 = substr($validator, 1);
                    include_once LIB_PATH . str_replace('_', DS, $v2) . '.php';
                } else {
                    $v2 = 'Zend_Validate_' . $validator;
                }
                $validator = new $v2();
            } elseif (is_object($validator) && is_subclass_of($validator, 'Zend_Validate_Abstract')) {
                //nothing to change
            } else {
                $validator = null;
            }
        }

        if (is_array($value)) {
            $data[$paramName] = array();
            $keys             = array_keys($value);

            foreach ($keys as $key2) {
                $value2 = $this->decode(strip_tags(trim($value[$key2])), false);

                if ($validator !== null) {
                    if (!$validator->isValid($value2)) {
                        //Zend_Debug::dump($validator->getErrors());
                        continue;
                    }
                }

                $functionName = '_check' . ucfirst(strtolower($paramName));

                if (method_exists($this, $functionName)) {
                    if (!$this->$functionName($value2)) {
                        continue;
                    }
                }

                $data[$paramName][$key2] = $value2;
            }
        } else {
            $value = $this->decode(strip_tags(trim($value)), false);
            //Zend_Debug::dump($value);

            if ($validator !== null) {
                if (!$validator->isValid($value)) {
                    //Zend_Debug::dump($validator->getErrors());
                    $value = $default;
                }
            }

            $functionName = '_check' . ucfirst(strtolower($paramName));

            if ($value != $default && method_exists($this, $functionName)) {
                if (!$this->$functionName($value)) {
                    $value = $default;
                }
            }

            $data[$paramName] = $value;
        }

        return $data[$paramName];
    }

    /**
     * Enter description here...
     *
     * @return array
     * @access public
     */
    public function getBerufe()
    {
        $profession = $this->_generalProfession;

        $keys = array_keys($profession);

        foreach ($keys as $key) {
            $value            = $profession[$key];
            $profession[$key] = $this->encode($value);
        }

        return $profession;
    }

    /**
     * wandelt einen String in das CamelCase-format um und ersetzt dabei Umlaute
     *
     * @param string $key the input string
     *
     * @return string the camelCased string
     * @access protected
     */
    protected function _camelCase($key)
    {
        $this->decode($key);

        $search  = array('Ã¤','Ã¶', 'Ã¼', 'Ã„', 'Ã–', 'Ãœ', 'ÃŸ', '-');
        $replace = array('ae','oe', 'ue', 'Ae', 'Oe', 'Ue', 'ss', '_');
        $key     = str_replace($search, $replace, strtolower($key));

        $keys = explode('_', $key);

        foreach ($keys as $i => $k) {
            $keys[$i] = ucfirst($k);
        }

        $key = implode('', $keys);

        return $key;
    }

    final protected function _getResourceId ()
    {
        return strtolower($this->_controller);
    }

    final protected function _getAction()
    {
        return strtolower($this->_action);
    }

    protected function _createNavigation($nav_name)
    {
        $nav_db   = new Model_Navigation();
        $main_nav = $nav_db->getNavigation(0);

        $this->_navigation = array(
            'main'  => array(),
            'sub'   => array(),
        );
        if (is_array($main_nav)) {
            foreach ($main_nav as $nav_item) {
                /*
                if ($this->_acl->isAllowed($this->_authSession->user->role, $nav_item['res_name'])){
                    $this->_navigation['main'][] = array(
                        'label'     => (string)$nav_item['nav_name'],
                        'action'    => (string)$nav_item['res_action'],
                        'controller'=> (string)$nav_item['res_controller'],
                    );
                }
                */
                if ($nav_name == $nav_item['nav_name']){
                    $subid = $nav_item['nav_id'];
                }
            }
        }

        if (isset($subid)) {
            $sub_nav = $nav_db->getNavigation($subid);
            foreach ($sub_nav as $snav_item) {
                if ($this->_acl->isAllowed($this->_authSession->user->role, $snav_item['res_name'])){
                    $this->_navigation['sub'][] = array(
                        'label'     => (string)$snav_item['nav_name'],
                        'action'    => (string)$snav_item['res_action'],
                        'controller'=> (string)$snav_item['res_controller'],
                    );
                }
            }
        }

        return (count($this->_navigation['main']) > 0) ? true : false;
    }
}