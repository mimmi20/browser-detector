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
 * @version   SVN: $Id: GetParam.php 24 2011-02-01 20:55:24Z tmu $
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
class CheckParam extends \Zend\Controller\Action\Helper\AbstractHelper
{
    /**
     * Default-Methode für Services
     *
     * wird als Alias für die Funktion {@link log} verwendet
     *
     * @return null|array
     */
    public function direct($value, $default, $validator = null)
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
            $value = $this->getActionController()->getHelper('Decode')->direct(strip_tags(trim($value)), false);
        }

        if (is_subclass_of($validator, '\\Zend\\Validator\\Abstract')) {
            if (!$validator->isValid($value)) {
                return $default;
            }
        }
        
        return $value;
    }
}