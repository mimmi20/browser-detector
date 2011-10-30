<?php
/**
 * Interface to Google AdSense for Search
 *
 * PHP version 5
 *
 * @category  Geld.de
 * @package   Google
 * @author    Stephan Wiese <info@wwwiese.de> 2005
 * @copyright 2007-2009 Unister GmbH
 * @version   SVN: $Id$
 */
require_once LIB_PATH . 'Unister' . DS . 'Finance' . DS . 'Core' . DS . 'Abstract.php';
/**
 * Interface to Google AdSense for Search
 *
 * requires the Pear XML library
 *
 * @category  Geld.de
 * @package   Google
 * @author    Stephan Wiese <info@wwwiese.de> 2005
 * @copyright 2007-2009 Unister GmbH
 * @version   1.0.0
 */
class Unister_Finance_Core_Google extends Unister_Finance_Core_Abstract
{
    protected $Server;
    protected $Client;
      protected $ClientIp;
      protected $OutputType;
      protected $Test;
      protected $Language;
      protected $Country;
      protected $OutputFormat;
      protected $Search;
      protected $SafeMode;
      protected $UserAgent;
      protected $Pages;
    protected $Num;
      protected $_fingerprint;
      protected $cEncodeQuery;
      protected $cEncodeXml;
      protected $Channel;

/*  protected $ReadTimeout = array();
    protected $Timeout;
*/
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
     * @param Zend_Controller_Request_Abstract  $request
     * @param Zend_Controller_Response_Abstract $response
     * @param array                             $invokeArgs Any additional
     *                                                      invocation arguments
     *
     * @return void
     * @access public
     */
    public function __construct(array $params = array())
    {
        $this->_setRequestParams($params);
    }

    protected function _setRequestParams(array $params)
    {

    }

    public function getData(array $params = array())
    {
        $this->_setRequestParams($params);

        $this->Domain = 'http://' . $this->Server;

        if ($this->Domain == 'http://ads.unister-gmbh.de/unister-gmbh.de/developers/google_interface/googleInterface.php') {
            $dataArray['_fingerprint']     = $this->_fingerprint;
            $dataArray['Client']         = $this->Client;
            $dataArray['ClientIp']         = $this->ClientIp;
            $dataArray['OutputType']     = $this->OutputType;
            $dataArray['Test']             = $this->Test;
            $dataArray['Language']         = $this->Language;
            $dataArray['Country']         = $this->Country;
            $dataArray['OutputFormat']     = $this->OutputFormat;
            $dataArray['Search']         = $this->Search;
            $dataArray['SafeMode']         = $this->SafeMode;
            $dataArray['UserAgent']     = $this->UserAgent;
            $dataArray['Pages']         = $this->Pages;
            $dataArray['Num']             = $this->Num;
            $dataArray['Channel']         = $this->Channel;
            $dataArray['ie']             = $this->cEncodeQuery;
            $dataArray['oe']             = $this->cEncodeXml;
        } else {
            $dataArray['client']     = $this->Client;
            $dataArray['ip']         = $this->ClientIp;
            $dataArray['output']     = $this->OutputType;
            $dataArray['adtest']     = $this->Test;
            $dataArray['hl']         = $this->Language;
            $dataArray['gl']         = $this->Country;
            $dataArray['ad']         = $this->OutputFormat;
            $dataArray['q']         = $this->Search;
            $dataArray['adsafe']     = $this->SafeMode;
            $dataArray['useragent'] = $this->UserAgent;
            $dataArray['adpage']     = $this->Pages;
            $dataArray['num']         = $this->Num;
            $dataArray['channel']     = $this->Channel;
            $dataArray['ie']         = $this->cEncodeQuery;
            $dataArray['oe']         = $this->cEncodeXml;
        }

        // Request from Google
        $client = new Zend_Http_Client($this->Domain);
        $client->setMethod(Zend_Http_Client::GET);
        $client->setParameterGet($dataArray);

        $response = $client->request();

        if ($response->getStatus() == 200) {
            $result = $this->unserializeXml($response->getBody());
        } else {
            #$myReturn= $httpClient->CurrentResponse();
            #echo "<!-- " . $response->getMessage() . " -->";
            $result = array('Google_Interface::getData() connection error');
        }

        return $result;
    }

    protected function setReadTimeout($sekunden, $micosekunden)
    {
        $this->ReadTimeout[0] = $sekunden;
        $this->ReadTimeout[1] = $micosekunden;
    }

    protected function setTimeout($sekunden)
    {
        $this->Timeout = $sekunden;
    }

    /**
     * Enter description here...
     *
     * @param string $response
     *
     * @return array|string
     * @access public
     */
    protected function unserializeXml($response)
    {
        //var_dump($response);
        $values = array();

        $parser = xml_parser_create('');
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE,1);
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, 'ISO-8859-1');

        xml_parse_into_struct($parser, $response, $values);
        $error = xml_get_error_code($parser);

        //var_dump($error);
        //var_dump($values);

        $return        = array();
        $stack         = '';
        $attrs         = array();
        $levelCounters = array(0);

        foreach ($values as $xml_elem) {
            if ($xml_elem['type'] == 'open') {
                if (array_key_exists('attributes', $xml_elem)) {
                    list($level[$xml_elem['level']],$extra) = array_values($xml_elem['attributes']);
                } else {
                    $level[$xml_elem['level']] = $xml_elem['tag'];
                }
            }
            if ($xml_elem['type'] == 'complete') {
                $start_level = 1;
                $php_stmt = '$return';
                while($start_level < $xml_elem['level']) {
                    $php_stmt .= '[$level['.$start_level.']]';
                    $start_level++;
                }
                $php_stmt .= '[$xml_elem[\'tag\']] = ((isset($xml_elem[\'value\'])) ? $xml_elem[\'value\'] : null);';
                eval($php_stmt);
            }
        }

        xml_parser_free($parser);

        $keys = array_keys($return);
        $return = $return[$keys[0]];
        //var_dump($return);
        return $return;
    }
}
?>