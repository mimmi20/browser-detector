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
 * @file        class.dynForm.php
 * @created        Feb 16, 2007
 * @version        1.1
 * @author        Wagner O. Wutzke
 * @author        Thomas Mueller <thomas.mueller@telemotive.de>
 * @copyright    2006-2007 Telemotive AG, Germany, Munich
 * @license        http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @see            http://www.phpclasses.org/browse/package/3743.html
 */

require_once "class.formField.php";
require_once "class.inputDate.php";
require_once "class.inputFile.php";
require_once "class.inputHidden.php";
require_once "class.inputText.php";
require_once "class.selectList.php";
require_once "class.submitButton.php";
require_once "class.textArea.php";

// {{{ Dynform

/**
 * Form
 *
 * @category    misc
 * @package        TYPO3
 * @subpackage    tm_classes
 * @file        class.dynForm.php
 * @author        Wagner O. Wutzke
 * @author        Thomas Mueller <thomas.mueller@telemotive.de> TMu
 * @copyright    2006-2007 Telemotive AG, Germany, Munich
 * @license        http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @since        Version 1.1
 * @changes
 * 20071118        TMu    - Code reformat
 *                    - no direct Output from render function, returns string
 */ 
class Dynform
{
    // {{{ properties
    
    /**
     * @access    private
     * @var        string    name for the form
     */
    private $name;
    
    /**
     * @access    private
     * @var        string action for the form
     */
    private $action;
    
    /**
     * @access    private
     * @var        bool if the form should be validated
     */
    private $validate;
    
    /**
     * @access    private
     * @var        string title to be displayed over the form
     */
    private $title;
    
    /**
     * @access    private
     * @var        formField[] Array with the form field objects
     */
    private $fields;
    
    // }}}
    // {{{ __construct
    
    /**
     * constructor for this class
     *
     * @access    public
     * @param    string    $name            default = "form"
     * @param    string    $action            default = ""
     * @param    boolean    $validate        default = false
     * @param    string    $title            default = ""
     * @param    boolean    $hasFiles        default = false
     */
    public function __construct
        ($name        = "form",
        $action        = "",
        $validate    = true,
        $title        = "",
        $hasFiles    = false)
    {
        $this->name        = (string)    $name;
        $this->action    = (string)    $action;
        $this->validate    = (boolean)    $validate;
        $this->title    = (string)    $title;
        $this->hasFiles    = (boolean)    $hasFiles;
        
        $this->fields    = array();
    }
    
    // }}}
    // {{{ getName
    
    /**
     * Setter and getter Methods for all properties but the fields array
     */
    public function getName()
    {
        return $this->name;
    }
    
    // }}}
    // {{{ getAction
    
    public function getAction()
    {
        return $this->action;
    }
    
    // }}}
    // {{{ getValidate
    
    public function getValidate()
    {
        return $this->validate;
    }
    
    // }}}
    // {{{ getTitle
    
    public function getTitle()
    {
        return $this->title;
    }
    
    // }}}
    // {{{ setName
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    // }}}
    // {{{ setAction
    
    public function setAction($action)
    {
        $this->action = $action;
    }
    
    // }}}
    // {{{ setValidate
    
    public function setValidate($validate)
    {
        $this->validate = $validate;
    }
    
    // }}}
    // {{{ setTitle
    
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    // }}}
    // {{{ addField
    
    /**
     * add the object $formField to the $fields array with the key $fieldname
     *
     * @access    public
     * @return    void
     * @param    string        $fieldname    The key name for the field object in the
     *                                    array. I recomend to use the name of 
     *                                    the form element as key.
     * @param    formField    $formField    the formField object to be added to the form
     */
    public function addField($fieldName, formField $formField)
    { 
        $this->fields[$fieldName] = $formField;
    }
    
    // }}}
    // {{{ removeField
    
    /**
     * removes the formField object with the key $fieldName from the $fields array
     *
     * @access    public
     * @return    void
     */
    public function removeField($fieldName) 
    { 
        unset($this->fields[$fieldName]);
    }
    
    // }}}
    // {{{ render
    
    /**
     * renders the form calling the render method of all form elemets
     *
     * @access    public
     * @return    string    HTML-Output
     */
    public function render()
    {
        $output        = '';
        $hasFiles    = false;
        
        /* check for formFields of type fileField */
        foreach($this->fields as $key => $value) {
            if ($value instanceof inputFile) {
                $hasFiles = true;
                break;
            }
        }
        
        /*
         * form was posted, if validation is ok, do something with the posted data
         */
        if (!empty($_POST)) {
            if ($this->validate()) {
                //header("Location: $this->action");
                //exit();
            }
            
        }
        
        $output .= "\n\n<!---  # # # # # # # #   START OF FORM $this->name   # # # # # # # #  --->\n";
        
        //$array = get_browser(null, true);
        //$browser = $array['browser'];
        
        /*
        if ($browser == 'Firefox')
            $output .= "\n<link rel=\"stylesheet\" type=\"text/css\" href=\"../common/phpDynform/styles.dynform.moz.css\">";
        else
            $output .= "\n<link rel=\"stylesheet\" type=\"text/css\" href=\"../common/phpDynform/styles.dynform.ie.css\">";
        */
        
        $output .= "\n<div class=\"dynform\">";
        $output .= "\n<div class=\"title\">$this->title</div>";
        $output .= "\n<form name=\"".$this->name ."\" method=\"post\" action=\"".$this->action."\"";
        
        if ($hasFiles) {
            $output .= " enctype=\"multipart/form-data\"";
        }
        $output .= ">";
        
        foreach ($this->fields as $field => $fieldObj) {
            $output .= $fieldObj->render();
        }
        
        $output .= "\n</form>";
        $output .= "\n</div>";
        $output .= "\n\n<!---  END OF FORM $this->name  --->\n";
        
        return $output;
    }
    
    // }}}
    // {{{ validate
    
    /**
     * return if all fields are valid, calling the validate method of all form elemets
     *
     * @access    public
     * @return    boolean
     */
    public function validate() {
        
        if (empty($_POST)) {
            return true;
        }
        
        if (!$this->validate) {
            return true;
        }
        
        $validated = true;
        
        foreach ($this->fields as $field => $fieldObj) {
            if ( !$fieldObj->validate())
                $validated = false;
        }
        
        return $validated;
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