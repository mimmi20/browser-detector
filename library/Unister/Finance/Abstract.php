<?php
/**
 * TODO
 *
 * @author Thomas Mueller <thomas.mueller@unister-gmbh.de>
 */
abstract class Unister_Finance_Abstract
{
    /**
     * Database connector
     *
     * @var Zend_Db Datenbank-Objekt
     */
    protected $_db = null;

    /**
     * Konstruktor
     */
    public function __construct()
    {
        $this->_db = Zend_Registry::get('db');
    }

    /**
     * Class destructor
     *
     * @return void
     * @access public
     */
    public function __destruct()
    {
        unset($this->_db);
    }

    /**
     * Generic check method
     *
     * Can be overloaded/supplemented by the child class
     *
     * @return boolean True if the object is ok
     * @access public
     */
    public function check()
    {
        return true;
    }

    /**
     * Export item list to xml
     *
     * @param boolean Map foreign keys to text values
     *
     * @return string
     * @access public
     */
    public function toXML($mapKeysToText = false)
    {
        $xml = '<record table="' . $this->_name . '"';

        if ($mapKeysToText) {
            $xml .= ' mapkeystotext="true"';
        }

        $xml .= '>';

        foreach (get_object_vars($this) as $k => $v) {
            if (is_array($v) or is_object($v) or $v === null) {
                continue;
            }

            $xml .= '<' . $k . '><![CDATA[' . $v . ']]></' . $k . '>';
        }

        $xml .= '</record>';

        return $xml;
    }

    /**
     * Returns a property of the object or the default value if the property is not set.
     *
     * @param    string $property The name of the property
     * @param    mixed  $default The default value
     *
     * @return    mixed The value of the property
     * @access    public
     * @see        getProperties()
     * @since    1.5
      */
    public function get($property, $default = null)
    {
        if(isset($this->$property)) {
            return $this->$property;
        }

        return $default;
    }

    /**
     * Returns a property of the object or the default value if the property is not set.
     *
     * @param    string $property The name of the property
     * @param    mixed  $default The default value
     *
     * @return    mixed The value of the property
     * @access    public
     * @see        getProperties()
     * @since    1.5
      */
    public function __get($property)
    {
        return $this->get($property, null);
    }

    /**
     * Returns an associative array of object properties
     *
     * @param    boolean $public If true, returns only the public properties
     *
     * @return    array
     * @access    public
     * @see        get()
     * @since    1.5
      */
    public function getProperties()
    {
        $vars  = get_object_vars($this);

        return $vars;
    }

    /**
     * Modifies a property of the object, creating it if it does not already exist.
     *
     * @param    string $property The name of the property
     * @param    mixed  $value The value of the property to set
     *
     * @return    mixed Previous value of the property
     * @access    public
     * @see        setProperties()
     * @since    1.5
     */
    public function set($property, $value = null)
    {
        $previous = isset($this->$property) ? $this->$property : null;
        $this->$property = $value;
        return $previous;
    }

    /**
     * Modifies a property of the object, creating it if it does not already exist.
     *
     * @param    string $property The name of the property
     * @param    mixed  $value The value of the property to set
     *
     * @return    void
     * @access    public
     * @see        setProperties()
     * @since    1.5
     */
    public function __set($property, $value)
    {
        $this->set($property, $value);
    }

    /**
     * Set the object properties based on a named array/hash
     *
     * @param    array $properties mixed Either and associative array or another object
     *
     * @return    void
     * @access    protected
     * @see        set()
     * @since    1.5
     */
    protected function setProperties(array $properties)
    {
        foreach ($properties as $k => $v) {
            $this->$k = $v;
        }
    }

    /**
     * @access public
     */
    public function decode_array(&$item, $key = null)
    {
        if (is_string($item) && $item != '') {
            $item = (mb_detect_encoding($item . ' ','UTF-8,ISO-8859-1') == 'UTF-8' ? utf8_decode($item) : $item );
            $item = htmlspecialchars($item);
        }
    }

