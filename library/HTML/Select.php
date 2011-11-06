<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * HTML <select> element class
 *
 * PHP version 4
 *
 * @category HTML
 * @package  HTML_Select
 * @author   Adam Daniel <adaniel1@eesus.jnj.com>
 * @license  PHP License http://php.net/license
 * @version  SVN: $Id$
 * @link     http://pear.php.net/package/HTML_Select
 */

require_once 'PEAR.php';
require_once 'HTML/Common.php';

/**
 * Class to dynamically create an HTML SELECT
 *
 * @category HTML
 * @package  HTML_Select
 * @author   Adam Daniel <adaniel1@eesus.jnj.com>
 * @license  PHP License http://php.net/license
 * @link     http://pear.php.net/package/HTML_Select
 */
class HTML_Select extends HTML_Common
{
    
    /**
     * Contains the select options
     *
     * @var       array
     * @since     1.0
     * @access    private
     */
    private $_options = array();
    
    /**
     * Default values of the SELECT
     * 
     * @var       string
     * @since     1.0
     * @access    private
     */
    private $_values = array();

    /**
     * Class constructor
     *
     * @param string  $name       Name attribute of the SELECT
     * @param integer $size       Size attribute of the SELECT
     * @param boolean $multiple   Whether the select will allow multiple 
     *                            selections or not
     * @param mixed   $attributes Either a typical HTML attribute string 
     *                            or an associative array
     * @param integer $tabOffset  Number of tabs to offset HTML source
     *
     * @since  1.0
     */
    function HTML_Select(
        $name = '', $size = 1, $multiple = false,
        $attributes = null, $tabOffset = 0
    ) {
        HTML_Common::HTML_Common($attributes, $tabOffset);
        $attr = array(
            'name' => $name,
            'size' => $size
        );

        if ($this->getAttribute('id') === null) {
            $attr['id'] = $name;
        }
        if ($multiple) {
            $attr['multiple'] = 'multiple';
        }
        $this->updateAttributes($attr);
        $this->setSelectedValues(array());
    }
    
    /**
     * Returns the current API version 
     * 
     * @since     1.0
     * @return    double
     */
    function apiVersion()
    {
        return 1.3;
    }

    /**
     * Sets the default values of the select box
     *
     * @param mixed $values Array or comma delimited string of selected values
     *
     * @since  1.0
     * @return void
     */
    function setSelectedValues($values)
    {
        if (is_string($values)) {
            $values = split("[ ]?,[ ]?", $values);
        }
        if (!is_array($values)) {
            $values = array($values);
        }
        $this->_values = $values;
    }

    /**
     * Returns an array of the selected values
     *
     * @since     1.0
     * @return    array of selected values
     */
    function getSelectedValues()
    {
        return $this->_values;
    }

    /**
     * Adds a new OPTION to the SELECT
     *
     * @param string  $text       Display text for the OPTION
     * @param string  $value      Value for the OPTION
     * @param boolean $selected   Whether the option is selected or not
     * @param mixed   $attributes Either a typical HTML attribute string 
     *                            or an associative array
     *
     * @since  1.0
     * @return void
     *
     * @see addStartOptionGroup()
     * @see addStopOptionGroup()
     */
    function addOption($text, $value, $selected = false, $attributes = null)
    {
        if ($selected && !in_array($value, $this->_values)) {
            $this->_values[] = $value;
        }
        
        $attributes = $this->_parseAttributes($attributes);
        $attr['value'] = $value;
        $this->_updateAttrArray($attributes, $attr);
        $this->_options[] = array('text' => $text, 'attr' => $attributes);
    }

    /**
     * Starts an option group "<optgroup>"
     *
     * @param string $text       Label
     * @param array  $attributes HTML attribute associative array
     *
     * @return void
     * @since  1.3.0
     *
     * @see addOptionGroup()
     */
    function addStartOptionGroup($text, $attributes = null)
    {
        if (!isset($attributes['label'])) {
            $attributes['label'] = $text;
        }
        $this->_options[] = array(
            'type' => 'optgroup',
            'attr' => $attributes
        );
    }

    /**
     * Stops an option group "</optgroup>"
     *
     * @return void
     * @since  1.3.0
     *
     * @see addStartOptionGroup()
     */
    function addStopOptionGroup()
    {
        $this->_options[] = array(
            'type' => '/optgroup',
        );
    }
    
