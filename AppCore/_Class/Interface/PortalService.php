<?php
/**
 * Soap-Interface for Portaservice
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Interface
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * Soap-Interface for Portalservice
 *
 * @category  Kreditrechner
 * @package   Interface
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditCore_Class_Interface_PortalService
{
    private $_customerId = null;

    private $_portal = null;

    private $_customer = null;

    private $_data = array();

    private $_wsdl = '';

    /**
     * a interface specific object to send the request
     *
     * @var    object
     * @access protected
     */
    private $_sender = null;

    /**
     * @var \Zend\Log\Logger
     */
    private $_logger = null;

    /**
     * @param string            $portal   the portal name
     * @param Zend_Db_Table_Row $customer the customer dataset
     *
     * @return KreditCore_Class_Interface_PortalService
     * @throws KreditCore_Class_Exception
     */
    public function __construct($portal, Zend_Db_Table_Row $customer)
    {
        if (empty($portal) || !is_string($portal)) {
            throw new KreditCore_Class_Exception(
                'a portal name is needed as first parameter'
            );
        }

        if (empty($customer)) {
            throw new KreditCore_Class_Exception(
                'a Zend_Db_Table_Row object is needed as second ' .
                'parameter'
            );
        }

        $config        = \Zend\Registry::get('_config');
        $this->_wsdl   = $config->interfaces->portalservice->wsdl;
        $this->_sender = new Zend_Soap_Client();

        /*
         * timeout requires PHP 5.2.1 to work
         * @see http://de2.php.net/manual/de/context.http.php
         */
        $context = stream_context_create(
            array('http' => array('timeout' => 5))
        );

        $this->_sender->setStreamContext($context);
        $this->_sender->setWsdl($this->_wsdl);
        $this->_sender->setCompressionOptions(SOAP_COMPRESSION_ACCEPT);
        $this->_sender->setEncoding('ISO-8859-1');

        $this->_portal   = $portal;
        $this->_customer = $customer;

        $this->_logger = \Zend\Registry::get('log');
    }

    /**
     * adds a new customer
     *
     * @return KreditCore_Class_Interface_PortalService
     */
    public function addCustomer()
    {
        //fill the data array
        $data = array(
            'sPortal_Alias' => $this->_portal,
            'pCustomer_Customer' => array(
                'sName'         => $this->_customer->Nachname,
                'sVorname'      => $this->_customer->Vorname,
                'sAnrede'       => $this->_customer->Anrede,
                'sPLZ'          => $this->_customer->Plz,
                'sOrt'          => $this->_customer->Ort,
                'sStrasse'      => $this->_customer->Strasse,
                'sHausnummer'   => $this->_customer->Hausnummer,
                'dGeburtsdatum' => $this->_mapDate(
                    $this->_customer->GeburtsDatum
                ),
                'sKundenID'     => (int) $this->_customer->KundeId,
                'sBeruf'        => $this->_customer->BerufsStatus,
                'sEmail'        => $this->_customer->EMail1,
                'iGeschlecht'   => (($this->_customer->Anrede == 'Herr')
                                ? 'GENDER_male' :
                                (($this->_customer->Anrede == 'Frau')
                                ? 'GENDER_female' : 'GENDER_unknown'))
            )
        );

        if (isset($this->_customer->Titel) && '' != $this->_customer->Titel) {
            $data['pCustomer_Customer']['sTitel'] = $this->_customer->Titel;
        }

        if (isset($this->_customer->land)  && '' != $this->_customer->land) {
            $data['pCustomer_Customer']['sLand'] = $this->_customer->land;
        } else {
            $data['pCustomer_Customer']['sLand'] = 'DE';
        }

        $this->_data['AddCustomer']['request'] = $data;

        try {
            // do the request
            $result = $this->_sender->AddCustomer($data);
        } catch (Exception $e) {
            $this->_logger->err($e);

            $this->_customerId = null;

            return $this;
        }

        $this->_data['AddCustomer']['result'] = $result;

        /*
         * if this function succeded, the result is exactly 36 characters long
         */
        if (36 != strlen($result->AddCustomerResult)) {
            /*
             * the returned result includes an error message which is added
             * after the "normal" result
             */
            $this->_customerId = null;
            $errorMessage      = substr($result->AddCustomerResult, 36);

            $message = __FILE__ . ' line ' . __LINE__ . ' => Message:'
                     . 'Fehler bei SOAP-Übertragung an PortalService: '
                     . $errorMessage . "\n" . 'Daten: '
                     . print_r($data, true);

            $this->_storeError(
                'AddCustomer', __FILE__, __LINE__, $message
            );

            return $this;
        } else {
            $id = $result->AddCustomerResult;
        }

        if (null !== $id && !$result->AddCustomerResult) {
            $message = __FILE__ . ' line ' . __LINE__ . ' => Message:'
                     . "\n AddCustomerResult failed\n" . 'Daten: '
                     . print_r($data, true);

            $this->_storeError(
                'AddCustomer', __FILE__, __LINE__, $message
            );
        }

        /*
         * store the customer number
         * its needed in the other methods
         */
        $this->_customerId = $id;

        if (null === $this->_customerId
            || '00000000-0000-0000-0000-000000000000' == $this->_customerId
        ) {
            $message = 'the Customer wasn\'t added, some data are not legal: '
                     . print_r($data, true);

            $this->_storeError(
                'AddCustomer', __FILE__, __LINE__, $message
            );
        } else {
            $this->_data['AddCustomer']['customerId'] = $this->_customerId;
        }

        return $this;
    }

    /**
     * adds a phone number to an customer
     *
     * @param string $phoneNumber
     *
     * @return boolean TRUE, if the request was successful
     * @access public
     */
    public function addCustomerPhoneNumber($phoneNumber = '')
    {
        if (!$this->_isOk()) {
            return false;
        }

        $data = array(
            'sPortal_Alias' => $this->_portal,
            'gCustomer_FK'  => $this->_customerId,
            'sPhonenumber'  => $phoneNumber
        );

        $this->_data['AddCustomerPhoneNumber']['request'] = $data;

        try {
            $result = $this->_sender->AddCustomerPhoneNumber($data);
        } catch (\Zend\Exception $e) {
            $this->_logger->err($e);

            return false;
        }

        $this->_data['AddCustomer']['result'] = $result;

        if (!$result->AddCustomerPhoneNumberResult) {
            $message = __FILE__ . ' line ' . __LINE__ . ' => Message:'
                     . "\nAddCustomerPhoneNumber failed\n" . 'Daten: '
                     . print_r($data, true);

            $this->_storeError(
                'AddCustomerPhoneNumber', __FILE__, __LINE__, $message
            );
        }

        return $result->AddCustomerPhoneNumberResult;
    }

    /**
     * adds several data to an customer
     *
     * @param array $data the data to add as array with key->value pairs
     *
     * @return boolean TRUE, if the request was successful
     */
    public function addExtensionData(array $data = array())
    {
        if (!$this->_isOk()) {
            return false;
        }

        $results = array();
        $data    = \AppCore\Globals::combineArrayKeys($data);
        $data    = $this->_mapData($data);

        //set default values if not available
        if (!isset($data['kn1.agbeinv'])) {
            $data['kn1.agbeinv'] = '0';
        }
        if (!isset($data['kn1.mehrantrag'])) {
            $data['kn1.mehrantrag'] = '0';
        }

        $results = $this->_addMultiExtensionData($data);

        return $results;
    }

    /**
     * transmits multiple data at once to Portalservice
     *
     * @param array $values the data to transmit
     *
     * @return mixed
     */
    private function _addMultiExtensionData(array $values = array())
    {
        $data = array(
            'sPortal_Alias'             => $this->_portal,
            'gCustomer_FK'              => $this->_customerId,
            'a_pKeyValue_ExtensionData' => array()
        );

        $i = 0;
        foreach ($values as $key => $value) {
            $data['a_pKeyValue_ExtensionData']['pKeyValue'][$i++] = array(
                'sKey'   => $key,
                'sValue' => $value
            );
        }

        $this->_data['AddExtensionData_Bulk']['request'] = $data;

        try {
            $result = $this->_sender->AddExtensionData_Bulk($data);
        } catch (\Zend\Exception $e) {
            $this->_logger->err($e);

            return false;
        }

        $this->_data['AddExtensionData_Bulk']['result'] = $result;

        if (in_array(false, $result->AddExtensionData_BulkResult->boolean)) {
            $message = __FILE__ . ' line ' . __LINE__ . ' => Message:'
                     . "\nAddExtensionData_Bulk failed\n" . 'Daten: '
                     . print_r($data, true);

            $this->_storeError(
                'AddExtensionData_Bulk', __FILE__, __LINE__, $message
            );
        }

        return $result->AddExtensionData_BulkResult->boolean;
    }

    /**
     * finishs the data transfer for an customer
     *
     * @param mixed   $callTime
     * @param boolean $isTest
     *
     * @return boolean TRUE, if the request was successful
     */
    public function finishCustomer($callTime, $isTest = 0)
    {
        if (!$this->_isOk()) {
            return false;
        }

        $data = array(
            'sPortal_Alias' => $this->_portal,
            'gCustomer_FK'  => $this->_customerId,
            'CallTime'      => date('Y-m-d\TH:i:s\Z', $callTime),
            'bTest'         => (boolean) $isTest
        );

        $this->_data['FinishCustomer']['request'] = $data;

        try {
            $result = $this->_sender->FinishCustomer($data);
        } catch (\Zend\Exception $e) {
            $this->_logger->err($e);

            return false;
        }

        if (!$result->FinishCustomerResult) {
            $message = __FILE__ . ' line ' . __LINE__ . ' => Message:'
                     . "\nFinishCustomer failed\n" . 'Daten: '
                     . print_r($data, true);

            $this->_storeError('FinishCustomer', __FILE__, __LINE__, $message);
        }

        $this->_data['FinishCustomer']['result'] = $result;

        return $result->FinishCustomerResult;
    }

    /**
     * maps data which are ID-based to their values
     *
     * @param array $data the data to map
     *
     * @return array
     */
    private function _mapData(array $data)
    {
        $newData = array();

        foreach ($data as $key => $value) {
            $keyForSwitch  = substr($key, 4);
            $newData[$key] = $this->_mapDataSingle($keyForSwitch, $value);
        }

        return $newData;
    }

    /**
     * maps data which are ID-based to their values
     *
     * @param string         $key
     * @param string|integer $value
     *
     * @return string|integer
     */
    private function _mapDataSingle($key, $value)
    {
        switch ($key) {
            case 'berufsgruppe':
                $value = \AppCore\Globals::getBerufsgruppe(
                    $value, false
                );
                break;
            case 'nationality':
                if (isset(\AppCore\Globals::$generalStates[$value])) {
                    $value = \AppCore\Globals::$generalStates[$value];
                }
                break;
            case 'branche':
                $value = \AppCore\Globals::getBranche($value);
                break;
            case 'wohneigentum':
                $value = \AppCore\Globals::getWohneigentum($value);
                break;
            case 'wohnsituation':
                $value = \AppCore\Globals::getWohnsituation($value);
                break;
            case 'familie':
                $value = \AppCore\Globals::getFamilyState($value);
                break;
            case 'hatec':
                switch ($value) {
                    case 'ec':
                        $value = 'EC-Karte(n)';
                        break;
                    case 'kk':
                        $value = 'Kreditkarte(n)';
                        break;
                    case 'eckk':
                        $value = 'EC- und Kreditkarte(n)';
                        break;
                    default:
                        $value = 'keine';
                        break;
                }
                break;
            case 'kredit.0.Art':
                // Break intentionally omitted
            case 'kredit.1.Art':
                // Break intentionally omitted
            case 'kredit.2.Art':
                // Break intentionally omitted
            case 'kredit.3.Art':
                // Break intentionally omitted
            case 'kredit.4.Art':
                // Break intentionally omitted
            case 'kredit.U.Art':
                switch ((int)$value) {
                    case 1:
                        $value = 'Konsumentenkredit';
                        break;
                    case 2:
                        $value = 'Rahmenkredit';
                        break;
                    case 3:
                        $value = 'Abrufkredit';
                        break;
                    case 4:
                        $value = 'Dispositionskredit';
                        break;
                    case 5:
                        $value = 'Kreditkarte';
                        break;
                    case 6:
                        $value = 'Autokredit';
                        break;
                    case 7:
                        $value = 'Leasing';
                        break;
                    case 8:
                        $value = 'Arbeitgeberdarlehen';
                        break;
                    case 9:
                        $value = '0%-Finanzierung';
                        break;
                    default:
                        $value = '';
                        break;
                }
                break;
            default:
                // nothing to do here
                break;
        }

        return $value;
    }

    /**
     * get the customer id
     *
     * @return null|string
     */
    public function getCustomerId()
    {
        if (null === $this->_customerId
            || '00000000-0000-0000-0000-000000000000' == $this->_customerId
        ) {
            return null;
        } else {
            return $this->_customerId;
        }
    }

    /**
     * get the data which were transmitted to Portalservice with status messages
     *
     * @return array
     */
    public function getTransmittedData()
    {
        return $this->_data;
    }

    /**
     * build an ISO 8601 compliant date string
     *
     * @param integer $hour   die Stunde
     * @param integer $minute
     * @param integer $second
     * @param integer $month
     * @param integer $day
     * @param integer $year
     *
     * @return string
     */
    private function _timestampToIso(
        $hour, $minute, $second, $month, $day, $year)
    {
        $datestr = sprintf(
            '%04d-%02d-%02dT%02d:%02d:%02dZ',
            $year, $month, $day, $hour, $minute, $second
        );

        return $datestr;
    }

    /**
     * splits a given date string into three parts (day, month, year) and
     * creates a iso date string from that
     *
     * @param string $date a date string in the format yyyy-mm-dd
     *
     * @return string
     */
    private function _mapDate($date)
    {
        $split = explode('-', $date);

        // map the date values
        $year = ((isset($split[0]) && (int) $split[0] >= 1900)
              ? (int) $split[0]
              : 1900);

        $month = ((isset($split[1]) && (int) $split[1] > 0)
               ? (int) $split[1]
               : 1);

        $day = ((isset($split[2]) && (int) $split[2] > 0)
             ? (int) $split[2]
             : 1);

        return $this->_timestampToIso(0, 0, 0, $month, $day, $year);
    }

    /**
     * stores an error message into the data array and outputs the message to
     * the logger
     *
     * @param string  $function
     * @param string  $file
     * @param integer $line
     * @param string  $errorMessage
     *
     * @return void
     */
    private function _storeError($function, $file, $line, $errorMessage)
    {
        if ('TESTPORTAL' == $this->_portal) {
            return;
        }

        $this->_data[$function]['message'][] = $errorMessage;

        $message = $file . ' line ' . $line . ' => Message:'
                         . 'Fehler bei SOAP-Übertragung an PortalService: '
                         . $errorMessage;

        $this->_logger->err($message);
    }

    /**
     * checks, if the first step was successfull
     *
     * @return boolean
     */
    private function _isOk()
    {
        if ('TESTPORTAL' == $this->_portal) {
            return true;
        }

        if ((null === $this->_customerId
            || '00000000-0000-0000-0000-000000000000' == $this->_customerId)
        ) {
            return false;
        }

        return true;
    }
}