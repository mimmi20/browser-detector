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
 * @version   SVN: $Id: GetParam.php 30 2011-01-06 21:58:02Z tmu $
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
        return $this->getParam($paramName, $default, $validator);
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
    public function getParam(
        $paramName = null,
        $default = null,
        $validator = null)
    {
        return \AppCore\Globals::getParamFromArray(
            $this->getRequest()->getParams(),
            $paramName,
            $default,
            $validator
        );
    }
}