<?php
declare(ENCODING = 'iso-8859-1');
namespace Credit\Core\Service;

/**
 * Service
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Services
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: InstituteLog.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Service
 *
 * @category  Kreditrechner
 * @package   Services
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class InstituteLog extends ServiceAbstract
{
    /**
     * Class Constructor
     *
     * @return \Credit\Core\Service\InstituteLog
     */
    public function __construct()
    {
        $this->_model = new \Credit\Core\Model\InstituteLog();
    }

    /**
     * returns the Color for a given Institute
     *
     * @param integer $kiId the Institute ID
     *
     * @return string the color
     * @access public
     */
    public function getInstituteColor($kiId)
    {
        $institut = new \Credit\Core\Service\Institute();
        return $institut->getColor($kiId);
    }

    /**
     * liefert die ID eines Types
     *
     * @param mixed $value ID oder Name des Types
     *
     * @return boolean|integer FALSE, wenn die Sparte nicht existiert,
     *                         ansonsten die ID der Sparte
     * @access protected
     */
    public function getId($value)
    {
        return $this->_model->getCached('instituteLog')->getId($value);
    }

    /**
     * cleans the model cache
     *
     * calls the {@link _cleanCache} function with defined tag name
     *
     * @return \Credit\Core\Service\InstituteLog
     */
    public function cleanCache()
    {
        return $this->cleanTaggedCache('instituteLog');
    }
}