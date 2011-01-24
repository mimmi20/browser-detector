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
 * @version   SVN: $Id: HtmlOptions.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * @category  Kreditrechner
 * @package   View_Helper
 * @author    Monte Ohrt <monte at ohrt dot com>
 */
class HtmlOptions extends \Zend\View\Helper\AbstractHelper
{
    /**
     * creates an option list from an array
     *
     * @param array        $data
     * @param string|array $selected
     *
     * @return string
     */
    public function htmlOptions(array $data = array(), $selected = array())
    {
        $content = '';

        if (!is_array($selected)) {
            $selected = array($selected);
        }

        foreach ($data as $key => $value) {
            $content .= $this->_optoutput($key, $value, $selected);
        }

        return $content;
    }
    
    /**
     * Strategy pattern: helper method to invoke
     *
     * @return mixed
     */
    public function direct(array $data = array(), $selected = array())
    {
        return $this->htmlOptions($data, $selected);
    }

    /**
     * parses the array
     *
     * @param string $key
     * @param string $value
     * @param array  $selected
     *
     * @return string
     */
    private function _optoutput($key, $value, $selected)
    {
        $content = '';

        if (!is_array($value)) {
            $content .= '<option label="' . htmlentities($value)
                           . '" value="' . htmlentities($key) . '"';

            if (in_array((string)$key, $selected)) {
                $content .= ' selected="selected"';
            }

            $content .= '>' . htmlentities($value) . '</option>' . "\n";
        } else {
            $content .= '<optgroup label="' . htmlentities($key) . '">';

            foreach ($value as $keyLoop => $valueLoop) {
                $content .= $this->_optoutput($keyLoop, $valueLoop, $selected);
            }

            $content .= '</optgroup>' . "\n";
        }

        return $content;
    }
}