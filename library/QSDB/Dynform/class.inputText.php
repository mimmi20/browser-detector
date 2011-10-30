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
 * @file        class.inputText.php
 * @created        Feb 16, 2007
 * @version        1.1
 * @author        Wagner O. Wutzke
 * @author        Thomas Mueller <thomas.mueller@telemotive.de>
 * @copyright    2006-2007 Telemotive AG, Germany, Munich
 * @license        http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @see            http://www.phpclasses.org/browse/package/3743.html
 */

require_once "class.formField.php";

// {{{ inputText

/**
 * Input Field
 *
 * @category    misc
 * @package        TYPO3
 * @subpackage    tm_classes
 * @file        class.inputText.php
 * @author        Wagner O. Wutzke
 * @author        Thomas Mueller <thomas.mueller@telemotive.de> TMu
 * @copyright    2006-2007 Telemotive AG, Germany, Munich
 * @license        http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @since        Version 1.1
 * @changes
 * 20071118        TMu    - Code reformat
 *                    - no direct Output from render function, returns string
 */
class inputText extends formField
{
    // {{{ __construct
    
    /**
     * Default constructor for this class
     *
     * @access    public
     * @param    string    $name            default = "inputText"
     * @param    string    $caption        default = "field1"
     * @param    string    $datatype        default = "string"
     * @param    boolean    $mandatory        default = false
     * @param    boolean    $validate        default = false
     * @param    mixed    $defaultValue    default = ""
     * @param    boolean    $editable        default = true
     * @param    string    $width            default = "150px"
     */
    public function __construct
        ($name            = "inputText",
        $caption        = "field1",
        $datatype        = "string",
        $mandatory        = false,
        $validate        = false,
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
     * returns if the valclassation was correct
     *
     * @access    public
     * @return    boolean
     */
    public function validate()
    {
        
        if (! $this->checkValidationPreconditions()) {
            return false;
        } else {
            $this->setValue($this->getFormData());
            
            if ($this->datatype == "numeric") {
                
                $this->setValue(str_replace(",", ".", $this->getValue()));
                
                if (!(is_numeric($this->getValue()))) {
                    $this->setErrorMsg(" field '". $this->caption . "' must be a valclass number");
                    return false;
                } else 
                    return true;
            } elseif ($this->datatype == "string") { // hier muss ein filter eingebaut werden
                return true;
            } elseif ($this->datatype == "password") {
                return true;
            } elseif ($this->datatype == "mail") {
                if (!$this->isMandatory() && $this->isEmpty()) {
                    return true;
                }
                
                if (!($this->isValclassMail($this->getValue()))) {
                    $this->setErrorMsg(" field '". $this->caption . "' must be a valclass mail");
                    return false;
                } else {
                    return true;
                }
            }
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
        if ($this->isPosted() && $this->mustValclassate())
            $this->validate();
        */
        $output .= "\n\t<div class=\"dynformFieldRow\">";
        $output .= "\n\t\t<div class=\"dynformLabel\">" . $this->caption . ": </div>";
        
        $output .= "\n\t\t<div class=\"dynformInput\"> <input name=\"" . $this->name . "\" ";
        
        /* check for the type for this field */
        if ($this->datatype == "password") {
            $output .= "type=\"password\" ";
        } else {
            $output .= "type=\"text\" ";
        }
        
        /* Check for a value for this field */
        if ($this->hasDefaultValue() || (! $this->isEditable())) {
            $output .= "value=\"" . $this->defaultValue . "\"";
        } elseif ($this->isPosted()) {
            $output .= "value=\"" . $this->getValue() . "\"";
        } else {
            $output .= "value=\"\"";
        }
        
        if (! $this->isEditable()) {
            $output .= " readonly";
        }
        
        $output .= " style=\"width:$this->width\"/></div>";
        
        
        /* display the errorMsg, if it is set */
        if ($this->getErrorMsg() != "") {
            $output .= "\n\t\t<div class=\"dynformMessage\">" . $this->getErrorMsg() . "</div>";
        }
        
        $output .= "\n\t</div>";
        
        return $output;
    }
    
    // }}}
    // {{{ isValclassMail
    
    /**
     * returns if $mail contains a valclass mail
     *
     * @access    public
     * @return    boolean
     * @param    string    $mail    The string to be validated
     */
    public function isValclassMail($mail)
    {
        return (eregi("^[a-zA-Z0-9]+[_a-zA-Z0-9-]*(\.[_a-z0-9-]+)*@[a-z0-9]+(-[a-z0-9]+)*(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $mail));
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