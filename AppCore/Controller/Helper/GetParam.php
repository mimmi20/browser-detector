<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Controller\Helper;

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
 * @version   SVN: $Id$
 */

/**
 * ActionHelper Class to detect the user agent and to set actions according to
 * it
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class GetParam extends \Zend\Controller\Action\Helper\AbstractHelper
{
    /**
     * Class constructor
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->_logger = \Zend\Registry::get('log');
    }
    
    /**
     * Default-Methode für Services
     *
     * wird als Alias für die Funktion {@link log} verwendet
     *
     * @return null|array
     */
    public function direct(
        $paramName = null,
        $default = null,
        $validator = null)
    {
        return $this->getParamFromName($paramName, $default, $validator);
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
    public function getParamFromName(
        $paramName = null,
        $default = null,
        $validator = null,
        &$changed = false)
    {
        $requestData = $this->getRequest()->getParams();
        
        if ($paramName === null || count($requestData) == 0) {
            return $default;
        }

        if (!isset($requestData[$paramName])
            || $requestData[$paramName] === null
        ) {
            return $default;
        }
        
        $check = true;

        if (is_object($requestData[$paramName])) {
            $value = $requestData[$paramName];
            $check = false;
        } elseif (is_array($requestData[$paramName])) {
            $value = array_pop($requestData[$paramName]);
        } else {
            $value = $requestData[$paramName];
        }

        $value = $this->getActionController()->getHelper('checkParam')->direct(
            $this->_cleanParam($value),
            $default,
            $this->_defineValidators($validator)
        );
        
        return $this->_getParamFromSession($paramName, $value, $changed);
    }

    /**
     * clean Parameters taken from GET or POST Variables
     *
     * @return string
     */
    private function _cleanParam($param)
    {
        if (true === $param
            || false === $param
            || is_object($param)
            || is_numeric($param)
        ) {
            return $param;
        }
        
        if (is_array($param)) {
            return array_map(array($this, '_cleanParam'), $param);
        }

        return strip_tags(trim(urldecode(stripslashes($param))));
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
}