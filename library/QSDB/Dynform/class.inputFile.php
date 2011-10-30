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
 * @file        class.inputFile.php
 * @created        Feb 16, 2007
 * @version        1.1
 * @author        Wagner O. Wutzke
 * @author        Thomas Mueller <thomas.mueller@telemotive.de>
 * @copyright    2006-2007 Telemotive AG, Germany, Munich
 * @license        http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @see            http://www.phpclasses.org/browse/package/3743.html
 */

require_once "class.formField.php";

// {{{ inputFile

/**
 * Input Field type:file
 *
 * @category    misc
 * @package        TYPO3
 * @subpackage    tm_classes
 * @file        class.inputFile.php
 * @author        Wagner O. Wutzke
 * @author        Thomas Mueller <thomas.mueller@telemotive.de> TMu
 * @copyright    2006-2007 Telemotive AG, Germany, Munich
 * @license        http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @since        Version 1.1
 * @changes
 * 20071118        TMu    - Code reformat
 *                    - no direct Output from render function, returns string
 */
class inputFile extends formField
{
    // {{{ __construct
    
    /**
     * Default constructor for this class
     *
     * @access    public
     * @param    string    $name            default = "hidden"
     * @param    string    $caption        default = "", has no effect
     * @param    string    $datatype        default = "", has no effect
     * @param    boolean    $mandatory        default = false
     * @param    boolean    $validate        default = false
     * @param    mixed    $defaultValue    default = "", has no effect
     * @param    boolean    $editable        default = true, has no effect
     * @param    string    $width            default = "260px"
     */
    public function __construct
        ($name            = "file",
        $caption        = "File", 
        $datatype        = "",
        $mandatory        = false,
        $validate        = false, 
        $defaultValue    = "",
        $editable        = true,
        $width            = "260px") 
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
        if (empty($_FILES)) {
            return true;
        } elseif ($_FILES[$this->name]['name'] == "") {
            $this->setErrorMsg(" field '". $this->caption . "' is mandatory");
            return false;
        } else {
            return true;
        }
    }
    
    // }}}
    // {{{ render
    
    /**
     * @access public
     * @return    string    HTML-Output
     */
    public function render()
    {
        $output  = '';
        $output .= "\n\t<div class=\"dynformFieldRow\">";
        $output .= "\n\t\t<div class=\"dynformLabel\">" . $this->caption . ": </div>";
        $output .= "\n\t\t<div class=\"dynformInput\">";
        $output .= "\n\t\t<input name=\"". $this->name ."\" type=\"file\" style=\"width:$this->width\">";
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