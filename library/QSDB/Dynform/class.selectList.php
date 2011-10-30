<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2006-2007 Thomas Mueller <thomas.mueller@telemotive.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Plugin 'Telemotive Classes' for the 'tm_classes' extension.
 *
 * PHP version 5
 *
 * @category    misc
 * @package        TYPO3
 * @subpackage    tm_classes
 * @file        class.selectList.php
 * @created        Feb 16, 2007
 * @version        1.1
 * @author        Wagner O. Wutzke
 * @author        Thomas Mueller <thomas.mueller@telemotive.de>
 * @copyright    2006-2007 Telemotive AG, Germany, Munich
 * @license        http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @see            http://www.phpclasses.org/browse/package/3743.html
 */

require_once "class.formField.php";

// {{{ selectList

/**
 * Select List
 *
 * @category    misc
 * @package        TYPO3
 * @subpackage    tm_classes
 * @file        class.selectList.php
 * @author        Wagner O. Wutzke
 * @author        Thomas Mueller <thomas.mueller@telemotive.de> TMu
 * @copyright    2006-2007 Telemotive AG, Germany, Munich
 * @license        http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @since        Version 1.1
 * @changes
 * 20071118        TMu    - Code reformat
 *                    - no direct Output from render function, returns string
 */
class selectList extends formField
{
    // {{{ properties
    
    /**
     * This is an array with option name and option value fields for the list
     */
    private $list = null;
    
    // }}}
    // {{{ __construct
    
    /**
     * Default constructor for this class
     *
     * @access    public
     * @param    string    $name            default = "list"
     * @param    string    $caption        default = "List"
     * @param    string    $datatype        default = "", has no effect
     * @param    boolean    $mandatory        default = true
     * @param    boolean    $validate        default = true
     * @param    mixed    $defaultValue    default = ""
     * @param    boolean    $editable        default = true
     * @param    string    $width            default = "150px"
     */
    public function __construct
        ($name            = "list",
        $caption        = "List",
        $datatype        = "string",
        $mandatory        = true,
        $validate        = true,
        $defaultValue    = "",
        $editable        = true,
        $width            = "150px") 
    {
        $this->name            = (string)    $name;
        $this->caption        = (string)    $caption;
        $this->datatype        = (string)    $datatype;
        $this->mandatory    = (boolean)    $mandatory;
        $this->validate        = (boolean)    $validate;
        $this->defaultValue    = (string)    $defaultValue;
        $this->editable        = (boolean)    $editable;
        $this->width        = (string)    $width;
    }
    
    // }}}
    // {{{ validate
    
    /**
     * returns if the validation was correct
     *
     * @access    public
     * @return    bool
     */
    public function validate()
    {
        return ( $this->checkValidationPreconditions() );
    }
    
    // }}}
    // {{{ setList
    
    /**
     * Sets the array $list with given value
     *
     * @access    public
     * @param    array    $list    It must be an array with the format value=>display
     *                            where value is the key and display the the content
     *                            to be shown on the list.
     */
    public function setList($list)
    {
        if ( is_array( $list ) ) {
            $this->list = $list;
        } else {
            $this->list = null;
        }
    }

    // }}}
    // {{{ render
    
    /**
     * @access    public
     * @return    string    HTML-Output
     */
    public function render()
    {
        $output = '';
        $this->setValue($this->getFormData());
        /*
        if ($this->isPosted() && $this->mustValidate())
            $this->validate();
        */
        $output .= "\n\t<div class=\"dynformFieldRow\">";
        $output .= "\n\t\t<div class=\"dynformLabel\">" . $this->caption . ": </div>";
        
        $output .= "\n\t\t<div class=\"dynformInput\">";
        $output .= "\n\t\t<select name=\"" . $this->name. "\"";
        
        if (!$this->editable) {
            $output .= " disabled=\"disabled\"";
        }
        
        $output .= " style=\"width:$this->width\">";
        
        $output .= "\n\t\t\t<option value=\"\">please select</option>";
        
        if ($this->list != NULL) {
            foreach ($this->list as $key=>$value) {
                $output .= "\n\t\t\t<option value=\"". $key . "\"";
                
                if ($this->isPosted() && $this->getValue() == $key) {
                    $output .= " selected";
                } elseif (!$this->isPosted() && $this->defaultValue == $key) {
                    $output .= " selected";
                }
                
                $output .= ">" . $value ."</option>";
            }
        }
        
        $output .= "\n\t\t</select>";
        $output .= "\n\t\t</div>";
        
        
        /* display the errorMsg, if it is set */
        if ($this->getErrorMsg() != "") {
            $output .= "\n\t\t<div class=\"dynformMessage\">" . $this->getErrorMsg() . "</div>";
        }
        
        $output .= "\n\t</div>";
        
        return $output;
    }
    
    // }}}
}

// }}}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
?>