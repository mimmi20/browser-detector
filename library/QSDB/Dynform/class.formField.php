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
 * @category	misc
 * @package		TYPO3
 * @subpackage	tm_classes
 * @file		class.formField.php
 * @created		Feb 16, 2007
 * @version		1.1
 * @author		Wagner O. Wutzke
 * @author		Thomas Mueller <thomas.mueller@telemotive.de>
 * @copyright	2006-2007 Telemotive AG, Germany, Munich
 * @license		http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @see			http://www.phpclasses.org/browse/package/3743.html
 */


// {{{ formField

/**
 * general Form Field Definitions
 *
 * @category	misc
 * @package		TYPO3
 * @subpackage	tm_classes
 * @file		class.formField.php
 * @author		Wagner O. Wutzke
 * @author		Thomas Mueller <thomas.mueller@telemotive.de> TMu
 * @copyright	2006-2007 Telemotive AG, Germany, Munich
 * @license		http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @since		Version 1.1
 * @abstract
 * @changes
 * 20071118		TMu	- Code reformat
 *					- no direct Output from render function, returns string
 */
abstract class formField
{
	// {{{ properties
	
	/**
	 * a name for the field in the form
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $name;
	
	/**
	 * Title to be displayed to the field
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $caption;
	
	/**
	 * The datatype for the inputText fields. No relevance for other field types
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $datatype;
	
	/**
	 * If the field must receive an user input or not
	 *
	 * @access	protected
	 * @var		boolean
	 */
	protected $mandatory;
	
	/**
	 * if the field is to be validated or not
	 *
	 * @access	protected
	 * @var		boolean
	 */
	protected $validate;
	
	/**
	 * the message that is diplayed on validation error. This message 
	 * is internally generated. This is just for internal use.
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $errorMsg;
	
	/**
	 * the default value to be shown on the field
	 *
	 * @access	protected
	 * @var		mixed
	 */
	protected $defaultValue;
	
	/**
	 * @access protected
	 * @var bool if the field is editable or not
	 */
	protected $editable;
	
	/**
	 * field width in pixel (or other measurements like %, em ... which are allowed
	 * in HTML Code)
	 * defualt: 150px
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $width = "150px";
	
	
	/**
	 * the current value for the field. This is just for internal use.
	 *
	 * @access	protected
	 * @var		mixed
	 */
	protected $value = "";
	
	// }}}
	// {{{ __construct
	
	/**
	 * Default constructor for this class
	 *
	 * @access	public
	 * @param	string	$name			default = "field1"
	 * @param	string	$caption		default = "field1"
	 * @param	string	$datatype		default = "string"
	 * @param	boolean	$mandatory		default = false
	 * @param	boolean	$validate		default = false
	 * @param	string	$errorMsg		default = ""
	 * @param	mixed	$defaultValue	default = ""
	 * @param	boolean	$editable		default = true
	 * @param	string	$width			default = 150px
	 */
	public function __construct
		($name			= "field1",
		$caption		= "field1",
		$datatype		= "string",
		$mandatory		= false,
		$validate		= false,
	 	$defaultValue	= "",
		$editable		= true,
		$width			= "150px") 
	{
		$this->name			= (string)	$name;
		$this->caption		= (string)	$caption;
		$this->datatype		= (string)	$datatype;
		$this->mandatory	= (boolean)	$mandatory;
		$this->validate		= (boolean)	$validate;
		$this->defaultValue	= (string)	$defaultValue;
		$this->editable		= (boolean)	$editable;
		$this->width		= (string)	$width;
	}
	
	// }}}
	// {{{ getValue
	
	/**
	 * returns the value property
	 *
	 * @access	public
	 * @return	mixed
	 */
	public function getValue()
	{
		return $this->value;
	}
	
	// }}}
	// {{{ setValue
	
	/**
	 * sets the value property
	 *
	 * @access	public
	 * @param	string	$value
	 * @return	void
	 */
	public function setValue($value)
	{
		return $this->value = (string) $value;
	}
	
	// }}}
	// {{{ isPosted
	
	/**
	 * returns if the var is set in the $_POST array
	 *
	 * @access	public
	 * @return	boolean
	 */
	public function isPosted()
	{
		return isset($_POST[$this->name]);
	}
	
	// }}}
	// {{{ getFormData
	
	/**
	 * returns the posted value for this field
	 *
	 * @access	public
	 * @return	mixed
	 */
	public function getFormData()
	{
		return $_POST[$this->name];
	}
	
	// }}}
	// {{{ isEmpty
	
	/**
	 * returns if the value property is empty
	 *
	 * @access	public
	 * @return	boolean
	 */
	public function isEmpty()
	{
		return empty($_POST[$this->name]);
	}
	
	// }}}
	// {{{ getErrorMsg
	
