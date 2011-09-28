<?php
declare(ENCODING = 'utf-8');
namespace AppCore\Controller;

/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * PHP version 5
 *
 * @category  CreditCalc
 * @package   Controller
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 * @license   http://www.unister.de  Unister License
 * @version   SVN: $Id$
 * @link      todo
 */

/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * @category  CreditCalc
 * @package   Controller
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 * @license   http://www.unister.de  Unister License
 * @link      todo
 * @abstract
 */
interface CalcInterface
{
    /**
     * indexAction-Methode wird aufgerufen wenn keine Action angegeben wurde
     *
     * @return void
     * @access public
     */
    public function indexAction();

    /**
     * starts an recalculation
     *
     * @return void
     * @access public
     */
    public function calcAction();

    /**
     * get the information about an institute and its credits
     *
     * @return void
     * @access public
     */
    public function antragAction();

    /**
     * get the information about an institute and its credits
     *
     * @return void
     * @access public
     */
    public function infoAction();

    /**
     * recreates the credit form for an recalculation
     *
     * @return void
     * @access public
     */
    public function formAction();

    /**
     * logs Clicks into the database
     *
     * @return void
     * @access public
     */
    public function validateAction();
}