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
 * @file        class.inputDate.php
 * @created        Feb 16, 2007
 * @version        1.1
 * @author        Wagner O. Wutzke
 * @author        Thomas Mueller <thomas.mueller@telemotive.de>
 * @copyright    2006-2007 Telemotive AG, Germany, Munich
 * @license        http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @see            http://www.phpclasses.org/browse/package/3743.html
 */

require_once "class.formField.php";

// {{{ inputDate

/**
 * Input Field
 *
 * @category    misc
 * @package        TYPO3
 * @subpackage    tm_classes
 * @file        class.inputDate.php
 * @author        Wagner O. Wutzke
 * @author        Thomas Mueller <thomas.mueller@telemotive.de> TMu
 * @copyright    2006-2007 Telemotive AG, Germany, Munich
 * @license        http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @since        Version 1.1
 * @changes
 * 20071118        TMu    - Code reformat
 *                    - no direct Output from render function, returns string
 */
class inputDate extends formField
{
    // {{{ properties
    
    /**
     * The base path for fckeditor folder. Default is "jscalendar/"
     *
     * @access    private
     * @var        string
     */
    private $basePath = "jscalendar/";
    
    // }}}
    // {{{ __construct
    
    /**
     * Default constructor for this class
     *
     * @access    public
     * @param    string    $name            default = "inputDate"
     * @param    string    $caption        default = "Date"
     * @param    string    $datatype        default = "" , has no effect
     * @param    boolean    $mandatory        default = false
     * @param    boolean    $validate        default = false
     * @param    mixed    $defaultValue    default = ""
     * @param    boolean    $editable        default = true
     * @param    string    $width            default = "150px"
     */
    public function __construct
        ($name            = "inputDate",
        $caption        = "Date", 
        $datatype        = "",
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
    // {{{ setBasePath
    
    /**
     * sets the base path for the calendar tool
     *
     * @access    public
     * @param    string    $path        the new Base Path
     */
    public function setBasePath($path)
    {
        $this->basePath = (string) $path;
    }
    
    // }}}
    // {{{ validate
    
    /**
     * returns if the validation was correct
     *
     * @access    public
     * @return    boolean
     */
    public function validate()
    {
        return ($this->checkValidationPreconditions());
    }

    // }}}
    // {{{ render
    
    /**
     * @access    public
     * @return    string    HTML-Output
     */
    public function render() 
    {
        
        require_once $this->basePath . "calendar.php";
        
        $output = '';
        
        $calendar = new DHTML_Calendar ($this->basePath, "en", "calendar-system");
        
        $this->setValue($this->getFormData());
        
        $output .= "\n\t<div class=\"dynformFieldRow\">";
        
        $output .= $calendar->get_load_files_code();
        
        //print "\n\t\t<div class=\"dynformLabel\">" . $this->caption . ": </div>";
        
        $output .= "\n\t\t<div class=\"dynformInput\">" ;
        $output .= "\n\t\t\t<input name=\"" . $this->name . "\" id=\"" . $this->name . "\" type=\"text\" ";
        
        /* Check for a value for this field */
        if ($this->hasDefaultValue() || (! $this->isEditable()))
            $output .= "value=\"" . $this->defaultValue . "\"";
        else if ($this->isPosted())
            $output .= "value=\"" . $this->getValue() . "\"";
        else
            $output .= "value=\"\"";
            
        $output .= " readonly=\"yes\" style=\"width:$this->width\" />";
        
        if ($this->editable) {
            $output .= "\n\t\t\t<a href=\"#\" id=\"trigger\"><img src=\"".$this->basePath ."img.gif\" border=\"0\"></a>"; 
        
            $output .= "\n\t\t\t<a href=\"#\" onClick=\"getElementById('$this->name').value='';\"><img src=\"".$this->basePath ."delete.png\" border=\"0\"></a>"; 
        
            $output .= $calendar->_make_calendar(array("inputField"=>$this->name , "ifFormat"=>"%d.%m.%Y", "button"=>"trigger"));
        }
        
        $output .= "\n\t\t</div>";
        
        /* display the errorMsg, if it is set */
        if ($this->getErrorMsg() != "")
            $output .= "\n\t\t<div class=\"dynformMessage\">" . $this->getErrorMsg() . "</div>";
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