    /**
     * @access protected
     */
    protected function fopenRecursive($path, $mode, $chmod = 0777)
    {
          $matches = array();
          preg_match('`^(.+)/([a-zA-Z0-9_]+\.[a-z]+)$`i', $path, $matches);
          //var_dump($matches);
          $directory = $matches[1];
          $file      = $matches[2];

          if (!is_dir($directory)) {
            if (!mkdir($directory, 0777, 1)) {
                return false;
            }
          }

         return fopen ($path, $mode);
    }

    /**
     * Enter description here...
     *
     * @param string $response
     *
     * @return array|string
     * @access public
     */
    public function unserializeXml($response)
    {
        $values = array();
        $tags   = null;

        $response = str_replace('<?xml version="1.0" encoding="ISO-8859-1"?>', '', $response);
        $response = str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', $response);
        $response = str_replace("\n", '', $response);
        $response = str_replace("\r", '', $response);
        $response = str_replace("\t", '', $response);
        $response = str_replace("–", '-', $response);

        $parser = xml_parser_create('');
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE,1);
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, 'ISO-8859-1');

        xml_parse_into_struct($parser, $response, $values, $tags);
        $error = xml_get_error_code($parser);

        $return        = array();
        $stack         = '';
        $attrs         = array();
        $levelCounters = array(0);

        foreach ($values as $xml_elem) {
            if ($xml_elem['type'] == 'open') {
                if (array_key_exists('attributes',$xml_elem)) {
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
                //var_dump($php_stmt);
                eval($php_stmt);
            }
        }

        xml_parser_free($parser);

        $keys = array_keys($return);

        $return = $return[$keys[0]];

        return $return;
    }

    /**
     * Enter description here...
     *
     * @param array $requestData
     *
     * @return string
     * @access public
     */
    public function postToGet(array $requestData = array())
    {
        $gp = '?';

        if (count($requestData) > 0) {
            while (list ($key, $value) = each ($requestData)) {
                $gp .= $gp != '?' ? '&' : '';

                if (is_array($value)) {
                    while (list($key2, $value2) = each($value)) {
                        $gp .= $gp != '?' ? '&' : '';
                        $gp .= $key . '[' . $key2 . ']' . '=' . urlencode($value2);
                    }
                } else {
                    $gp .= $key . '=' . urlencode($value);
                }
            }
        } else {
            $gp = '';
        }

        return $gp;
    }

    /**
     * Enter description here...
     *
     * @param string $url
     * @param array  $requestData
     *
     * @return string
     * @access public
     */
    public function postToGetUrl($url, array $requestData = array())
    {
        $gpUrl = $url;

        if (is_array($requestData) && count($requestData)) {
            $gpUrl .= $this->postToGet($requestData);
        }

        return $gpUrl;
    }

    /**
     * Enter description here...
     *
     * @param string $url
     * @param string $contimeout
     * @param string $timeout
     * @param string $post
     * @param array  $postData
     *
     * @return string
     * @access public
     */
    public function getCurlContent($url, $contimeout, $timeout, $post = 0, array $postData = array())
    {
        //set User agent for Request to Firefox 3
        $user_agent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.9) Gecko/2008052906 Firefox/3.0';
        // define headers for request
        $header     = array(
            "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.3",
            "Accept-Language: de-de,de;q=0.7,en-us;q=0.5,en;q=0.3",
            "Accept-Charset: iso-8859-1,utf-8;q=0.7,*;q=0.7",
            "Keep-Alive: 300"
        );

        //IP-Adresse und User-agenten des Nutzers an Service weiterleiten
        if ($post) {
            $postData['IP']     = urlencode($_SERVER['REMOTE_ADDR']);
            $postData['Agent']  = urlencode($_SERVER['HTTP_USER_AGENT']);
            $postData['portal'] = urlencode($_SERVER['HTTP_HOST']);
        } else {
            $url  = $this->postToGetUrl($url, $postData);

            if (strpos($url, '?', 0) === false) {
                $url .= '?';
            } else {
                $url .= '&';
            }

            $url .= 'IP=' . urlencode($_SERVER['REMOTE_ADDR'])
                  . '&Agent=' . urlencode($_SERVER['HTTP_USER_AGENT'])
                  . '&portal=' . urlencode($_SERVER['HTTP_HOST']);
        }

        //var_dump($url);

        $ch = curl_init($url);

        //Session Optionen setzen
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $contimeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, $post);
        if ($post) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        if (isset($_SERVER['HTTP_REFERER'])) {
            curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);
        }

        //Ausfuehren der Aktionen
        $rtn = curl_exec($ch);
        //var_dump(curl_error($ch));
        if (strlen(curl_error($ch)) > 0) {
            //var_dump($ch);
            //var_dump(curl_error($ch));
            $rtn = curl_error($ch);
        }

        //Session beenden
        curl_close($ch);

        //var_dump($rtn);

        return $rtn;
    }

    protected function ia2xml(array $array, $level = 0)
    {
        $xml    = "";
        $level2 = $level + 1;

        foreach ($array as $key => $value) {
            //var_dump($value);
            if (is_array($value)) {
                $xml.='<' . $key . '>'.$this->ia2xml($value, $level2).'</' . $key . '>';
            } elseif (is_object($value)) {
                $class = get_class($value);
                if ($class == 'SimplexmlElement') {
                    $xml.='<' . $key . '>'.$value->asXML().'</' . $key . '>';
                } elseif (method_exists($value, 'toArray')) {
                    $xml.='<' . $key . '>'.$this->ia2xml($value->toArray(), $level2).'</' . $key . '>';
                } else {
                    $xml.='<' . $key . '>'.$this->ia2xml((array) $value, $level2).'</' . $key . '>';
                }
            } elseif ($value == '') {
                $xml.='<' . $key . '/>';
            } else {
                //var_dump($value);
                if (is_string($value)) {
                    $this->decode_array($value);
                    //var_dump($value);
                    if (version_compare(PHP_VERSION, '5.2.3', '>')) {
                        $value = htmlentities($value, ENT_QUOTES, 'ISO-8859-1', false);
                    } else {
                        $value = htmlentities($value, ENT_QUOTES, 'ISO-8859-1');
                    }
                    //var_dump($value);
                    $value = str_replace('€', '&amp;euro;', $value);
                    $value = str_replace('&amp;amp;amp;', '&amp;amp;', $value);
                    $value = str_replace('&amp;amp;uuml;', '&amp;uuml;', $value);
                    $value = str_replace('&amp;amp;auml;', '&amp;auml;', $value);
                    $value = str_replace('&amp;amp;ouml;', '&amp;ouml;', $value);
                    $value = str_replace('&amp;amp;szlig;', '&amp;szlig;', $value);
                    $value = str_replace('&amp;amp;Uuml;', '&amp;Uuml;', $value);
                    $value = str_replace('&amp;amp;Auml;', '&amp;Auml;', $value);
                    $value = str_replace('&amp;amp;Ouml;', '&amp;Ouml;', $value);
                    //var_dump($value);
                }

                $xml  .= '<' . $key . '>' . $value . '</' . $key . '>';
            }
        }

        return $xml;
    }

    /**
     * Enter description here...
     *
     * @param array $data
     *
     * @return string
     * @access public
     */
    public function serializeXml(array $data)
    {
        $xmlString = '<result />';

        try {
            if (is_array($data)) {
                $xmlString = $this->ia2xml($data);
            } else {
                $xmlString = '';
            }
            $xmlString = "<?xml version='1.0'?><result>" . $xmlString . "</result>";
            //var_dump($xmlString);
        } catch (Exception $e) {
            trigger_error($e->getMessage() . "['$xmlString']", E_USER_NOTICE);
            return "<?xml version='1.0'?><result />";
        }

        try {
            $xml = new SimpleXMLElement($xmlString);
        } catch (Exception $e) {
            trigger_error($e->getMessage() . "['$xmlString']", E_USER_NOTICE);
            return "<?xml version='1.0'?><result />";
        }

        return $xml->asXML();
    }
}