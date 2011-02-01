<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\View\Helper;

/**
 * View-Helper
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   View_Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */


/**
 * @category  Kreditrechner
 * @package   View_Helper
 * @author    Monte Ohrt <monte at ohrt dot com>
 */
class IncludeFile extends \Zend\View\Helper\AbstractHelper
{
    public $paid = null;
    public $caid = null;
    public $mode = null;

    /**
     * includes a file or a list of files
     *
     * @param string|array $files the absolute path for a file or a group of
     *                            files
     *
     * @return string  the file content
     * @access public
     */
    public function includeFile($files = null, $paid = '', $caid = '', $mode = '')
    {
        if (!is_string($files) && !is_array($files)) {
            return '';
        }

        if (!is_array($files)) {
            $files = array($files);
        }

        //backup the variables
        $oldPaid = $this->paid;
        $oldCaid = $this->caid;
        $oldMode = $this->mode;

        //set new values to the variables
        $this->paid = $paid;
        $this->caid = $caid;
        $this->mode = $mode;

        if (!\Zend\Registry::isRegistered('_imageUrl')) {
            \AppCore\Globals::defineImageUrl($paid, $caid);
        }

        $content = '';

        //include the files
        foreach ($files as $file) {
            $content .= $this->_load($file);
        }

        //restore the variables
        $this->paid = $oldPaid;
        $this->caid = $oldCaid;
        $this->mode = $oldMode;

        return $this->_format($this->_parseFile($content));
    }
    
    /**
     * Strategy pattern: helper method to invoke
     *
     * @return mixed
     */
    public function direct($files = null, $paid = '', $caid = '', $mode = '')
    {
        return $this->includeFile($files, $paid, $caid, $mode);
    }

    /**
     * includes a file
     *
     * @param string $file the absolute path for the file
     *
     * @return string  the file content
     * @access private
     */
    private function _load($file)
    {
        //$logger = \Zend\Registry::get('log');
        //$logger->info($file);

        if (!is_string($file)
            || $file == ''
            || !file_exists($file)
            || !is_file($file)
        ) {
            return '';
        }

        $content = '';

        ob_start();
        include $file;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * formats the content string for the spefied output
     *
     * @param string  $text the text to format
     * @param boolean $full if TRUE also ' will be replaced
     *
     * @return string the formated output
     * @access private
     */
    private function _format($text)
    {
        /*
        $text = str_replace("\t", ' ', $text);
        $text = str_replace("\r\n", ' ', $text);
        $text = str_replace("\r", ' ', $text);
        $text = str_replace("\n", ' ', $text);
        $text = preg_replace('/\s\s+/', ' ', $text);
        $text = trim($text);
        /**/

        return $text;
    }

    /**
     * __call-Methode wird aufgerufen wenn keine Action angegeben wurde
     *
     * @param string $m the called method
     * @param array  $a the given parameters
     *
     * @access public
     * @return void
     * @throws KreditCore_Class_Exception
     */
    public function __call($m, $a)
    {
        return call_user_func_array(array($this->view, $m), $a);
    }

    /**
     * __get-Methode wird aufgerufen wenn eine unbekannte Variable abgefragt
     * wird
     *
     * @param string $var the called variable
     *
     * @access public
     * @return void
     */
    public function __get($var)
    {
        return $this->view->$var;
    }

    /**
     * __set-Methode wird aufgerufen wenn eine unbekannte Variable gesetzt
     * wird
     *
     * @param string $var   the called variable
     * @param string $value the value to set to the variable
     *
     * @access public
     * @return void
     */
    public function __set($var, $value)
    {
        $this->view->$var = $value;
    }

    /**
     * Get controller params
     *
     * @return object
     */
    private function _parseFile($content)
    {
        if ($content == '') {
            return $content;
        }

        if (strpos($content, '###IMAGE_URL###') !== false) {
            $content = str_replace(
                '###IMAGE_URL###',
                \Zend\Registry::get('_imageUrl'),
                $content
            );
        }

        if (strpos($content, '###HOME_URL###') !== false) {
            $content = str_replace(
                '###HOME_URL###',
                \Zend\Registry::get('_home'),
                $content
            );
        }

        if (strpos($content, '###URL_DIR###') !== false) {
            $content = str_replace(
                '###URL_DIR###',
                \Zend\Registry::get('_urlDir'),
                $content
            );
        }

        if (strpos($content, '###IMAGE_URL_ROOT###') !== false) {
            $content = str_replace(
                '###IMAGE_URL_ROOT###',
                \Zend\Registry::get('_imageUrlRoot'),
                $content
            );
        }

        return $content;
    }
}