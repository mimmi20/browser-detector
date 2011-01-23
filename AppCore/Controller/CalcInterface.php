<?php
declare(ENCODING = 'iso-8859-1');
namespace Credit\Core\Controller;

/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @license   http://www.unister.de  Unister License
 * @version   SVN: $Id: CalcInterface.php 30 2011-01-06 21:58:02Z tmu $
 * @link      todo
 */

/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
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