    /**
     * Loads the options from an associative array
     * 
     * @param array $arr    Associative array of options
     * @param mixed $values Array or comma delimited string of selected values
     *
     * @since  1.0
     * @return PEAR_Error on error or true
     * @throws PEAR_Error
     */
    function loadArray($arr, $values = null)
    {
        if (!is_array($arr)) {
            return new PEAR_ERROR(
                'First argument to HTML_Select::loadArray is not a valid array'
            );
        }
        if (isset($values)) {
            $this->setSelectedValues($values);
        }
        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                $this->addStartOptionGroup($key);
                foreach ($value as $subkey => $subvalue) {
                    $this->addOption($subkey, $subvalue);
                }
                $this->addStopOptionGroup();
            } else {
                $this->addOption($key, $value);
            }
        }
        return true;
    }
    
    /**
     * Loads the options from an array with numeric keys, using the
     * array values as the form values as well as labels.
     * 
     * @param array $arr    Array of options
     * @param mixed $values Array or comma delimited string of selected values
     *
     * @since  1.2
     * @return PEAR_Error on error or true
     * @throws PEAR_Error
     */
    function loadValueArray($arr, $values = null)
    {
        if (!is_array($arr)) {
            return new PEAR_Error(
                "First argument to HTML_Select::loadArray is not a valid array"
            );
        }
        if (isset($values)) {
            $this->setSelectedValues($values);
        }

        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                $this->addStartOptionGroup($key);
                foreach ($value as $subvalue) {
                    $this->addOption($subvalue, $subvalue);
                }
                $this->addStopOptionGroup();
            } else {
                $this->addOption($value, $value);
            }
        }
        return true;
    }
    
    /**
     * Loads the options from DB_result object
     * 
     * If no column names are specified the first two columns of the result are
     * used as the text and value columns respectively
     *
     * @param object &$result  DB_result object 
     * @param string $textCol  Name of column to display as the OPTION text 
     * @param string $valueCol Name of column to use as the OPTION value 
     * @param mixed  $values   Array or comma delimited string of selected values
     *
     * @since     1.0
     * @return    PEAR_Error on error or true
     * @throws    PEAR_Error
     */
    function loadDbResult(&$result, $textCol=null, $valueCol=null, $values=null)
    {
        include_once 'DB.php';
        
        if (!is_object($result)
            || (strtolower(get_class($result)) != "db_result"
            && is_subclass_of($result, "db_result"))
        ) {
            return new PEAR_Error(
                'First argument to HTML_Select::loadDbResult'
                . ' is not a valid DB_result'
            );
        }
        if (isset($values)) {
            $this->setSelectedValues($values);
        }
        $fetchMode = ($textCol && $valueCol)
            ? DB_FETCHMODE_ASSOC
            : DB_FETCHMODE_DEFAULT;
        while (is_array($row = $result->fetchRow($fetchMode)) ) {
            if ($fetchMode == DB_FETCHMODE_ASSOC) {
                $this->addOption($row[$textCol], $row[$valueCol]);
            } else {
                $this->addOption($row[0], $row[1]);
            }
        }
        return true;
    }
    
    /**
     * Queries a database and loads the options from the results
     *
     * @param mixed  &$conn    Either an existing DB connection or a valid dsn 
     * @param string $sql      SQL query string
     * @param string $textCol  Name of column to display as the OPTION text 
     * @param string $valueCol Name of column to use as the OPTION value 
     * @param mixed  $values   Array or comma delimited string of selected values
     *
     * @since  1.1
     * @access private
     * @return void
     */
    function loadQuery(&$conn, $sql, $textCol=null, $valueCol=null, $values=null)
    {
        include_once 'DB.php';
        
        if (is_string($conn)) {
            $dbConn = &DB::connect($conn, true);
            if (DB::isError($dbConn)) {
                return $dbConn;
            }
        } elseif (is_subclass_of($conn, "db_common")) {
            $dbConn = $conn;
        } else {
            return $this->raiseError(
                "Argument 1 of HTML_Select::loadQuery is not a valid type"
            );
        }
        $result = @$dbConn->query($sql);
        if (DB::isError($result)) {
            return $result;
        }
        return $this->loadDbResult($result, $textCol, $valueCol, $values);
    }

    /**
     * Loads options from different types of data sources
     *
     * This method is a simulated overloaded method.
     * The arguments, other than the first are optional and only mean
     * something depending on the type of the first argument.
     * If the first argument is an array then all arguments are passed
     * in order to loadArray.
     * If the first argument is a db_result then all arguments are
     * passed in order to loadDbResult.
     * If the first argument is a string or a DB connection then
     * all arguments are passed in order to loadQuery.
     *
     * @param mixed &$options Options source currently supports assoc
     *                        array or DB_result
     * @param mixed $param1   See function detail
     * @param mixed $param2   See function detail
     * @param mixed $param3   See function detail
     * @param mixed $param4   See function detail
     *
     * @since  1.1
     * @return PEAR_Error on error or true, or false if no method to load
     *         the data could be determined.
     * @throws PEAR_Error
     */
    function load(&$options, $param1=null, $param2=null, $param3=null, $param4=null)
    {
        if (is_array($options)) {
            return $this->loadArray($options, $param1);
        } else if (strtolower(get_class($options)) == "db_result"
            || is_subclass_of($options, "db_result")
        ) {
            return $this->loadDbResult($options, $param1, $param2, $param3);
        } else if (is_string($options)
            || is_subclass_of($options, "db_common")
        ) {
            return $this->loadQuery($options, $param1, $param2, $param3, $param4);
        }

        return false;
    }
    
    /**
     * Returns the SELECT in HTML
     *
     * @since  1.0
     * @return string HTML code
     */
    function toHtml()
    {
        $tabs = $this->_getTabs();
        $name = $this->_attributes['name'];
        $strHtml = $tabs;
        if ($this->_comment) {
            $strHtml .= "<!-- $this->_comment -->\n$tabs";
        }
        $strHtml .=
            '<select' . $this->_getAttrString($this->_attributes) . '>';
        foreach ($this->_options as $option) {
            if (isset($option['type'])) {
                if ($option['type'] == 'optgroup') {
                    $strHtml .= '<optgroup'
                        . $this->_getAttrString($option['attr'])
                        . '>';
                } else {
                    $strHtml .= '</optgroup>';
                }
                continue;
            }
            if (@in_array($option['attr']['value'], $this->_values)) {
                $option['attr']['selected'] = 'selected';
            }
            $attrString = $this->_getAttrString($option['attr']);
            $strHtml .=
                '<option' . $attrString . '>' .
                htmlspecialchars($option['text']) . '</option>';
        }
        $strHtml .= '</select>';
        return $strHtml;
    }
    
}
?>
