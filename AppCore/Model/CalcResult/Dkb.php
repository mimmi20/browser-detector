<?php
declare(ENCODING = 'iso-8859-1');
namespace Credit\Core\Model\CalcResult;

/**
 * the CalcResult is a virtual/temporary Table, which represents the result of
 * a calculation for credits or other finacial products in this application
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Dkb.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * the CalcResult is a virtual/temporary Table, which represents the result of
 * a calculation for credits or other finacial products in this application
 *
 * because the CalcResult is a virtual/temporary Table, it is not possible
 * to add or change the result rows and store them
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Dkb extends \Credit\Core\Model\CalcResult
{
    /**
     * checks if the result is valid
     *
     * validates the result against the requirements of the institutes, if
     * there are any
     *
     * @return boolean TRUE if completely successful,
     *                 FALSE if partially or not succesful.
     * @access public
     */
    public function isValid()
    {
        return true;
    }

    /**
     * checks if the institute is able to handle the forms of unister
     *
     * @return boolean TRUE if the internal forms are possible,
     *                 FALSE otherwise.
     * @access public
     */
    public function canInternal()
    {
        return true;
    }

    /**
     * checks if the institute is able to load the institute site
     *
     * @return boolean TRUE if the institute site is possible,
     *                 FALSE otherwise.
     * @access public
     */
    public function canExternal()
    {
        return true;
    }
}