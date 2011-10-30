<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Validate
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/**
 * @see Zend_Validate_EmailAddress
 */
require_once LIB_PATH . 'Zend' . DS . 'Validate' . DS . 'EmailAddress.php';

/**
 * @category   Zend
 * @package    Zend_Validate
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Unister_Finance_Validate_EmailAddress extends Zend_Validate_EmailAddress
{
    /**
     * Instantiates hostname validator for local use
     *
     * You can pass a bitfield to determine what types of hostnames are allowed.
     * These bitfields are defined by the ALLOW_* constants in Zend_Validate_Hostname
     * The default is to allow DNS hostnames only
     *
     * @param integer                $allow             OPTIONAL
     * @param bool                   $validateMx        OPTIONAL
     * @param Zend_Validate_Hostname $hostnameValidator OPTIONAL
     * @return void
     */
    public function __construct($allow = Zend_Validate_Hostname::ALLOW_DNS, $validateMx = false, Zend_Validate_Hostname $hostnameValidator = null)
    {
        parent::__construct(Zend_Validate_Hostname::ALLOW_ALL, $this->validateMxSupported(), null);
    }
}