<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Service;

/**
 * Service
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Services
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
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
     * @return \\AppCore\\Service\InstituteLog
     */
    public function __construct()
    {
        $this->_model = new \AppCore\Model\InstituteLog();
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
        $institut = new \AppCore\Service\Institute();
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
     * @return \\AppCore\\Service\InstituteLog
     */
    public function cleanCache()
    {
        return $this->cleanTaggedCache('instituteLog');
    }
}