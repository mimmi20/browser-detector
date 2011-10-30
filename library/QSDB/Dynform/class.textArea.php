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
 * @file        class.textArea.php
 * @created        Feb 16, 2007
 * @version        1.1
 * @author        Wagner O. Wutzke
 * @author        Thomas Mueller <thomas.mueller@telemotive.de>
 * @copyright    2006-2007 Telemotive AG, Germany, Munich
 * @license        http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @see            http://www.phpclasses.org/browse/package/3743.html
 */

require_once "class.formField.php";

// {{{ textArea

/**
 * Textarea
 *
 * @category    misc
 * @package        TYPO3
 * @subpackage    tm_classes
 * @file        class.textArea.php
 * @author        Wagner O. Wutzke
 * @author        Thomas Mueller <thomas.mueller@telemotive.de> TMu
 * @copyright    2006-2007 Telemotive AG, Germany, Munich
 * @license        http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @since        Version 1.1
 * @changes
 * 20071118        TMu    - Code reformat
 *                    - no direct Output from render function, returns string
 */
class textArea extends formField
{
    // {{{ properties
    
    /**
     * If the textarea shows a Rich text editor tool or not
     *
     * @access    private
     * @var        bool
     */
    protected $wysiwyg = NULL;
    
    /**
     * The width for the text area
     *
     * @access    private
     * @var        string
     */
    protected $width = "100%";
    
    /**
     * The height for the text area
     *
     * @access    private
     * @var        string
     */
    protected $height = "";
    
    /**
     * The base path for fckeditor folder. Default is "fckeditor/"
     *
     * @access    private
     * @var        string
     */
    private $basePath = 'fckeditor/';
    
    // }}}
    // {{{ __construct
    
    /**
     * constructor for this class
     *
     * @access    public
     * @param    string    $name            default = "textArea"
     * @param    string    $caption        default = "TextArea"
     * @param    string    $datatype        default = "", has no effect
     * @param    boolean    $mandatory        default = false
     * @param    boolean    $validate        default = false
     * @param    string    $defaultValue    default = ""
     * @param    boolean    $editable        default = true
     * @param    string    $width            default = "550px"
     */
    public function __construct
        ($name            = "textArea",
        $caption        = "TextArea", 
        $datatype        = "",
        $mandatory        = false,
        $validate        = false, 
        $defaultValue    = "", 
        $editable        = true,
        $width            = "") 
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
     * @access    public
     * @return    boolean    returns if the validation was correct
     */
    public function validate()
    {
        return ($this->checkValidationPreconditions());
    }
    
    // }}}
    // {{{ setWysiwyg
    
    /**
     * @access    public
     * @return    void    sets if the text area shows the rich text editor tool or not
     * @param    boolean    $val hmmm... a cup of coffee wouldn´t be bad now...
     */
    public function setWysiwyg($val)
    {
        $this->wysiwyg = (boolean) $val; 
    }
    
    // }}}
    // {{{ setWidth
    
    /**
     * sets a new Width
     *
     * @access    public
     * @param    string    $val    the new Width
     */
    public function setWidth($val)
    {
        $this->width = (string) $val;
    }
    
    // }}}
    // {{{ setHeight
    
    /**
     * sets a new Height
     *
     * @access    public
     * @param    string    $val    the new Height
     */
    public function setHeight($val)
    {
        $this->height = (string) $val;
    }
    
    // }}}
    // {{{ setBasePath
    
    /**
     * Sets the base path for the wysiwyg tool
     *
     * @access public
     * @param    string    $path    the new Base Path
     */
    public function setBasePath($path)
    {
        $this->basePath = (string) $path;
    }
    
    // }}}
    // {{{ render
    
    /**
     * renders the form element
     *
     * @return    string    HTML-Output
     * @access public
     */
    public function render()
    {
        
        $output = '';
        $this->setValue($this->getFormData());
        
        if ($this->wysiwyg && $this->editable) {
            
            require_once $this->basePath . "fckeditor.php";
            
            $oFCKeditor = new FCKeditor($this->name) ;
            $oFCKeditor->BasePath = $this->basePath;
            
            if ($this->isPosted())
                $oFCKeditor->Value = $this->value;
            else
                $oFCKeditor->Value = $this->defaultValue;
                
            $oFCKeditor->Width  = $this->width ;
            $oFCKeditor->Height = $this->height ;
            
            $output .= "\n\t<div>";
            //$output .= "\n\t\t<div class=\"dynformLabel\">" . $this->caption . ": </div>";
            $output .= "\n\t\t<div class=\"dynformTextArea\">";
            $output .= $oFCKeditor->Create() ;
            $output .= "\n\t\t</div>";
            $output .= "\n\t</div>";
        }
        else {
            /*
            if ($this->isPosted() && $this->mustValidate())
                $this->validate();
            */
            
            $output .= "\n\t<div>";
            //$output .= "\n\t\t<div class=\"dynformLabel\">" . $this->caption . ": </div>";
            $output .= "\n\t\t<div class=\"dynformTextArea\">";
            //$output .= "<textarea name=\"" . $this->name . "\"";
            
            if (! $this->isEditable()) {
                //$output .= " readonly=\"readonly\"" ;
            }
            //$output .= " style=\"width:$this->width; height:$this->height\">";
            
            
            /* Check for a value for this field */
            if ($this->hasDefaultValue() || (! $this->isEditable()))
                $output .= $this->defaultValue;
            else if ($this->isPosted())
                $output .= $this->getValue();
            else
                $output .= "&nbsp;";
        
            //$output .= "</textarea>";
            $output .= "</div>";

            /* display the errorMsg, if it is set */
            if ($this->getErrorMsg() != "")
                $output .= "\n\t\t<div class=\"dynformMessage\">" . $this->getErrorMsg() . "</div>";
            $output .= "\n\t</div>";
        }
        
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