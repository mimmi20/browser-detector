<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Model\CalcResult\Ingdiba;

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
 * @version   SVN: $Id: auto.php 30 2011-01-06 21:58:02Z tmu $
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
 * @deprecated
 */
class auto extends \AppCore\Model\CalcResult\Ingdiba
{
    //nothing to do here
}