	/**
	 * returns the errorMsg property
	 *
	 * @access	public
	 * @return	string
	 */
	public function getErrorMsg()
	{
		return $this->errorMsg;
	}
	
	// }}}
	// {{{ setErrorMsg
	
	/**
	 * sets the errorMsg property
	 *
	 * @access	public
	 * @param	string	$message
	 * @return	string
	 */
	public function setErrorMsg($message)
	{
		return $this->errorMsg = $message;
	}
	
	// }}}
	// {{{ isMandatory
	
	/**
	 * returns if this is a mandatory field
	 *
	 * @access	public
	 * @return	boolean
	 */
	public function isMandatory()
	{
		return $this->mandatory;
	}
	
	// }}}
	// {{{ setMandatory
	
	/**
	 * sets the field mandatory attribute
	 *
	 * @access	public
	 * @param	boolean	$value
	 * @return	boolean
	 */
	public function setMandatory($value)
	{
		return $this->mandatory = (boolean) $value;
	}
	
	// }}}
	// {{{ mustValidate
	
	/**
	 * Returns if this field must be validated
	 *
	 * @access	public
	 * @return	boolean
	 */
	public function mustValidate()
	{
		return $this->validate;
	}

	// }}}
	// {{{ setValidate
	
	/**
	 * sets the field validation attribute
	 *
	 * @access	public
	 * @param	boolean	$value
	 * @return	boolean
	 */
	public function setValidate($value)
	{
		return $this->validate = (boolean) $value;
	}

	// }}}
	// {{{ hasDefaultValue
	
	/**
	 * Returns if this field has a default value
	 *
	 * @access	public
	 * @return	boolean
	 */
	public function hasDefaultValue()
	{
		return $this->defaultValue != "";
	}
	
	// }}}
	// {{{ setDefaultValue
	
	/**
	 * sets the defaultValue property
	 *
	 * @access	public
	 * @param	string	$value
	 * @return	string
	 */
	public function setDefaultValue($value)
	{
		return $this->defaultValue = (string) $value;
	}
	
	// }}}
	// {{{ setWidth
	
	/**
	 * sets the defaultValue property
	 *
	 * @access	public
	 * @param	string	$value
	 * @return	string
	 */
	public function setWidth($value)
	{
		return $this->width = (string) $value;
	}
	
	// }}}
	// {{{ isEditable
	
	/**
	 * Returns if this field is editable
	 *
	 * @access	public
	 * @return	boolean
	 */
	public function isEditable()
	{
		return $this->editable;
	}
	
	// }}}
	// {{{ setEditable
	
	/**
	 * sets the field editable attribute
	 *
	 * @access	public
	 * @param	boolean	$value
	 * @return	boolean
	 */
	public function setEditable($value)
	{
		return $this->editable = (boolean) $value;
	}
	
	// }}}
	// {{{ validate
	
	/**
	 * Returns if there was no problem on the field validation.
	 *
	 * Function must be implemented in the subclasses.
	 *
	 * @abstract
	 * @access	public
	 * @return	boolean
	 */
	public abstract function validate();
	
	// }}}
	// {{{ render
	
	/**
	 * Renders the field on the form. Function must be implemented in the subclasses
	 *
	 * Function must be implemented in the subclasses.
	 *
	 * @abstract
	 * @access	public
	 * @return	string	HTML-Output
	 */
	public abstract function render();
	
	// }}}
	// {{{ checkValidationPreconditions
	
	/**
	 * Returns if the preconditions for a validation are filled.
	 *
	 * @access	public
	 * @return	bool
	 */
	public function checkValidationPreconditions()
	{
		/*
		if (!$this->isPosted()) {
			return true;
		}
		*/
		if (!$this->isMandatory() && !$this->validate) {
			return true;
		} elseif (!$this->isMandatory() && $this->validate && $this->isEmpty()) {
			return true;
		} else if($this->isMandatory() && $this->isEmpty()) {
			$this->setErrorMsg(" field '". $this->caption . "' is mandatory");
			return false;
		} elseif ($this->validate && $this->isEmpty()) {
			$this->setErrorMsg(" field '". $this->caption . "' should not be empty");
			return false;
		} else {
			return true;
		}
	}
	
	// }}}
	// {{{ showYou
	
	/**
	 * Just show the Object data for debuging purpose
	 *
	 * @access	public
	 * @return	void
	 * @param	string	$class	the object class name to be displayed
	 */
	public function showYou($class)
	{
		$refClass	= new ReflectionClass ($class);
		$properties	= $refClass->getProperties();
		print "\n<div style=\"border:1px solid #000000; font-size:12px; width:300px; margin:10px; padding:10px; float:left;\">";
		foreach($properties as $key => $value) {
			print "\n\t" . $value->getName() . ": ";
			print "\n\t" . $value->getValue($this) . "<br />";
		}
		print "\n</div>";
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