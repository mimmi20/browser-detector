<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Plugin;

/**
 * ActionHelper Class to detect the user agent and to set actions according to
 * it
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Params.php 46 2011-08-10 18:50:42Z tmu $
 */
 
use Zend\Controller\Request;
use Zend\Controller\Plugin\AbstractPlugin;

/**
 * ActionHelper Class to detect the user agent and to set actions according to
 * it
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Params extends AbstractPlugin
{
    /**
     * @var array
     */
    private $_requestData = array();

    private $_logger = null;
    
    private $_config = null;

    /**
     * Class constructor
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
		$this->_config = \Zend\Registry::get('_config');
		$this->_logger = \Zend\Registry::get('log');
    }

    /**
     * Called after Zend_Controller_Router exits.
     *
     * Called after Zend_Controller_Front exits from the router.
     *
     * @param  \Zend\Controller\Request\AbstractRequest $request
     * @return void
     */
    public function routeShutdown(Request\AbstractRequest $request)
    {
        $request = $this->getRequest();

        $this->_requestData = $request->getParams();

        $keys = array_keys($this->_requestData);

        /*
         * delete the super globals
         */
        $_GET     = array();
        $_POST    = array();
        $_REQUEST = array();

        $encoding = $this->_setEncoding();

        mb_internal_encoding($encoding);
        mb_regex_encoding($encoding);

        foreach ($keys as $paramName) {
            $_SESSION->$paramName = $this->_getParamFromNameAndConvert($paramName, $encoding);
        }

        $_SESSION->encoding = $encoding;
	}

    /**
     * Gets a parameter from the {@link $_request Request object}. If the
     * parameter does not exist, NULL will be returned.
     *
     * If the parameter does not exist and $default is set, then
     * $default will be returned instead of NULL.
     *
     * If $validator is set, the value of the parameter will be validated. If
     * the validation fails, $default will be returned.
     * The following values are possible as $validator:
     * 1 a string containing an type, if you want to use an Zend_Validator
     *   object e.g. 'Int' for using \Zend\Validator\Int'
     * 2 a string containing an type, with an underscore added as first
     *   character, if you want to use a custom validator
     *   e.g. '_\\AppCore\\Class\Validate\Plz'
     * 3 an validator object
     * 4 an array containing strings or objects like in numbers 1-3
     *
     * @param string $paramName   the name of the param
     * @param mixed  $default     the default value
     * @param mixed  $validator   the type for an validator, an validator object
     *                            or an array of validatortypes/validatorobjects
     *
     * @return mixed
     */
    private function _getParamFromNameAndConvert(
        $paramName = null,
        $encoding = null,
        $default = null,
        $validator = null,
        &$changed = false)
    {
        if ($paramName === null || count($this->_requestData) == 0) {
            return $default;
        }

        if (!isset($this->_requestData[$paramName])
            || $this->_requestData[$paramName] === null
        ) {
            return $default;
        }
        
        $check = true;

        if (is_object($this->_requestData[$paramName])) {
            $value = $this->_requestData[$paramName];
            $check = false;
        } elseif (is_array($this->_requestData[$paramName])) {
            $value = array_pop($this->_requestData[$paramName]);
        } else {
            $value = $this->_requestData[$paramName];
        }

        $value = $this->_checkAllParams(
            $this->_cleanParamAndConvert($value, $encoding),
            $default,
            $this->_defineValidators($validator)
        );
        
        return $this->_getParamFromSession($paramName, $value, $changed);
    }
    
    /**
     * TODO:
     *
     * @param string $paramName   the name of the param
     * @param mixed  $default     the default value
     *
     * @return mixed
     */
    private function _getParamFromSession($paramName, $default = null, &$changed = false)
    {
        $param = $default;
        
        if (!isset($_SESSION->$paramName) 
            || null === $_SESSION->$paramName 
            || $param != $_SESSION->$paramName
        ) {
            $_SESSION->$paramName = $param;
            
            $message = "param '" . $paramName . "' not taken from session";
            $changed = true;
        } else {
            $param   = $_SESSION->$paramName;
            $message = "took param '" . $paramName . "' from session";
        }
        
        if (!isset($_SESSION->messages)) {
            $_SESSION->messages = array();
        }
        
        $_SESSION->messages[] = $message;
        $this->_logger->debug($message);
        
        return $param;
    }

    /**
     * defines a Zend_Validate object based on $validator
     *
     * @param mixed $validator
     *
     * @return Zend_Validate|null
     */
    private function _defineValidators($validator)
    {
        //create Validator Object, if Validator Type is set
        if ($validator === null) {
            return null;
        }

        if (is_object($validator)
            && is_subclass_of($validator, '\\Zend\\Validator\\AbstractValidator')
        ) {
            //nothing to change
            return $validator;
        }

        if (is_string($validator)) {
            if (substr($validator, 0, 1) == '_') {
                $validatorTwo = substr($validator, 1);
            } else {
                $validatorTwo = '\\Zend\\Validator\\' . $validator;
            }

            return new $validatorTwo();
        }

        if (is_array($validator)) {
            $validatorBase = $validator;
            $validator     = new \Zend\Validator\ValidatorChain();

            foreach ($validatorBase as $sValidatorName) {
                if (is_string($sValidatorName)) {
                    if (substr($sValidatorName, 0, 1) == '_') {
                        $validatorTwo = substr($sValidatorName, 1);
                    } else {
                        $validatorTwo = '\\Zend\\Validator\\' . $sValidatorName;
                    }
                    $validator->addValidator(new $validatorTwo());
                } elseif (is_object($sValidatorName)
                    && is_subclass_of($sValidatorName, '\\Zend\\Validator\\AbstractValidator')
                ) {
                    $validator->addValidator($sValidatorName);
                }
            }

            return $validator;
        } else {
            return null;
        }
    }
	
    /**
     * Default-Methode für Services
     *
     * wird als Alias für die Funktion {@link log} verwendet
     *
     * @return null|array
     */
    private function _checkAllParams($value, $default, $validator = null)
    {
        if (is_object($value)) {
            /* 
             * no handling for objects here
             * -> TODO: implement somewhere
             */
            return $value;
        }

        if (is_array($value)) {
            $data = array();
            $keys = array_keys($value);

            foreach ($keys as $keyTwo) {
                $data[$keyTwo] = $this->_checkParam(
                    $value[$keyTwo],
                    $default,
                    $validator
                );
            }
        } else {
            $data = $this->_checkParam(
                $value,
                $default,
                $validator
            );
        }
        
        return $data;
    }

    /**
     * validates the value
     *
     * @param string                 $value     the value to check
     * @param string                 $paramName the name of the variable
     * @param mixed                  $default   the default value, if the given
     *                                          value is not valid
     * @param \Zend\Validator\Abstract $validator
     *
     * @return string
     */
    private function _checkParam(
        $value, $default, $validator = null)
    {
        $value = strip_tags(trim($value));
        
        if ('' != $value) {
            $value = $this->_decode(strip_tags(trim($value)), false);
        }

        if (is_subclass_of($validator, '\\Zend\\Validator\\Abstract')) {
            if (!$validator->isValid($value)) {
                return $default;
            }
        }
        
        return $value;
    }

    /**
     * decodes an value from utf-8 to iso
     *
     * @param string  $text     the string to decode
     * @param boolean $entities an flag,
     *                          if TRUE the string will be encoded with
     *                          htmlentities
     *
     * @return string
     * @access public
     * @static
     */
    private function _decode($text, $entities = true)
    {
        if (is_string($text) && $text != '') {
            $encoding = mb_detect_encoding($text . ' ', 'UTF-8,ISO-8859-1');

            if ('UTF-8' == $encoding) {
                $text = utf8_decode($text);
            }

            if ($entities) {
                $text = htmlentities($text, ENT_QUOTES, 'iso-8859-1', true);
            }
        }

        return $text;
    }

    /**
     * clean Parameters taken from GET or POST Variables
     *
     * @return string
     */
    private function _cleanParamAndConvert($param, $encoding = null)
    {
        if (true === $param
            || false === $param
            || is_object($param)
        ) {
            return $param;
        }
        
        if (is_array($param)) {
            $keys = array_keys($param);
            
            foreach ($keys as $key) {
                $param[$key] = $this->_cleanParamAndConvert($param[$key], $encoding);
            }
        }
        
        if (null !== $encoding) {
            $param = iconv(strtoupper($encoding), 'UTF-8//TRANSLIT//IGNORE', $param);
        }

        return strip_tags(trim(urldecode(stripslashes($param))));
    }
    
    private function _setEncoding()
    {
        $allowedEncodings = array('iso-8859-1', 'iso-8859-15', 'utf-8', 'utf-16');

        //default encoding is defined in config
        $encoding = ((isset($this->_config->encoding))
                  ? $this->_config->encoding
                  : 'utf-8');

        //encoding is requested from portal
        if (isset($this->_requestData['encoding'])
            && is_string($this->_requestData['encoding'])
        ) {
            $encoding = $this->_getEncoding($this->_requestData['encoding']);
        }

        if (!in_array($encoding, $allowedEncodings)) {
            $encoding = 'iso-8859-1';
        }
        
        return $encoding;
    }
    
    private function _getEncoding($encodingParam)
    {
        switch ($encodingParam) {
            case 'iso-8859-15':
            case 'iso15':
                $encoding = 'iso-8859-15';
                break;
            case 'utf-16':
            case 'utf16':
                $encoding = 'utf-16';
                break;
            case 'iso-8859-1':
            case 'iso':
                $encoding = 'iso-8859-1';
                break;
            case 'utf-8':
            case 'utf8':
            default:
                $encoding = 'utf-8';
                break;
        }
        
        return $encoding;
    }
}