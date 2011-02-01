<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Credit;

/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Output
{
    CONST FALLBACK = 0;
    CONST JS = 1;
    //CONST HTML = 2; //@deprecated
    //CONST XML = 3;  //@deprecated
    CONST IFRAME = 4;
    CONST CURL = 5;

    private $_mode = 0;

    private $_formater = null;

    /**
     * the class constructor
     *
     * @param integer|string $mode the working mode for the output formater
     *
     * @return void
     * @access public
     */
    public function __construct($mode = null)
    {
        if (null === $mode) {
            $mode = self::FALLBACK;
            $this->setMode($mode);
        } elseif (is_string($mode)) {
            $this->setModeName($mode);
        } else {
            $this->setMode($mode);
        }
    }

    /**
     * the class destructor
     *
     * @return void
     * @access public
     */
    public function __destruct()
    {
        if ($this->_formater !== null) {
            unset($this->_formater);
        }
    }

    /**
     * __call-Methode wird aufgerufen wenn keine Action angegeben wurde
     *
     * @param string $m the called method
     * @param array  $a the given parameters
     *
     * @access public
     * @return void
     * @throws \Zend\Exception
     */
    public function __call($m, $a)
    {
        $formater = $this->getFormater();

        if (!is_callable(array($formater, $m))) {
            throw new \Zend\Exception(
                'unknown function ' . get_class($this) . '::' . $m . ' called'
            );
        }

        $return = call_user_func_array(array($formater, $m), $a);

        if (strtolower(substr($m, 0, 3)) == 'set') {
            return $this;
        } else {
            return $return;
        }
    }

    /**
     * @param integer $mode the new mode for calculation
     *
     * @return \AppCore\Credit\Output
     * @access public
     */
    public function setMode($mode = self::FALLBACK)
    {
        $modes = array(
            self::FALLBACK,
            self::JS,
            self::IFRAME,
            self::CURL
        );

        $mode = (int) $mode;

        if (in_array($mode, $modes)) {
            $this->_mode = $mode;
        } else {
            /*
             * unknown mode
             * ->use default
             */
            $this->_mode = self::FALLBACK;
        }

        $this->_setFormater($this->_mode);

        return $this;
    }

    /**
     * sets and returnes the formater
     *
     * @param string $mode
     *
     * @return \AppCore\Credit\Output
     */
    private function _setFormater($mode = self::FALLBACK)
    {
        switch ($mode) {
            case self::JS:
                $formater = '\\AppCore\\Credit\\Output\\Js';
                break;
            case self::IFRAME:
                $formater = '\\AppCore\\Credit\\Output\\Iframe';
                break;
            case self::CURL:
                $formater = '\\AppCore\\Credit\\Output\\Curl';
                break;
            case self::FALLBACK:
                // Break intentionally omitted
            default:
                $formater = '\\AppCore\\Credit\\Output\\Fallback';
                break;
        }

        $this->_formater = new $formater();

        return $this;
    }

    /**
     * get the formater, if no formater is defined i will define the default
     * formater
     *
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function getFormater()
    {
        if ($this->_formater === null) {
            $this->_setFormater(self::FALLBACK);
        }

        return $this->_formater;
    }

    /**
     * @param boolean $value the value for the variable
     *
     * @return \AppCore\Credit\Output
     * @access public
     */
    public function setModeName($value)
    {
        $constant = 'self::' . strtoupper($value);

        if (defined($constant)) {
            /*
             * Mode is defined
             */
            $this->setMode(constant($constant));
        } else {
            /*
             * Mode is not defined
             * -> use default
             */
            $this->setMode();
        }

        $formater = $this->getFormater();
        $formater->setModeName($value);

        return $this;
    }
}