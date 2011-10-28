<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {html_options} function plugin
 *
 * Type:     function<br>
 * Name:     html_options<br>
 * Input:<br>
 *           - name       (optional) - string default "select"
 *           - values     (required if no options supplied) - array
 *           - options    (required if no values supplied) - associative array
 *           - selected   (optional) - string default not set
 *           - output     (required if not options supplied) - array
 * Purpose:  Prints the list of <option> tags generated from
 *           the passed parameters
 * @link http://smarty.php.net/manual/en/language.function.html.options.php {html_image}
 *      (Smarty online manual)
 * @author Monte Ohrt <monte at ohrt dot com>
 * @param array
 * @param Smarty
 * @return string
 * @uses smarty_function_escape_special_chars()
 */class Unister_View_Helper_HtmlOptions extends Zend_View_Helper_Abstract{
    public function htmlOptions(array $data, array $selected = array())
    {
        $_html_result = '';        foreach ($data as $_key => $_val) {
            $_html_result .= $this->optoutput($_key, $_val, $selected);
        }

        return $_html_result;

    }

    protected function optoutput($key, $value, $selected)    {
        $_html_result = '';        if (!is_array($value)) {
            $_html_result = '<option label="' . htmlentities($value) . '" value="' .
                htmlentities($key) . '"';
            if (in_array((string)$key, $selected))
                $_html_result .= ' selected="selected"';
            $_html_result .= '>' . htmlentities($value) . '</option>' . "\n";
        }
        return $_html_result;
    }
}
/* vim: set expandtab: */
